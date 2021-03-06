<?php

namespace Anax\Navigation;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

/**
 * Helper to create a navbar for sites by reading its configuration from file
 * and then applying some code while rendering the resultning navbar.
 *
 */
class Navbar
{
    use ContainerInjectableTrait;



    /**
     * Create an url.
     *
     * @param: string $url where to create the url.
     *
     * @return string as the url create.
     */
    public function url($url)
    {
        return $this->di->get("url")->create($url);
    }



    /**
     * Callback tracing the current selected menu item base on scriptname.
     *
     * @param: string $url to check for.
     *
     * @return boolean true if item is selected, else false.
     */
    public function check($url)
    {
        if ($url == $this->di->get("request")->getCurrentUrl(false)) {
            return true;
        }
    }


    /**
     * Check if the route is parent
     *
     * @param  string  $parent [description]
     *
     * @return boolean         [description]
     */
    public function isParent($parent)
    {
        $route = $this->di->get("request")->getRoute();
        return !substr_compare($parent, $route, 0, strlen($parent));
    }

    /**
     * returns either the login button or logout button
     * together with profile link
     *
     * @return string the generated html
     */
    public function getLoginButton()
    {
        $session = $this->di->get("session");
        if ($session->get("login")) {
            $user = new \Erjh17\User\User();
            $logoutUrl = $this->url('user/logout');
            $profileUrl = $this->url('user/profile');
            $login = $session->get('login');

            return "<li><a class='profileLink' href='{$profileUrl}'>{$user->getGravatar($login['email'], true, 20)}  {$login['name']}</a></li><li><a href='{$logoutUrl}'>Log out</a></li>";
        } else {
            $loginUrl = $this->url('user/login');
            return "\n<li><a href='{$loginUrl}'>Login</a></li>\n";
        }
    }

    public function buildSubmenus($items)
    {
        $tempHtml = "";
        foreach ($items as $item) {
            $class = isset($item["class"]) && ! is_null($item["class"])
                ? $item["class"]
                : null;

            $url = $this->url($item["url"]);
            $tempHtml .= "\n<li{$class}><a href='{$url}' title='{$item['title']}'>{$item['text']}</a></li>\n";
        }
        return $tempHtml;
    }



    /**
     * Create a navigation bar/menu, with submenus.
     *
     * @param array $config with configuration for the menu.
     *
     * @return string with html for the menu.
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function createMenuWithSubMenus($config)
    {
        $default = [
            "id"      => null,
            "class"   => null,
            "wrapper" => "nav",
        ];
        $menu = array_replace_recursive($default, $config);
        //$menu = array_replace_recursive($menu, $menus[$menuName]);

        // Create the ul li menu from the array, use an anonomous recursive
        // function that returns an array of values.
        $createMenu = function (
            $items,
            $ulId = null,
            $ulClass = null
        ) use (
            &$createMenu
        ) {
            $html = null;
            $hasItemIsSelected = false;

            $html .= $this->buildSubmenus($items);
            $html .= $this->getLoginButton();

            // Return the menu
            return array("\n<ul$ulId$ulClass>$html</ul>\n", $hasItemIsSelected);
        };

        // Call the anonomous function to create the menu
        $id = isset($menu["id"])
            ? " id=\"{$menu["id"]}\""
            : null;
        $class = isset($menu["class"])
            ? " class=\"{$menu["class"]}\""
            : null;

        list($html) = $createMenu(
            $menu["items"],
            $id,
            $class
        );

        // Set the id & class element, only if it exists in the menu-array
        $wrapper = $menu["wrapper"];
        if ($wrapper) {
            $html = "<{$wrapper}>{$html}</{$wrapper}>";
        }

        return "\n{$html}\n";
    }
}
