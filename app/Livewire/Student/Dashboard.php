<?php

namespace App\Livewire\Student;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $user = Auth::user()->loadMissing('role');

        return view('livewire.student.dashboard', [
            'user' => $user,
            'fullName' => trim(preg_replace('/\s+/', ' ', implode(' ', array_filter([
                $user->first_name ?? null,
                $user->middle_name ?? null,
                $user->last_name ?? null,
            ])))),
        ])->layout('layouts.app', ['title' => 'Student Dashboard']);
    }
}
