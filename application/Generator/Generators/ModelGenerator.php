<?php

namespace Application\Generator\Generators;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ModelGenerator
{
    private $replacors = [];
    private $columns;
    private $relations;

    private $stub;

    public function __construct($data)
    {
        $this->stub = base_path('application/Generator/Stubs/ModuleModel.txt');

        $this->replacors['__moduleType__'] = $data['moduleType'];
        $this->replacors['__moduleNamePlural__'] = $data['moduleNamePlural'];
        $this->replacors['__moduleNameSingular__'] = $data['moduleNameSingular'];
        $this->replacors['__moduleDirectory__'] = $data['moduleDirectory'];
        $this->replacors['__moduleNamespace__'] = $data['moduleNamespace'];

        $this->columns = $data['columns'];
        $this->relations = $data['relations'];

        $this->generateFillables();
        $this->generateRelationsData();
        $this->generateRelationsImportNamespaces();

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
        $file_content = file_get_contents($this->stub);

        $file_content = $this->replacor($file_content);

        $module_type = $this->replacors['__moduleType__'];
        $moduleName = $this->replacors['__moduleNamePlural__'];
        $location = base_path() . $this->replacors['__moduleDirectory__']  . '/Models/';
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

    private function generateRelationsData() {
        $functions = "";
        foreach ($this->relations as $relation) {
            $function_name = Str::snake($relation['module']);
            $functions .= "
    public function $function_name() {
      return \$this->${relation['type']}(${relation['moduleNameSingular']}::class);
    }";
        }

        $this->replacors['__moduleRelationshipFunctions__'] = $functions;
    }

    private function generateRelationsImportNamespaces() {
        $namespace_info = "";
        foreach ($this->relations as $relation) {
            $namespace = 'use Application\\Modules\\';
            $module_model_name = $relation['moduleNameSingular'] ;
            $module_name = $relation['moduleNamePlural'] ;
            if ($relation['location'] == 'Core') {
                $namespace .= "Core\\";
            } else if ($relation['location'] == 'System') {
                $namespace .= "System\\";
            } else if ($relation['location'] == 'DevConfigs') {
                $namespace .= "Configurations\\DevConfigs\\Tabs\\";
            } else if ($relation['location'] == 'SysConfigs') {
                $namespace .= "Configurations\\SysConfigs\\Tabs\\";
            }

            $namespace .= "$module_name\\Models\\$module_model_name;";
            $namespace_info .= "$namespace \n";
        }

        $this->replacors['__moduleRelationshipNamespaces__'] = $namespace_info;
    }


}