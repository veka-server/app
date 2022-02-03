<?php

namespace VekaServer\Framework;

use VekaServer\Container\Container;

class Lang {

    public static function get($key){
        /** @var \VekaServer\Interfaces\LangInterface $lang */
        $lang = Container::getInstance()->get('Lang');
        return $lang->get($key);
    }

    public static function has($key): bool
    {
        /** @var \VekaServer\Interfaces\LangInterface $lang */
        $lang = Container::getInstance()->get('Lang');
        return $lang->has($key);
    }

    public static function set($key, $lang_str, $traduction){
        /** @var \VekaServer\Interfaces\LangInterface $lang */
        $lang = Container::getInstance()->get('Lang');
        return $lang->set($key, $lang_str, $traduction);
    }

    public static function addLang($lang_str){
        /** @var \VekaServer\Interfaces\LangInterface $lang */
        $lang = Container::getInstance()->get('Lang');
        return $lang->addLang($lang_str);
    }

    /**
     * @return string
     */
    public static function getLang(): string
    {
        /** @var \VekaServer\Interfaces\LangInterface $lang */
        $lang = Container::getInstance()->get('Lang');
        return $lang->getLang();
    }

    /**
     * @param string $lang
     */
    public static function setLang(string $lang_str): void
    {
        /** @var \VekaServer\Interfaces\LangInterface $lang */
        $lang = Container::getInstance()->get('Lang');
        $lang->setLang($lang_str);
    }

}
