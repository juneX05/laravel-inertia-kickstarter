<?php

namespace Application\Generator\Generators;

use Illuminate\Support\Facades\File;

class ControllerGenerator
{
    private $replacors = [];
    private $columns;

    private $controllerStub;

    public function __construct($data)
    {
        $this->controllerStub = base_path('application/Generator/Stubs/ModuleController.txt');

        $this->replacors['__moduleType__'] = $data['moduleType'];
        $this->replacors['__moduleNamePlural__'] = $data['moduleNamePlural'];
        $this->replacors['__moduleNameSingular__'] = $data['moduleNameSingular'];
        $this->replacors['__moduleNamePluralLower__'] = $data['moduleNamePluralLower'];
        $this->replacors['__moduleNameSingularLower__'] = $data['moduleNameSingularLower'];

        $this->columns = $this->getColumns($data['columns']);

        $this->generateRules();
        $this->generateRules(true);

        $this->generate();
    }

    private function getColumns($data_columns)
    {
        $columns = [];
        foreach ($data_columns as $column) {
            if ($column['in_form']) {
                $columns[] = $column;
            }
        }

        return $columns;
    }

    private function generateRules($update = false)
    {
        if ($update) {
            $key = '__moduleUpdateRules__';
        } else {
            $key = '__moduleCreateRules__';
        }

        $this->replacors[$key] = "\n";
        foreach ($this->columns as $column) {
//            $rule_line = " 'name' => ['required','string','unique','max:50'] ";
            $this->replacors[$key] .= "\t\t\t";
            $this->replacors[$key] .= "'${column['name']}' => [";

            if ($column['not_null'] == true) {
                $this->replacors[$key] .= "'required',";
            } else {
                $this->replacors[$key] .= "'nullable',";
            }

            $this->replacors[$key] .= "'${column['type']}',";

            if ($column['size'] != null) {
                $this->replacors[$key] .= "'max:${column['size']}',";
            }

            if ($column['unique']) {

                if ($update) {
                    $this->replacors[$key] .= "'unique',";
                } else {
                    $this->replacors[$key] .= "'unique',";
                }

            }
            $this->replacors[$key] .= "],\n";
        }
    }

    private function generate()
    {
        $file_content = file_get_contents($this->controllerStub);

        $file_content = $this->replacor($file_content);

        $module_type = $this->replacors['__moduleType__'];
        $moduleName = $this->replacors['__moduleNamePlural__'];
        $location = base_path() . '/application/Modules/' . $module_type . '/' . $moduleName . '/Controllers/';
        if (!File::exists($location)) {
            File::makeDirectory($location, 0755, true);
        }
        $file_name = $this->replacors['__moduleNameSingular__'] . 'Controller.php';
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