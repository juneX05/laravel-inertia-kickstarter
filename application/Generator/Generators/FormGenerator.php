<?php

namespace Application\Generator\Generators;

use Illuminate\Support\Facades\File;

class FormGenerator
{
    private $replacors = [];
    private $columns;
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

        $this->columns = $this->getColumns($data['columns']);
        $this->relations = $data['relations'];

        $stub = base_path('application/Generator/Stubs/ModuleForm.txt');
        $this->generateFormRelationProps();
        $this->generateFormInputs();
        $this->generate('Views', "{$this->replacors['__moduleNameSingular__']}Form.vue", $stub);
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

    private function generateFormInputs()
    {
        $key = '__moduleFormInputs__';

        $this->replacors[$key] = "\n";
        foreach ($this->columns as $column) {
//            $rule_line = " { text: 'Email', align: 'start', sortable: true, value: 'email', }, ";
            $this->replacors[$key] .= "\n";

            $column = $this->checkForRelationColumn($column);

            $info = $this->getColumnTypeStub($column['type']);

            $this->replacors[$key] .= $this->fieldStub($column, $info['type'], $info['stub']);

            $this->replacors[$key] .= "\n";
        }
    }

    private function checkForRelationColumn($column) {
        foreach ($this->relations as $relation) {
            if ($relation['column'] == $column['name']) {
                $var =  $relation['moduleNamePluralLower'];

                $column['type'] = 'relation';
                $column['items'] = "$var";
                $column['item_name'] = "name";
                break;
            }
        }

        return $column;
    }

    private function generateFormRelationProps()
    {
        $key = '__moduleFormRelationProps__';

        $this->replacors[$key] = "";
        foreach ($this->relations as $relation) {
            $var =  $relation['moduleNamePluralLower'];
            $this->replacors[$key] .= "    '$var':Array,";
            $this->replacors[$key] .= "\n";
        }
    }

    private function getColumnTypeStub($column_type)
    {
        if (in_array($column_type, ['integer', 'float'])) {
            return [
                'type' => 'number',
                'stub' => 'TextInput'
            ];
        } elseif (in_array($column_type, ['string'])) {
            return [
                'type' => 'text',
                'stub' => 'TextInput'
            ];
        } elseif (in_array($column_type, ['date'])) {
            return [
                'type' => 'date',
                'stub' => 'DatePicker'
            ];
        } elseif (in_array($column_type, ['time'])) {
            return [
                'type' => 'time',
                'stub' => 'TimePicker'
            ];
        } elseif (in_array($column_type, ['relation'])) {
            return [
                'type' => 'relation',
                'stub' => 'SelectInput'
            ];
        }
    }

    private function fieldStub($column, $type, $stub_name)
    {
        $stub = base_path('application/Generator/Stubs/moduleForm' . $stub_name . '.txt');
        $content = file_get_contents($stub);

        $replacors['__field__'] = $column['name'];
        $replacors['__hint__'] = '';
        $replacors['__placeholder__'] = '';
        $replacors['__label__'] = $column['display_name'];
        $replacors['__type__'] = $type;
        $replacors['__itemsData__'] = $column['items'] ?? "";
        $replacors['__itemName__'] = $column['item_name'] ?? "";
        $replacors['__multiple__'] = $column['multiple'] ?? 'false';

        return $this->replacor($content, $replacors);
    }

    private function replacor($content, $replacors = null)
    {

        if ($replacors == null)
            $replacors = $this->replacors;

        foreach ($replacors as $key => $value) {

            $content = str_replace($key, $value, $content);

        }

        return $content;

    }

    private function generate($folder, $file_name, $stub)
    {

        $file_content = file_get_contents($stub);

        $file_content = $this->replacor($file_content);

        $module_type = $this->replacors['__moduleType__'];
        $moduleName = $this->replacors['__moduleNamePlural__'];
        $location = base_path() . $this->replacors['__moduleDirectory__'] . '/' . $folder . '/';
        if (!File::exists($location)) {
            File::makeDirectory($location, 0755, true);
        }

        $file = $location . $file_name;
        file_put_contents($file, $file_content);
    }

}