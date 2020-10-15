<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2015-09-24
 * Time: 15:39
 */

namespace Katniss\Everdeen\Themes\AdminThemes\AdminLte\Composers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\HtmlString;
use Katniss\Everdeen\Utils\DataStructure\Menu\Menu;
use Katniss\Everdeen\Utils\DataStructure\Menu\MenuRender;

class AdminMenuComposer
{

    /**
     * Create a new profile composer.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('admin_menu', $this->getMenuRender($this->getMenu()));
    }

    protected function getMenuRender(Menu $menu)
    {
        $menuRender = new MenuRender();
        $menuRender->wrapClass = 'sidebar-menu';
        $menuRender->childrenWrapClass = 'treeview-menu';
        return new HtmlString($menuRender->render($menu));
    }

    protected function getMenu()
    {
        $currentUrl = currentUrl();
        $user = authUser();
        $menu = new Menu($currentUrl);
        if ($user->can('access-admin')) {
            // Dashboard
            $menu->add(  // add an example menu item which have sub menu
                '#',
                trans('pages.admin_dashboard_title'),
                '<i class="fa fa-dashboard"></i> <span>', '</span> <i class="fa fa-angle-left pull-right"></i>', 'treeview'
            );
            $subMenu = new Menu($currentUrl);
            $subMenu->add( // add a menu item
                adminUrl(),
                trans('pages.admin_dashboard_title'),
                '<i class="fa fa-circle-o"></i> <span>', '</span>'
            );
            // My Account
            $subMenu->add( // add a menu item
                meUrl('account'),
                trans('pages.my_account_title'),
                '<i class="fa fa-circle-o"></i> <span>', '</span>'
            );
            // My Settings
            $subMenu->add( // add a menu item
                meUrl('settings'),
                trans('pages.my_settings_title'),
                '<i class="fa fa-circle-o"></i> <span>', '</span>'
            );
            $menu->addSubMenu($subMenu);

            if ($user->hasRole('admin')) {
                // System Settings
                $menu->add(  // add an example menu item which have sub menu
                    '#',
                    trans('pages.admin_system_settings_title'),
                    '<i class="fa fa-cog"></i> <span>', '</span> <i class="fa fa-angle-left pull-right"></i>', 'treeview'
                );
                $subMenu = new Menu($currentUrl);
                $subMenu->add( // add a menu item
                    adminUrl('app-options'),
                    trans('pages.admin_app_options_title'),
                    '<i class="fa fa-circle-o"></i> <span>', '</span>'
                );
                $subMenu->add( // add a menu item
                    adminUrl('extensions'),
                    trans('pages.admin_extensions_title'),
                    '<i class="fa fa-circle-o"></i> <span>', '</span>'
                );
                $subMenu->add(  // add an example menu item which have sub menu
                    '#',
                    trans('pages.admin_ui_lang_title'),
                    '<i class="fa fa-circle-o"></i> <span>', '</span> <i class="fa fa-angle-left pull-right"></i>', 'treeview'
                );
                $subSubMenu = new Menu($currentUrl);
                $subSubMenu->add( // add a menu item
                    adminUrl('ui-lang/php'),
                    trans('pages.admin_ui_lang_php_title'),
                    '<i class="fa fa-circle-o"></i> <span>', '</span>'
                );
                $subSubMenu->add( // add a menu item
                    adminUrl('ui-lang/email'),
                    trans('pages.admin_ui_lang_email_title'),
                    '<i class="fa fa-circle-o"></i> <span>', '</span>'
                );
                $subMenu->addSubMenu($subSubMenu);
                $menu->addSubMenu($subMenu);

                // Passport Client
                $menu->add(  // add an example menu item which have sub menu
                    adminUrl('passport-clients'),
                    trans('pages.admin_passport_client_title'),
                    '<i class="fa fa-circle-o"></i> <span>', '</span>'
                );
            }
        }
        $extraMenu = $this->getExtraMenu();
        if ($extraMenu->has()) {
            $menu->add(  // add an example menu item which have sub menu
                '#',
                trans('pages.admin_extra_title'),
                '<i class="fa fa-folder"></i> <span>', '</span> <i class="fa fa-angle-left pull-right"></i>', 'treeview'
            );
            $menu->addSubMenu($extraMenu);
        }
        $menu = contentFilter('admin_menu', $menu);
        return $menu;
    }

    protected function getExtraMenu()
    {
        $menu = new Menu(currentFullUrl());
        $menu = contentFilter('extra_admin_menu', $menu);
        return $menu;
    }
}