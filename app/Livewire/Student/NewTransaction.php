<?php

namespace App\Livewire\Student;

use Livewire\Component;

class NewTransaction extends Component
{
    public function render()
    {
        return view('livewire.student.new-transaction')
            ->layout('layouts.app', ['title' => 'New Transaction']);
    }
}
