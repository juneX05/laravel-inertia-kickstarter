<?php

namespace Application\Generator\Generators;

use Illuminate\Support\Facades\File;

class RoutesGenerator
{
    private $replacors = [];
    private $columns;

    private $webRoutesStub;

    public function __construct($data)
    {
        $this->webRoutesStub = base_path('application/Generator/Stubs/ModuleWebRoutes.txt');

        $this->replacors['__moduleType__'] = $data['moduleType'];
        $this->replacors['__moduleNamePlural__'] = $data['moduleNamePlural'];
        $this->replacors['__moduleNameSingular__'] = $data['moduleNameSingular'];
        $this->replacors['__moduleNamePluralLower__'] = $data['moduleNamePluralLower'];
        $this->replacors['__moduleNameSlug__'] = $data['moduleNameSlug'];
        $this->replacors['__moduleDirectory__'] = $data['moduleDirectory'];
        $this->replacors['__moduleNamespace__'] = $data['moduleNamespace'];

        $this->columns = $data['columns'];

        $this->generateWebRoutes();
    }

    private function generateWebRoutes()
    {
        $file_content = file_get_contents($this->webRoutesStub);

        $file_content = $this->replacor($file_content);

        $module_type = $this->replacors['__moduleType__'];
        $moduleName = $this->replacors['__moduleNamePlural__'];
        $location = base_path() . $this->replacors['__moduleDirectory__']  . '/Routes/';
        if (!File::exists($location)) {
            File::makeDirectory($location, 0755, true);
        }
        $file_name = 'web.php';
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