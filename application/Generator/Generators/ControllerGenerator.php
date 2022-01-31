<?php

namespace Application\Generator\Generators;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ControllerGenerator
{
    private $replacors = [];
    private $columns;
    private $relations;

    private $stub;

    public function __construct($data)
    {
        $this->stub = base_path('application/Generator/Stubs/ModuleController.txt');

        $this->replacors['__moduleType__'] = $data['moduleType'];
        $this->replacors['__moduleNamePlural__'] = $data['moduleNamePlural'];
        $this->replacors['__moduleNameSingular__'] = $data['moduleNameSingular'];
        $this->replacors['__moduleNamePluralLower__'] = $data['moduleNamePluralLower'];
        $this->replacors['__moduleNameSingularLower__'] = $data['moduleNameSingularLower'];
        $this->replacors['__moduleDirectory__'] = $data['moduleDirectory'];
        $this->replacors['__moduleNamespace__'] = $data['moduleNamespace'];
        $this->replacors['__moduleDirectoryForViews__'] = $data['moduleDirectoryForViews'];

        $this->columns = $this->getColumns($data['columns']);
        $this->relations = $data['relations'];

        $this->generateRules();
        $this->generateIndexData();
        $this->generateCreateData();
        $this->generateEditData();
        $this->generateShowData();
        $this->generateRelationsImportNamespaces();
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
                $table = $this->replacors['__moduleNamePluralLower__'];
                if ($update) {
                    $this->replacors[$key] .= "\Illuminate\Validation\Rule::unique('$table')->ignore(\$request->id),";
                } else {
                    $this->replacors[$key] .= "'unique:$table',";
                }

            }
            $this->replacors[$key] .= "],\n";
        }
    }

    private function generate()
    {
        $file_content = file_get_contents($this->stub);

        $file_content = $this->replacor($file_content);

        $module_type = $this->replacors['__moduleType__'];
        $moduleName = $this->replacors['__moduleNamePlural__'];
        $location = base_path() . $this->replacors['__moduleDirectory__'] . '/Controllers/';
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

    private function generateIndexData() {
        $model =  $this->replacors['__moduleNameSingular__'];
        if (count($this->relations)){
            $relationFunctions = "";
            foreach ($this->relations as $relation) {
                $modelRelationFunction = Str::snake($relation['module']);
                $relationFunctions .= "'$modelRelationFunction',";
            }

            $index_data = "\$view_data['data'] =  $model::with([$relationFunctions])->get();";
        } else {
            $index_data = "\$view_data['data'] = $model::all();";
        }
        $this->replacors['__moduleIndexData__'] = $index_data;
    }

    private function generateShowData() {
        $model =  $this->replacors['__moduleNameSingular__'];
        $show_var = $this->replacors['__moduleNameSingularLower__'];

        if (count($this->relations)){
            $relationFunctions = "";
            foreach ($this->relations as $relation) {
                $modelRelationFunction = Str::snake($relation['module']);
                $relationFunctions .= "'$modelRelationFunction',";
            }

            $show_data = "\n\t\t\$view_data['$show_var'] =  $model::with([$relationFunctions])->where('id', \$id)->first();";
        } else {
            $show_data = "\n\t\t\$view_data['$show_var'] = $model::where('id', \$id)->first();";
        }
        $this->replacors['__moduleShowData__'] = $show_data;
    }

    private function generateEditData() {
        $model =  $this->replacors['__moduleNameSingular__'];
        $edit_var = $this->replacors['__moduleNameSingularLower__'];

        if (count($this->relations)){
            $relationFunctions = "";
            foreach ($this->relations as $relation) {
                $modelRelationFunction = Str::snake($relation['module']);
                $relationFunctions .= "'$modelRelationFunction',";
            }

            $edit_data = "\n\t\t\$view_data['$edit_var'] = $model::with([$relationFunctions])->where('id', \$id)->first();";
        } else {
            $edit_data = "\n\t\t\$view_data['$edit_var'] = $model::where('id', \$id)->first();";
        }

        foreach ($this->relations as $relation) {
            $model =  $relation['moduleNameSingular'];
            $var =  $relation['moduleNamePluralLower'];
            $edit_data .= "\n";
            $edit_data .= "\t\t";
            $edit_data .= "\$view_data['$var'] = $model::all();";
        }

        $this->replacors['__moduleEditData__'] = $edit_data;
    }

    private function generateCreateData() {
        if (count($this->relations)){
            $createData = "";
            foreach ($this->relations as $relation) {
                $model =  $relation['moduleNameSingular'];
                $var =  $relation['moduleNamePluralLower'];
                $createData .= "\t\t";
                $createData .= "\$view_data['$var'] = $model::all();";
                $createData .= "\n";
            }

            $create_data = $createData;
        } else {
            $create_data = "//\$view_data['var'] = Model::all();";
        }
        $this->replacors['__moduleCreateData__'] = $create_data;
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