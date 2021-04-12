<?php

namespace Uccello\DynamicField\Livewire;

use Livewire\Component;
use Uccello\Core\Models\Module;

class FieldVariable extends Component
{
    public $modules;
    public $valueb;

    public function mount($list)
    {
        $this->getModulesByNames($list);

        $this->valueb = [
            ['type' => 'field', 'name' => 'type', 'translation' => 'Type'],
            ['type' => 'text', 'value' => 'Youpi']
        ];
    }

    private function getModulesByNames($moduleNames)
    {
        $this->modules = [];
        foreach ($moduleNames as $moduleName) {
            $module = $this->getModuleByName($moduleName);
            if ($module) {
                $this->modules[] = [
                    'name' => $module->name,
                    'translation' => $module->translation,
                    'fields' => $this->getFieldsWithTranslation($module)
                ];
            }
        }
    }

    private function getModuleByName($name)
    {
        $module = Module::where('name', $name)->first();
        $module->translation = uctrans($module->name, $module);
        return $module;
    }

    private function getFieldsWithTranslation(Module $module)
    {
        return $module->fields()->pluck('name')->map(function ($fieldName) use ($module) {
            return [
                'name' => $fieldName,
                'translation' => uctrans('field.'.$fieldName, $module)
            ];
        });
    }

    public function render()
    {
        return view('dynamic-field::livewire.dynamic-field');
    }
}
