<?php

namespace Application\Modules\Core\Menus\Models;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

class Menu
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
        $core_directories = File::directories(base_path('application/Modules/Core'));
        $system_directories = File::directories(base_path('application/Modules/System'));
        $module_directories = array_merge($system_directories, $core_directories);

        // Process Core and System Wide Parent or Default Menus.
        $menus = self::collectMenus(base_path('application/Modules/Core'), $menus);
        $menus = self::collectMenus(base_path('application/Modules/System'), $menus);

        foreach ($module_directories as $directory) {
            $menus = self::collectMenus($directory, $menus);
        }

        $menus = self::sortMenus($menus);
        $menus = self::processMenus($menus);

        return $menus;
    }

    private static function processSidebarMenus($key, $values)
    {
        $menus = [];
//        if (isset($values['parent']) && $values['parent'] != null) {
//            if (isset($menus[$values['parent']])) {
//                if (isset($menus[$values['parent']]['children'])) {
//                    $menus[$values['parent']]['children'][] = $values;
//                } else {
//                    $menus[$values['parent']]['children'] = [];
//                    $menus[$values['parent']]['children'][$key] = $values;
//                }
//            } else {
//                $menus[$values['parent']] = [];
//                $menus[$values['parent']]['children'] = [];
//                $menus[$values['parent']]['children'][$key] = $values;
//            }
//        } else {
//            $keys[] = $key;
            $menus[$key] = $values;
//        }

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
            $module_menus = json_decode($data, true);
            foreach ($module_menus as $key => $values) {
                self::$keys[$key] = $values['position'];
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
            $menus[$key] = $old_menus[$key];
        }

        return $menus;
    }

    private static function processMenus($sorted_menus)
    {
        $menus = [];
        foreach ($sorted_menus as $key => $values) {
            if (self::$processRoute) {
                $module_menu = self::processSidebarMenus($key, $values);
                $menus = array_merge_recursive($module_menu, $menus);
            } else {
                $module_menu = self::processMenusList($key, $values);
                $menus = array_merge_recursive([$module_menu], $menus);
            }
        }

        return $menus;
    }
}
