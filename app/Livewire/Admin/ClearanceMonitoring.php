<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Livewire\Component;

class ClearanceMonitoring extends Component
{
    public string $search = '';
    public string $semesterFilter = '';
    public string $statusFilter = '';
    public string $academicYearFilter = '';
    public string $organizationFilter = '';
    public string $yearFilter = '';
    public string $dateFrom = '';
    public string $dateTo = '';
    public bool $showFilters = false;
    public bool $showDetailsModal = false;
    public ?array $selectedRecord = null;
    public int $currentPage = 1;
    public int $perPage = 10;

    public function updated($property): void
    {
        if (in_array($property, [
            'search',
            'semesterFilter',
            'statusFilter',
            'academicYearFilter',
            'organizationFilter',
            'yearFilter',
            'dateFrom',
            'dateTo',
        ], true)) {
            $this->currentPage = 1;
        }
    }

    public function toggleFilters(): void
    {
        $this->showFilters = ! $this->showFilters;
    }

    public function applyFilters(): void
    {
        $this->currentPage = 1;
        $this->showFilters = false;
    }

    public function resetFilters(): void
    {
        $this->reset([
            'search',
            'semesterFilter',
            'statusFilter',
            'academicYearFilter',
            'organizationFilter',
            'yearFilter',
            'dateFrom',
            'dateTo',
        ]);

        $this->currentPage = 1;
        $this->showFilters = false;
    }

    public function previousPage(): void
    {
        if ($this->currentPage > 1) {
            $this->currentPage--;
        }
    }

    public function nextPage(int $totalPages): void
    {
        if ($this->currentPage < $totalPages) {
            $this->currentPage++;
        }
    }

    public function viewRecord(int $userId): void
    {
        $record = $this->buildRecords()->firstWhere('user_id', $userId);

        if (! $record) {
            $this->selectedRecord = null;
            $this->showDetailsModal = false;

            return;
        }

        $this->selectedRecord = $record;
        $this->showDetailsModal = true;
    }

    public function closeDetails(): void
    {
        $this->selectedRecord = null;
        $this->showDetailsModal = false;
    }

    protected function buildRecords(): Collection
    {
        $users = User::with('role')
            ->whereHas('role', function ($query) {
                $query->whereIn('role_name', ['Student', 'Officer']);
            })
            ->orderBy('organization')
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get([
                'id',
                'student_number',
                'first_name',
                'middle_name',
                'last_name',
                'email',
                'program',
                'organization',
                'year_level',
                'account_status',
                'role_id',
                'created_at',
            ]);

        $reviewers = User::with('role')
            ->whereHas('role', function ($query) {
                $query->whereIn('role_name', ['Officer', 'Admin']);
            })
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get(['first_name', 'middle_name', 'last_name'])
            ->map(fn (User $user) => $this->fullName($user))
            ->filter()
            ->values();

        if ($reviewers->isEmpty()) {
            $reviewers = collect(['System Administrator']);
        }

        $statusCycle = ['Cleared', 'Pending', 'Uncleared'];
        $semesterOptions = [$this->primarySemester(), $this->secondarySemester()];
        $academicYearOptions = [$this->primaryAcademicYear(), $this->secondaryAcademicYear()];

        return $users->values()->map(function (User $user, int $index) use ($reviewers, $statusCycle, $semesterOptions, $academicYearOptions) {
            $status = $statusCycle[$index % count($statusCycle)];
            $semester = $semesterOptions[$index % count($semesterOptions)];
            $academicYear = $academicYearOptions[$index % count($academicYearOptions)];
            $taggedAt = Carbon::parse($user->created_at ?? now())
                ->addDays($index + 5)
                ->setTime(9 + ($index % 7), $index % 2 === 0 ? 15 : 45);
            $organization = $user->organization ?: 'Unassigned';
            $taggedBy = $reviewers[$index % $reviewers->count()];

            return [
                'user_id' => $user->id,
                'student_name' => $this->fullName($user),
                'student_number' => $user->student_number ?: 'N/A',
                'program' => $this->formatProgram((string) $user->program),
                'organization' => $organization,
                'status' => $status,
                'academic_year' => $academicYear,
                'semester' => $semester,
                'year_level' => $this->formatYearLevel((string) $user->year_level),
                'year_sort_value' => ctype_digit((string) $user->year_level) ? (int) $user->year_level : 99,
                'tagged_by' => $taggedBy,
                'tagged_at' => $taggedAt->format('F j, Y, g:i a'),
                'tagged_date' => $taggedAt->toDateString(),
                'remarks' => $this->remarksFor($status, $organization),
                'email' => $user->email ?: 'No email on file',
                'account_status' => ucfirst((string) ($user->account_status ?: 'inactive')),
            ];
        })->sortBy(function (array $record) {
            return strtolower($record['organization'] . '|' . $record['student_name']);
        })->values();
    }

    protected function filteredRecords(): Collection
    {
        return $this->buildRecords()
            ->when($this->search !== '', function (Collection $records) {
                $needle = Str::lower($this->search);

                return $records->filter(function (array $record) use ($needle) {
                    return Str::contains(
                        Str::lower(implode(' ', [
                            $record['student_name'],
                            $record['student_number'],
                            $record['organization'],
                            $record['status'],
                        ])),
                        $needle
                    );
                });
            })
            ->when($this->semesterFilter !== '', fn (Collection $records) => $records->where('semester', $this->semesterFilter))
            ->when($this->statusFilter !== '', fn (Collection $records) => $records->where('status', $this->statusFilter))
            ->when($this->academicYearFilter !== '', fn (Collection $records) => $records->where('academic_year', $this->academicYearFilter))
            ->when($this->organizationFilter !== '', fn (Collection $records) => $records->where('organization', $this->organizationFilter))
            ->when($this->yearFilter !== '', fn (Collection $records) => $records->filter(fn (array $record) => (string) ($record['year_sort_value'] ?? '') === $this->yearFilter))
            ->when($this->dateFrom !== '', fn (Collection $records) => $records->filter(fn (array $record) => $record['tagged_date'] >= $this->dateFrom))
            ->when($this->dateTo !== '', fn (Collection $records) => $records->filter(fn (array $record) => $record['tagged_date'] <= $this->dateTo))
            ->sortBy('year_sort_value', SORT_NUMERIC)
            ->values();
    }

    protected function fullName(User $user): string
    {
        return trim(preg_replace('/\s+/', ' ', implode(' ', array_filter([
            $user->first_name,
            $user->middle_name,
            $user->last_name,
        ]))));
    }

    protected function primaryAcademicYear(): string
    {
        if (currentAcademicYear()) {
            return currentAcademicYear();
        }

        $year = now()->year - 1;

        return $year . '-' . ($year + 1);
    }

    protected function secondaryAcademicYear(): string
    {
        [$startYear] = explode('-', $this->primaryAcademicYear());
        $previousStart = ((int) $startYear) - 1;

        return $previousStart . '-' . ($previousStart + 1);
    }

    protected function primarySemester(): string
    {
        $semester = Str::lower((string) currentSemester());

        if (Str::contains($semester, 'first') || Str::contains($semester, '1st')) {
            return 'First';
        }

        return 'Second';
    }

    protected function secondarySemester(): string
    {
        return $this->primarySemester() === 'First' ? 'Second' : 'First';
    }

    protected function formatProgram(string $program): string
    {
        return match ($program) {
            'Bachelor of Science in Information Technology' => 'Bachelor of Science in Information Technology',
            'BSIT' => 'Bachelor of Science in Information Technology',
            '' => 'No program on file',
            default => $program,
        };
    }

    protected function formatYearLevel(string $yearLevel): string
    {
        return match ($yearLevel) {
            '1' => '1st Year',
            '2' => '2nd Year',
            '3' => '3rd Year',
            '4' => '4th Year',
            '', 'N/A' => 'Not set',
            default => $yearLevel,
        };
    }

    protected function remarksFor(string $status, string $organization): string
    {
        return match ($status) {
            'Cleared' => 'No pending organization obligations for ' . $organization . '.',
            'Pending' => 'Awaiting final officer review for ' . $organization . '.',
            'Uncleared' => 'Outstanding clearance requirements remain under ' . $organization . '.',
            default => 'No remarks available.',
        };
    }

    public function render()
    {
        $allRecords = $this->buildRecords();
        $filteredRecords = $this->filteredRecords();
        $totalPages = max(1, (int) ceil($filteredRecords->count() / $this->perPage));
        $this->currentPage = min($this->currentPage, $totalPages);

        $records = $filteredRecords
            ->slice(($this->currentPage - 1) * $this->perPage, $this->perPage)
            ->values();

        return view('livewire.admin.clearance-monitoring', [
            'records' => $records,
            'organizations' => $allRecords->pluck('organization')->unique()->sort()->values(),
            'academicYears' => $allRecords->pluck('academic_year')->unique()->sortDesc()->values(),
            'semesters' => $allRecords->pluck('semester')->unique()->values(),
            'statuses' => collect(['Cleared', 'Pending', 'Uncleared']),
            'totalPages' => $totalPages,
        ])->layout('layouts.app', ['title' => 'Clearance Monitoring']);
    }
}
