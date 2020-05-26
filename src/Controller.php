<?php

namespace VekaServer\Framework;

use VekaServer\Container\Container;

class Controller
{
    /**
     * @param string $templatePath
     * @param array $data
     * @return string
     */
    public function getView(string $templatePath, array $data = array()): string
    {
        return Container::getInstance()->get('Renderer')->render($templatePath, $data);
    }

}