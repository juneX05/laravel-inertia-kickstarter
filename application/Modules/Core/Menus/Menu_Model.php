<?php

namespace Application\Modules\Core\Menus;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

class Menu_Model
{
    private static $processRoute;
    private static $keys;

    public static function all($processRoute = true)
    {
        self::$processRoute = $processRoute;
        return self::getModuleMenus();
    }

    public static function getKeys()
    {
        asort(self::$keys);
        $keys = [];
        foreach (self::$keys as $key => $value) {
            $keys[] = $key;
        }
        return $keys;
    }

    private static function getModuleMenus()
    {
        $menus = [];
        $module_directories = app('module_directories_list');
        $module_directories[] = base_path('application/Modules');
        foreach ($module_directories as $directory) {
            $menus = self::collectMenus($directory, $menus);
        }

        $menus = self::processMenus($menus);
        if (self::$processRoute) {
            $menus = self::sortMenus($menus);
        }

        return $menus;
    }

    private static function processSidebarMenus($key, $values)
    {
        $menus = [];
        if (isset($values['parent']) && $values['parent'] != null) {
            if (isset($menus[$values['parent']])) {
                if (isset($menus[$values['parent']]['children'])) {
                    $menus[$values['parent']]['children'][] = $values;
                } else {
                    $menus[$values['parent']]['children'] = [];
                    $menus[$values['parent']]['children'][$key] = $values;
                }
            } else {
                $menus[$values['parent']] = [];
                $menus[$values['parent']]['children'] = [];
                $menus[$values['parent']]['children'][$key] = $values;
                $key = $values['parent'].'.'.$key;
            }
        } else {
            $menus[$key] = $values;
        }
        self::$keys[$key] = $values['position'] ?? 1000;

        return $menus;
    }

    private static function processMenusList($key, $values)
    {
        $menu = [];
        $menu['id'] = $key;
        if (array_key_exists('menu_type',$values) && $values['menu_type'] == 'header') {
            $menu['link_type'] = 'header';
        } else {
            $menu['link_type'] = 'hard-link';
            if (Route::has($values['link'])) {
                $menu['link_type'] = 'route';
            }
        }
        return array_merge($values, $menu);
    }

    private static function collectMenus($directory, $menus)
    {
        $menu_file = $directory . '/menu.json';
        if (file_exists($menu_file)) {
            $data = file_get_contents($menu_file);
            $module_menus = [];
            $module_directory_menus = json_decode($data, true);
            foreach ($module_directory_menus as $key => $values) {
                $module_menus[$key] = $values;
                $module_menus[$key]['module_type'] = str_replace(base_path('application/Modules'),'', $directory);
            }
            $menus = array_merge_recursive($menus, $module_menus);
        }

        return $menus;
    }

    private static function sortMenus($old_menus)
    {
        asort(self::$keys);
        $menus = [];

        foreach (self::$keys as $key => $value) {
            $item = explode('.', $key);
            $item_length = count($item);
            if ($item_length == 1) {
                $menus[$key] = $old_menus[$key];
            } else {
                $menus[$item[0]]['children'][$item[1]] = $old_menus[$item[0]]['children'][$item[1]];
            }
        }

        return $menus;
    }

    private static function processMenus($sorted_menus)
    {
        $menus = [];
        foreach ($sorted_menus as $key => $values) {
            $values = self::processMenusList($key, $values);
            if (self::$processRoute) {
                $values = self::processSidebarMenus($key, $values);
                $menus = array_merge_recursive($values, $menus);
            } else {
                $menus = array_merge_recursive([$values], $menus);
            }
        }

        return $menus;
    }

    public function updateMenuPositions($menu_keys)
    {
        $module_menus = self::getModuleMenus();
        $count = count($menu_keys);
        for($i = 0; $i < $count; $i++) {
            $key = $menu_keys[$i];
            $module = $module_menus[$key];
            $menu_file = base_path('application/Modules'. $module['module_type']) . "/menu.json";
            $menu = json_decode(file_get_contents($menu_file), true);
            $menu[$key]['position'] = $i + 1;

            file_put_contents($menu_file, json_encode($menu, JSON_PRETTY_PRINT));
        }
    }

    public static function getModules() {
        $modules = [];
        $module_directories = app('module_directories');
        foreach ($module_directories as $key => $directories) {
            $module = '';
            if ($key == 'core_modules') $module = 'Core/';
            else if ($key == 'system_modules') $module = 'System/';
            else if ($key == 'system_configs_modules') $module = 'Configurations/SysConfigs/Tabs/';
            else if ($key == 'dev_configs_modules') $module = 'Configurations/DevConfigs/Tabs/';

            $modules[$key] = [];
            foreach ($directories as $key_dir => $directory) {
                $search = base_path('application/Modules/' . $module);
                $modules[$key][] = [
                    'name' => str_replace($search, '', $directory),
                    'id' => $key . $key_dir
                ];
            }
        }
        return $modules;
    }

    public static function getParentMenus() {
        $menus = Menu_Model::all(false);
        $parent_menus = [];

        foreach ($menus as $menu) {
            if (!isset($menu['parent']) && !isset($menu['menu_type'])) {
                $parent_menus[] = $menu;
            }
        }
        return $parent_menus;
    }

    private static function saveModuleMenu($data) {
        $module = $data['module'];

        if ($data['module_group'] == 'core') {
            $location = base_path('application/Modules/Core/' . $module);
        } else {
            $location = base_path('application/Modules/System/' . $module);
        }

        self::saveMenuFile($location,$data);
    }

    private static function saveNonModuleMenu($data) {

        $location = base_path('application/Modules/');
        self::saveMenuFile($location,$data);

    }

    private static function saveMenuFile($location, $data) {
        $menu_file = $location . '/menu.json';
        if (file_exists($menu_file)) {
            $menu_content = file_get_contents($menu_file);
            $menus = json_decode($menu_content, true);
        } else {
            $menus = [];
        }

        $menus[$data['name']] = [
            'title' => $data['title'],
            'icon' => $data['icon'],
            'link' => $data['link'],
            'permissions' => $data['permissions'],
            'position' => intval($data['position']),
            'parent' => $data['parent'] ?? null,
        ];

        file_put_contents($menu_file, json_encode($menus, JSON_PRETTY_PRINT));
    }

    public static function create($data) {

        if ($data['menu_type'] == 'module_menu') {
            self::saveModuleMenu($data);
        } else {
            self::saveNonModuleMenu($data);
        }

    }
}
