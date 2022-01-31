<?php

namespace Application\Generator\Generators;

use Illuminate\Support\Facades\File;

class MigrationGenerator
{
    private $replacors = [];
    private $columns;

    private $stub;

    public function __construct($data)
    {
        $this->stub = base_path('application/Generator/Stubs/ModuleMigration.txt');

        $this->replacors['__moduleType__'] = $data['moduleType'];
        $this->replacors['__moduleNamePlural__'] = $data['moduleNamePlural'];
        $this->replacors['__moduleNameSingular__'] = $data['moduleNameSingular'];
        $this->replacors['__moduleNamePluralLower__'] = $data['moduleNamePluralLower'];
        $this->replacors['__moduleDirectory__'] = $data['moduleDirectory'];
        $this->replacors['__moduleNamespace__'] = $data['moduleNamespace'];

        $this->columns = $data['columns'];

        $this->generateMigrationColumns();

        $this->generate();
    }

    private function generateMigrationColumns()
    {
        $key = '__moduleMigrationColumns__';

        $this->replacors[$key] = "\n";
        foreach ($this->columns as $column) {
//            $rule_line = " $table->string('mimi',43)->default('value')->nullable()->unique(); ";
            $this->replacors[$key] .= "\t\t\t";
            $this->replacors[$key] .= '$table->';
            $this->replacors[$key] .= "${column['type']}('${column['name']}'";

            if ($column['size'] != null && is_int($column['size']) && $column['size'] > 0) {
                $this->replacors[$key] .= ',' . $column['size'];
            }
            $this->replacors[$key] .= ')';
            if ($column['not_null'] == false) {
                $this->replacors[$key] .= '->nullable()';
            }
            if ($column['default'] != '' || $column['default'] != null) {
                $this->replacors[$key] .= "->default('${column['default']}')";
            }
            if ($column['unique']) {
                $this->replacors[$key] .= '->unique()';
            }
            $this->replacors[$key] .= ";\n";
        }
    }

    private function generate()
    {
        $file_content = file_get_contents($this->stub);

        $file_content = $this->replacor($file_content);

        $module_type = $this->replacors['__moduleType__'];
        $moduleName = $this->replacors['__moduleNamePlural__'];
        $location = base_path() . $this->replacors['__moduleDirectory__'] . '/Migrations/';
        if (!File::exists($location)) {
            File::makeDirectory($location, 0755, true);
        }
        $file_name = date('Y_m_d_His') . '_create_' . $this->replacors['__moduleNamePluralLower__'] . '_table.php';
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