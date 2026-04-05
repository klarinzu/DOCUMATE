<div class="max-w-3xl mx-auto mt-10 bg-white p-6 rounded-xl shadow space-y-4">

    <h2 class="text-xl font-bold text-gray-700">
        Student Re-Verification
    </h2>

    <p class="text-sm text-gray-500">
        Upload your enrollment slip and review verification results.
    </p>

    <!-- FORM -->
    <form wire:submit.prevent="verify" class="space-y-3">

        <input type="file" wire:model="e_slip" class="w-full border p-2 rounded">

        @error('e_slip')
            <div class="text-red-500 text-sm">{{ $message }}</div>
        @enderror

        <button type="submit"
            wire:loading.attr="disabled"
            class="bg-blue-600 text-white px-4 py-2 rounded w-full">
            Verify Account
        </button>

    </form>

    <!-- LOADING -->
    <div wire:loading wire:target="verify" class="text-blue-600 text-sm">
        ⏳ Processing OCR...
    </div>

    <!-- RESULTS -->
    @if(!empty($matchDetails))

        <!-- SCORE -->
        <div class="p-3 bg-gray-100 rounded text-center">
            <p class="text-lg font-bold">
                Match Score: {{ $matchScore }}%
            </p>

            @if($isVerified)
                <p class="text-green-600 font-semibold">✔ VERIFIED</p>
            @else
                <p class="text-red-600 font-semibold">✖ NOT VERIFIED</p>
            @endif
        </div>

        <!-- TABLE -->
        <div class="overflow-x-auto border rounded">
            <table class="w-full text-sm">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="p-2 text-left">Field</th>
                        <th class="p-2 text-left">OCR</th>
                        <th class="p-2 text-left">Your Data</th>
                        <th class="p-2 text-center">Match</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach([
                        'student_number' => 'Student Number',
                        'first_name' => 'First Name',
                        'last_name' => 'Last Name',
                        'college' => 'College',
                        'course' => 'Course',
                        'year' => 'Year Level',
                        'semester' => 'Semester',
                        'academic_year' => 'Academic Year',
                        'officially_enrolled' => 'Enrolled Stamp'
                    ] as $key => $label)

                        @php
                            $ocrValue = $ocrResult[$key] ?? '—';

                            $userValue = match($key) {
                                'course' => auth()->user()->program,
                                'college' => auth()->user()->college,
                                'year' => auth()->user()->year_level,
                                'semester' => currentSemester(),
                                'academic_year' => currentAcademicYear(),
                                'officially_enrolled' => 'Required',
                                default => auth()->user()->{$key} ?? '—',
                            };

                            $match = $matchDetails[$label] ?? false;
                        @endphp

                        <tr class="border-t {{ $match ? 'bg-green-50' : 'bg-red-50' }}">
                            <td class="p-2 font-medium">{{ $label }}</td>

                            <td class="p-2">
                                {{ is_bool($ocrValue) ? ($ocrValue ? 'Detected' : 'Not Detected') : $ocrValue }}
                            </td>

                            <td class="p-2">
                                {{ is_bool($userValue) ? ($userValue ? 'Required' : '—') : $userValue }}
                            </td>

                            <td class="p-2 text-center">
                                @if($match)
                                    <span class="text-green-600 font-bold">✔</span>
                                @else
                                    <span class="text-red-600 font-bold">✖</span>
                                @endif
                            </td>
                        </tr>

                    @endforeach

                </tbody>
            </table>
        </div>

        <!-- RESULT MESSAGE -->
        @if($isVerified)  
            <div class="p-4 bg-green-100 text-green-700 rounded space-y-3">

                <div class="font-semibold">
                    ✔ Verification successful! Your account is now active.
                </div>

                <button
                    wire:click="goToSystem"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded w-full">

                    Continue to System
                </button>

            </div>

        @else
            <div class="p-3 bg-red-100 text-red-700 rounded">
                ✖ Verification failed. Please upload a valid enrollment slip.
            </div>
        @endif

    @endif

</div>