<?php

namespace Application\Generator\Generators;

use Illuminate\Support\Facades\File;

class PagesGenerator
{
    private $replacors = [];
    private $columns;

    public function __construct($data)
    {

        $this->replacors['__moduleType__'] = $data['moduleType'];
        $this->replacors['__moduleNamePlural__'] = $data['moduleNamePlural'];
        $this->replacors['__moduleNameSingular__'] = $data['moduleNameSingular'];
        $this->replacors['__moduleNamePluralLower__'] = $data['moduleNamePluralLower'];
        $this->replacors['__moduleNameSingularLower__'] = $data['moduleNameSingularLower'];

        $this->columns = $this->getColumns($data['columns']);

        $stub = base_path('application/Generator/Stubs/ModuleIndex.vue');
        $this->generateIndexHeaders();
        $this->generate('Views', 'Index.vue', $stub);

        $stub = base_path('application/Generator/Stubs/ModuleCreate.vue');
        $this->generateCreateColumns();
        $this->generate('Views', 'Create.vue', $stub);

        $stub = base_path('application/Generator/Stubs/ModuleEdit.vue');
        $this->generateEditColumns();
        $this->generate('Views', 'Edit.vue', $stub);

        $stub = base_path('application/Generator/Stubs/ModuleDetail.vue');
        $this->generate('Views', 'Detail.vue', $stub);
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

    private function generateIndexHeaders()
    {
        $key = '__moduleIndexHeaders__';

        $this->replacors[$key] = "\n";
        foreach ($this->columns as $column) {
//            $rule_line = " { text: 'Email', align: 'start', sortable: true, value: 'email', }, ";
            $this->replacors[$key] .= "\t\t\t\t";
            $this->replacors[$key] .= " { text: '${column['display_name']}', align: 'start', sortable: true, value: '${column['name']}', }, ";

            $this->replacors[$key] .= "\n";
        }
    }

    private function generate($folder, $file_name, $stub)
    {

        $file_content = file_get_contents($stub);

        $file_content = $this->replacor($file_content);

        $module_type = $this->replacors['__moduleType__'];
        $moduleName = $this->replacors['__moduleNamePlural__'];
        $location = base_path() . '/application/Modules/' . $module_type . '/' . $moduleName . '/' . $folder . '/';
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
        $key = '__moduleCreateColumns__';

        $this->replacors[$key] = "\n";
        foreach ($this->columns as $column) {
//            $rule_line = " id: this.data.id, ";
            $this->replacors[$key] .= '        ';
            $this->replacors[$key] .= "${column['name']} : this.data.${column['name']},";

            $this->replacors[$key] .= "\n";
        }
    }


}