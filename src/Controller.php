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
        Container::getInstance('Renderer')->render($templatePath, $data);
    }

}