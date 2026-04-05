<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Setting;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class Dashboard extends Component
{
    public $current_semester;
    public $academic_year;
    public $verification_start_date;
    public $verification_end_date;
    public function rules()
    {
        return [
            'current_semester' => 'required',
            'academic_year' => 'required',
            'verification_start_date' => 'required|date',
            'verification_end_date' => 'required|date|after_or_equal:verification_start_date',
        ];
    }
    public function messages()
    {
        return [
            'verification_end_date.after_or_equal' => 'End date must be after or equal to start date.',
        ];
    }

    public function mount()
    {
        $setting = systemSetting();

        if ($setting) {
            $this->current_semester = $setting->current_semester;
            $this->academic_year = $setting->academic_year;
            $this->verification_start_date = $setting->verification_start_date;
            $this->verification_end_date = $setting->verification_end_date;
        }
        if (!$this->academic_year) {
            $year = now()->year;
            $this->academic_year = $year . '-' . ($year + 1);
        }
    }
    public function updated($propertyName)
    {
        try {
            $this->validateOnly($propertyName);
        } catch (ValidationException $e) {
            $this->dispatch(
                'alert',
                type: 'error',
                message: collect($e->validator->errors()->all())->first()
            );
        }
    }


    public function save()
        {
            $this->validate();

            if ($this->verification_start_date === $this->verification_end_date) {
                session()->flash('warning', 'Verification is only open for 1 day.');
                $this->dispatch('alert', type: 'warning', message: 'Verification is only open for 1 day.');
            }
            $latest = systemSetting();
            $newVersion = $latest?->verification_version + 1 ?? 1;

            Setting::create([
                'current_semester' => $this->current_semester,
                'academic_year' => $this->academic_year,
                'verification_start_date' => $this->verification_start_date,
                'verification_end_date' => $this->verification_end_date,
                'verification_version' => $newVersion,
            ]);

            // 🔥 CORE LOGIC: deactivate all non-admin users
            User::whereHas('role', function ($q) {
                $q->where('role_name', '!=', 'Admin');
            })->update([
                'account_status' => 'inactive'
            ]);

            session()->flash('message', 'Settings updated & users reset for verification.');

            $this->dispatch('alert', type: 'success', message: 'Verification period set. Users must re-verify.');
        }
    public function render()
    {
        return view('livewire.admin.dashboard')->layout('layouts.app', ['title' => 'Dashboard']);
    }
}
