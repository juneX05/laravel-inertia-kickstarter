<?php

namespace Application\Generator\Generators;

use Illuminate\Support\Facades\File;

class MenuGenerator
{
    private $replacors = [];
    private $columns;

    private $stub;

    public function __construct($data)
    {
        $this->stub = base_path('application/Generator/Stubs/ModuleMenu.txt');

        $this->replacors['__moduleType__'] = $data['moduleType'];
        $this->replacors['__moduleNamePlural__'] = $data['moduleNamePlural'];
        $this->replacors['__moduleNameSingular__'] = $data['moduleNameSingular'];
        $this->replacors['__moduleNamePluralLower__'] = $data['moduleNamePluralLower'];
        $this->replacors['__moduleIcon__'] = $data['moduleIcon'];
        $this->replacors['__moduleDirectory__'] = $data['moduleDirectory'];
        $this->replacors['__moduleNamespace__'] = $data['moduleNamespace'];

        $this->columns = $data['columns'];

        $this->generate();
    }

    private function generate()
    {
        $file_content = file_get_contents($this->stub);

        $file_content = $this->replacor($file_content);

        $module_type = $this->replacors['__moduleType__'];
        $moduleName = $this->replacors['__moduleNamePlural__'];
        $location = base_path() . $this->replacors['__moduleDirectory__']  . '/';
        if (!File::exists($location)) {
            File::makeDirectory($location, 0755, true);
        }
        $file_name = 'menu.json';
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