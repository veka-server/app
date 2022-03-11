<?php

namespace VekaServer\Framework;

use VekaServer\Config\Config;
use VekaServer\Interfaces\PluginInterface;

class Plugin
{
    private $plugin_list = [];

    private static $_instance = null;

    /**
     * Retourne une instance singleton du fichier de config
     * @param null $path_plugin_file Chemin vers le fichier de plugin
     * @return null|Plugin
     */
    public static function getInstance($path_plugin_file = null){

        if( ! (self::$_instance instanceof self ) )
            self::$_instance = new self($path_plugin_file);

        return self::$_instance;

    }

    /**
     * Plugin constructor.
     * @param string $path_plugin_file Chemin vers le fichier de plugin
     */
    public function __construct($path_plugin_file)
    {
        $this->plugin_list = require_once($path_plugin_file);
    }

    public function getAllCSSFolders()
    {
        $list = [Config::getInstance()->get('CSS_folder')];
        /** @var PluginInterface $plugin */
        foreach($this->plugin_list as $plugin){
            $list = array_merge($plugin::getPathCSS(), $list);
        }
        return $list;
    }

    public function getAllJSFolders()
    {
        $list = [];
        /** @var PluginInterface $plugin */
        foreach($this->plugin_list as $plugin){
            $list = array_merge($plugin::getPathJS(), $list);
        }
        $list[] = Config::getInstance()->get('JS_folder');
        return $list;
    }

    public function getAllViewFolders()
    {
        $list = [Config::getInstance()->get('VIEW_folder')];
        /** @var PluginInterface $plugin */
        foreach($this->plugin_list as $plugin){
            $list = array_merge($plugin::getPathView(),$list);
        }
        return $list;
    }

}
