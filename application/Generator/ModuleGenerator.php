<?php


namespace Application\Generator;


use Illuminate\Support\Facades\File;

class ModuleGenerator
{

    public function __construct($data)
    {
        $this->saveModuleInfo($data);

        $controllerGenerator = new \Application\Generator\Generators\ControllerGenerator($data);
        $modelGenerator = new \Application\Generator\Generators\ModelGenerator($data);
        $migrationGenerator = new \Application\Generator\Generators\MigrationGenerator($data);
        $seederGenerator = new \Application\Generator\Generators\SeederGenerator($data);
        $routesGenerator = new \Application\Generator\Generators\RoutesGenerator($data);
        $menuGenerator = new \Application\Generator\Generators\MenuGenerator($data);
        $pagesGenerator = new \Application\Generator\Generators\PagesGenerator($data);
        $formGenerator = new \Application\Generator\Generators\FormGenerator($data);
    }

    private function saveModuleInfo($data)
    {
        $file_content = json_encode($data, JSON_PRETTY_PRINT);

        $module_type = $data['moduleType'];
        $module_name = $data['moduleNamePlural'];
        $location = base_path() . '/application/Modules/' . $module_type . '/' . $module_name . '/';
        if (!File::exists($location)) {
            File::makeDirectory($location, 0755, true);
        }
        $file_name = 'module-info.json';
        $file = $location . $file_name;
        file_put_contents($file, $file_content);
    }
}