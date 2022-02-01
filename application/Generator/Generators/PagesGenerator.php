<?php

namespace Application\Generator\Generators;

use Illuminate\Support\Facades\File;

class PagesGenerator
{
    private $replacors = [];
    private $columns;
    private $custom_id;
    private $relations;

    public function __construct($data)
    {

        $this->replacors['__moduleType__'] = $data['moduleType'];
        $this->replacors['__moduleNamePlural__'] = $data['moduleNamePlural'];
        $this->replacors['__moduleNameSingular__'] = $data['moduleNameSingular'];
        $this->replacors['__moduleNamePluralLower__'] = $data['moduleNamePluralLower'];
        $this->replacors['__moduleNameSingularLower__'] = $data['moduleNameSingularLower'];
        $this->replacors['__moduleDirectory__'] = $data['moduleDirectory'];
        $this->replacors['__moduleNamespace__'] = $data['moduleNamespace'];
        $this->replacors['__moduleDirectoryForViews__'] = $data['moduleDirectoryForViews'];

//        $this->columns = $this->getColumns($data['columns']);
        $this->columns = $data['columns'];
        $this->relations = $data['relations'];
        $this->custom_id = $data['custom_id'];

        $stub = base_path('application/Generator/Stubs/ModuleIndex.txt');
        $this->generateIndexHeaders();
        $this->generate('Views', 'Index.vue', $stub);

        $stub = base_path('application/Generator/Stubs/ModuleCreate.txt');
        $this->generateCreateColumns();
        $this->generateCreateFormRelationProps();
        $this->generate('Views', 'Create.vue', $stub);

        $stub = base_path('application/Generator/Stubs/ModuleEdit.txt');
        $this->generateEditColumns();
        $this->generateEditFormRelationProps();
        $this->generate('Views', 'Edit.vue', $stub);

        $stub = base_path('application/Generator/Stubs/ModuleDetail.txt');
        $this->generate('Views', 'Detail.vue', $stub);
    }

//    private function getColumns($data_columns)
//    {
//        $columns = [];
//        foreach ($data_columns as $column) {
//            if ($column['in_form']) {
//                $columns[] = $column;
//            }
//        }
//
//        return $columns;
//    }

    private function generateIndexHeaders()
    {
        $key = '__moduleIndexHeaders__';

        $this->replacors[$key] = "\n";

        foreach ($this->columns as $column) {
            $relation = $this->getRelationInfo($column['name']);
            if ($relation) {
                $this->replacors[$key] .= "\t\t\t\t";
                $this->replacors[$key] .= " { text: '${column['display_name']}', align: 'start', sortable: true, ";
                $this->replacors[$key] .= " value: '${relation['moduleNameSingularLower']}.${relation['display']}', },  ";
            } else {
                $this->replacors[$key] .= "\t\t\t\t";
                $this->replacors[$key] .= " { text: '${column['display_name']}', align: 'start', sortable: true, value: '${column['name']}', }, ";
            }

            $this->replacors[$key] .= "\n";
        }
    }

    private function getRelationInfo($column_name) {

        foreach ($this->relations as $relation) {

            if ($relation['column'] == $column_name) {
                return $relation;
            }

        }
        return false;
    }

    private function generate($folder, $file_name, $stub)
    {

        $file_content = file_get_contents($stub);

        $file_content = $this->replacor($file_content);

        $module_type = $this->replacors['__moduleType__'];
        $moduleName = $this->replacors['__moduleNamePlural__'];
        $location = base_path() . $this->replacors['__moduleDirectory__']  . '/' . $folder . '/';
        if (!File::exists($location)) {
            File::makeDirectory($location, 0755, true);
        }

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

    private function generateCreateColumns()
    {
        $key = '__moduleCreateColumns__';

        $this->replacors[$key] = "\n";
        foreach ($this->columns as $column) {
//            $rule_line = " name: '', ";
            $this->replacors[$key] .= '        ';
            $this->replacors[$key] .= "${column['name']} : '',";

            $this->replacors[$key] .= "\n";
        }
    }

    private function generateEditColumns()
    {
        $key = '__moduleEditColumns__';

        $this->replacors[$key] = "\n";
        $var = $this->replacors['__moduleNameSingularLower__'];
        foreach ($this->columns as $column) {
//            $rule_line = " id: this.data.id, ";
            $this->replacors[$key] .= '        ';
            $this->replacors[$key] .= "${column['name']} : this.$var.${column['name']},";

            $this->replacors[$key] .= "\n";
        }
    }

    private function generateCreateFormRelationProps()
    {
        $key = '__moduleFormCreateRelationProps__';

        $this->replacors[$key] = "";
        foreach ($this->relations as $relation) {
            $var =  $relation['moduleNamePluralLower'];
            $this->replacors[$key] .= "'$var',";
//            $this->replacors[$key] .= "\n";
        }

        $key = '__moduleFormPassCreateRelationProps__';

        $this->replacors[$key] = "";
        foreach ($this->relations as $relation) {
            $this->replacors[$key] .= "                ";
            $var =  $relation['moduleNamePluralLower'];
            $this->replacors[$key] .= ":$var='$var'";
            $this->replacors[$key] .= "\n";
        }
    }

    private function generateEditFormRelationProps()
    {
        $key = '__moduleFormEditRelationProps__';

        $this->replacors[$key] = "";
        foreach ($this->relations as $relation) {
            $var =  $relation['moduleNamePluralLower'];
            $this->replacors[$key] .= "'$var',";
//            $this->replacors[$key] .= "\n";
        }

        $key = '__moduleFormPassEditRelationProps__';

        $this->replacors[$key] = "";
        foreach ($this->relations as $relation) {
            $this->replacors[$key] .= "                      ";
            $var =  $relation['moduleNamePluralLower'];
            $this->replacors[$key] .= ":$var='$var'";
            $this->replacors[$key] .= "\n";
        }
    }
}