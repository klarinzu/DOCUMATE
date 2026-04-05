<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\Role;

class ManageUsers extends Component
{
    use WithPagination;

    public $search = '';
    public $roleFilter = '';
    public $statusFilter = '';

    public $selectedUser = null;
    public $showModal = false;

    protected $paginationTheme = 'tailwind';

    public function updatingSearch() { $this->resetPage(); }
    public function updatingRoleFilter() { $this->resetPage(); }
    public function updatingStatusFilter() { $this->resetPage(); }

    
    public function openModal($userId)
    {
        $this->selectedUser = User::find($userId);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedUser = null;
    }
    public function updateRole($userId, $roleId)
    {
        $user = User::findOrFail($userId);

        if ($user->id === auth()->id()) {
            session()->flash('message', 'You cannot change your own role.');
            return;
        }

        $user->role_id = $roleId;
        $user->save();

        session()->flash('message', 'Role updated.');
    }

    public function toggleStatus($userId)
    {
        $user = User::findOrFail($userId);

        if ($user->id === auth()->id()) {
            session()->flash('message', 'You cannot disable your own account.');
            return;
        }

        $user->account_status = $user->account_status === 'active' ? 'inactive' : 'active';
        $user->save();

        session()->flash('message', 'Status updated.');
    }

    public function render()
    {
        $users = User::with('role')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('first_name', 'like', '%' . $this->search . '%')
                    ->orWhere('middle_name', 'like', '%' . $this->search . '%')
                    ->orWhere('last_name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('student_number', 'like', '%' . $this->search . '%')
                    ->orWhere('program', 'like', '%' . $this->search . '%')
                    ->orWhere('organization', 'like', '%' . $this->search . '%')
                    ->orWhere('college', 'like', '%' . $this->search . '%')
                    ->orWhere('year_level', 'like', '%' . $this->search . '%')
                    ->orWhere('academic_status', 'like', '%' . $this->search . '%')
                    ->orWhere('account_status', 'like', '%' . $this->search . '%')
                    ->orWhereHas('role', function ($q2) {
                        $q2->where('role_name', 'like', '%' . $this->search . '%');
                    });
                });
            })
            ->when($this->roleFilter, function ($query) {
                $query->where('role_id', $this->roleFilter);
            })
            ->when($this->statusFilter !== '', function ($query) {
                $status = $this->statusFilter == '1' ? 'active' : 'inactive';
                $query->where('account_status', $status);
            })
            ->paginate(15);

        $roles = Role::orderBy('role_name')->get();

        return view('livewire.admin.manage-users', [
            'users' => $users,
            'roles' => $roles
        ])->layout('layouts.app', ['title' => 'Manage Users']);
    }
}