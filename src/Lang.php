<?php

namespace VekaServer\Framework;

use VekaServer\Container\Container;

class Lang {

    public static function get($key){
        /** @var  $lang */
        $lang = Container::getInstance()->get('Lang');
        return $lang->get($key);
    }

    public static function has($key): bool
    {
        /** @var  $lang */
        $lang = Container::getInstance()->get('Lang');
        return $lang->has($key);
    }

    public static function set($key, $lang, $traduction){
        /** @var  $lang */
        $lang = Container::getInstance()->get('Lang');
        return $lang->set($key, $lang, $traduction);
    }

    public static function addLang($lang){
        /** @var  $lang */
        $lang = Container::getInstance()->get('Lang');
        return $lang->addLang($lang);
    }

    /**
     * @return string
     */
    public static function getLang(): string
    {
        /** @var  $lang */
        $lang = Container::getInstance()->get('Lang');
        return $lang->getLang();
    }

    /**
     * @param string $lang
     */
    public static function setLang(string $lang): void
    {
        /** @var  $lang */
        $lang = Container::getInstance()->get('Lang');
        $lang->setLang($lang);
    }

}
