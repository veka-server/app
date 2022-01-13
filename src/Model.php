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

    /**
     * @param bool $check_conn
     * @return mixed
     */
    public static function connect(bool $check_conn = true){
        return Container::getInstance()->get('Bdd')->connect($check_conn);
    }

    /**
     * @param       $sql
     * @param array $param_sql
     *
     * @return array|bool|false|int|resource
     * @throws \Exception
     */
    public static function open($sql, array $param_sql = array()){
        return Container::getInstance()->get('Bdd')->open($sql, $param_sql);
    }

    /**
     * @throws \Exception
     */
    public static function beginTransaction(){
        return Container::getInstance()->get('Bdd')->beginTransaction();
    }

    public static function commit(){
        return Container::getInstance()->get('Bdd')->commit();
    }

    public static function rollback() {
        return Container::getInstance()->get('Bdd')->rollback();
    }

    public static function fetch($stmt){
        return Container::getInstance()->get('Bdd')->fetch($stmt);
    }

    public static function fetchAll($stmt){
        return Container::getInstance()->get('Bdd')->fetchAll($stmt);
    }

}
