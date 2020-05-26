<?php

namespace VekaServer\Framework;

use VekaServer\Container\Container;

class Model {

    /**
     * @param string $sql
     * @param array $data
     */
    public static function exec(string $sql, array $data = array()){
        Container::getInstance('Bdd')->exec($sql, $data);
    }

}