<?php

namespace App\Livewire\Admin\Templates;

use Livewire\Component;
use App\Models\Template;

class TemplateEditor extends Component
{
    public $template;
    public $version;
    public $fields = [];
    public $selectedFieldId = null;
    protected $listeners = ['refreshFields' => '$refresh'];

    public function mount($template)
    {
        $this->template = Template::with('currentVersion')->findOrFail($template);
        $this->version = $this->template->currentVersion;

        // ✅ LOAD FROM VERSION (if exists)
        if ($this->version && $this->version->fields) {
            $this->fields = is_array($this->version->fields) ? $this->version->fields : [];
        }
    }
    public function updatingFields($value, $key)
    {
        // prevent unwanted resets
    }

    public function addField($type)
    {
        $id = uniqid();

        $this->fields[$id] = [
            'id' => $id,
            'type' => $type,
            'x' => 100,
            'y' => 100,
            'width' => 150,
            'height' => 50,
            'text' => strtoupper($type),
        ];
    }

    public function render()
    {
        return view('livewire.admin.templates.template-editor')->layout('layouts.editor');;
        // ❗ NO ->layout() here (standalone page)
    }
}