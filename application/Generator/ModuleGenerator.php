<?php


namespace Application\Generator;


use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ModuleGenerator
{

    public function __construct($data)
    {
        $module_info = $this->getModuleInfo($data['moduleName']);
        $data = array_merge($module_info, $data);

        $data['moduleNamespace'] = $this->getModuleNamespace($data);
        $data['moduleDirectory'] = $this->getModuleDirectory($data);
        $data['moduleDirectoryForViews'] = $this->getModuleDirectoryForViews($data);
        $data['custom_id'] = $this->checkCustomIdColumn($data['columns']);

        $this->saveModuleInfo($data);

        if (isset($data['relations']) && count($data['relations']) > 0) {
            $relations = $this->getRelationsInfo($data['relations']);
            $data['relations'] = $relations['info'];
            $data['relation_columns'] = $relations['columns'];
        }

        $controllerGenerator = new \Application\Generator\Generators\ControllerGenerator($data);
        $modelGenerator = new \Application\Generator\Generators\ModelGenerator($data);
        $migrationGenerator = new \Application\Generator\Generators\MigrationGenerator($data);
        $seederGenerator = new \Application\Generator\Generators\SeederGenerator($data);
        $routesGenerator = new \Application\Generator\Generators\RoutesGenerator($data);
        $menuGenerator = new \Application\Generator\Generators\MenuGenerator($data);
        $pagesGenerator = new \Application\Generator\Generators\PagesGenerator($data);
        $formGenerator = new \Application\Generator\Generators\FormGenerator($data);
    }

    private function checkCustomIdColumn($columns) {
        foreach ($columns as $column) {
            if ($column['name'] == 'id') {
                return true;
            }
        }

        return false;
    }

    private function getRelationsInfo($relations) {
        $count = count($relations);
        $columns = [];
        for ($i = 0; $i < $count; $i++) {
            $relation = $relations[$i];
            $columns[] = $relation['column'];
            $info = $this->getModuleInfo($relation['module']);
            $info['moduleType'] = $relation['location'];
            $info['moduleNamespace'] = $this->getModuleNamespace($info);
            $info['moduleDirectory'] = $this->getModuleDirectory($info);
            $relations[$i] = array_merge($relations[$i], $info);
        }

        return ['info' => $relations, 'columns' => $columns];
    }

    private function getModuleInfo($name) {
        $data = [];
        $data['moduleNamePlural'] = Str::plural($name);
        $data['moduleNameSingular'] = Str::singular($name);
        $data['moduleNamePluralLower'] = Str::lower(Str::plural(Str::snake($name)));
        $data['moduleNameSingularLower'] = Str::lower(Str::singular(Str::snake($name)));
        $data['moduleNameSlug'] = Str::kebab($name);

        return $data;
    }

    private function getModuleNamespace($data) {
        $module_type = "";
        if ($data['moduleType'] == 'Core' || $data['moduleType'] ==  'System') {
            $module_type = "${data['moduleType']}";
        } else if($data['moduleType'] == 'DevConfigs' || $data['moduleType'] ==  'SysConfigs') {
            $module_type = "Configurations\\${data['moduleType']}\\Tabs";
        }
        return "Application\\Modules\\$module_type\\${data['moduleNamePlural']}";
    }

    private function getModuleDirectory($data) {
        $module_type = "";
        if ($data['moduleType'] == 'Core' || $data['moduleType'] ==  'System') {
            $module_type = "${data['moduleType']}";
        } else if($data['moduleType'] == 'DevConfigs' || $data['moduleType'] ==  'SysConfigs') {
            $module_type = "Configurations/${data['moduleType']}/Tabs";
        }
        return "/application/Modules/$module_type/${data['moduleNamePlural']}";
    }

    private function getModuleDirectoryForViews($data) {
        $module_type = "";
        if ($data['moduleType'] == 'Core' || $data['moduleType'] ==  'System') {
            $module_type = "${data['moduleType']}";
        } else if($data['moduleType'] == 'DevConfigs' || $data['moduleType'] ==  'SysConfigs') {
            $module_type = "Configurations/${data['moduleType']}/Tabs";
        }
        return "$module_type/${data['moduleNamePlural']}/Views";
    }

    private function saveModuleInfo($data)
    {
        $file_content = json_encode($data, JSON_PRETTY_PRINT);

        $module_type = $data['moduleType'];
        $module_name = $data['moduleNamePlural'];
        $location = base_path() . $data['moduleDirectory'] . '/';
        if (!File::exists($location)) {
            File::makeDirectory($location, 0755, true);
        }
        $file_name = 'module-info.json';
        $file = $location . $file_name;
        file_put_contents($file, $file_content);
    }
}