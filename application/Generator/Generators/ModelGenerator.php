<?php

namespace Application\Generator\Generators;

use Illuminate\Support\Facades\File;

class ModelGenerator
{
    private $replacors = [];
    private $columns;

    private $controllerStub;

    public function __construct($data)
    {
        $this->controllerStub = base_path('application/Generator/Stubs/ModuleModel.txt');

        $this->replacors['__moduleType__'] = $data['moduleType'];
        $this->replacors['__moduleNamePlural__'] = $data['moduleNamePlural'];
        $this->replacors['__moduleNameSingular__'] = $data['moduleNameSingular'];

        $this->columns = $data['columns'];

        $this->generateFillables();

        $this->generate();
    }

    private function generateFillables()
    {
        $key = '__moduleFillableList__';

        $this->replacors[$key] = "\n";
        foreach ($this->columns as $column) {
//            $rule_line = " 'name', 'name2' ";
            $this->replacors[$key] .= "\t\t";
            $this->replacors[$key] .= "'${column['name']}',\n";
        }
    }

    private function generate()
    {
        $file_content = file_get_contents($this->controllerStub);

        $file_content = $this->replacor($file_content);

        $module_type = $this->replacors['__moduleType__'];
        $moduleName = $this->replacors['__moduleNamePlural__'];
        $location = base_path() . '/application/Modules/' . $module_type . '/' . $moduleName . '/Models/';
        if (!File::exists($location)) {
            File::makeDirectory($location, 0755, true);
        }
        $file_name = $this->replacors['__moduleNameSingular__'] . '.php';
        $file = $location . $file_name;
        file_put_contents($file, $file_content);
    }

    private function replacor($content)
    {

        foreach ($this->replacors as $key => $value) {

            $content = str_replace($key, $value, $content);

        }

        return $content;

    }
}