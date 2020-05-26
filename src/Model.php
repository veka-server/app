<?php

namespace VekaServer\Framework;

use VekaServer\Container\Container;

class Model {

    /**
     * @param string $sql
     * @param array $data
     * @return array
     */
    public static function exec(string $sql, array $data = array()){
        return Container::getInstance()->get('Bdd')->exec($sql, $data);
    }

}