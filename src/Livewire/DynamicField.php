<?php

namespace Uccello\DynamicField\Livewire;

use Livewire\Component;
use Uccello\Core\Models\Module;

class DynamicField extends Component
{
    public $modules;
    public $value;

    public function mount($list)
    {
        $this->getModulesByNames($list);

        $this->value = [

        ];
    }

    public function addField($moduleName, $fieldName, $fieldTranslation)
    {
        $this->value[] = [
            'type' => 'field',
            'module' => $moduleName,
            'name' => $fieldName,
            'translation' => $fieldTranslation
        ];
    }

    public function deleteItem($i)
    {
        unset($this->value[$i]);
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
