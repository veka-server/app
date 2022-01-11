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
    public function connect(bool $check_conn = true){
        return Container::getInstance()->get('Bdd')->connect($check_conn);
    }

    /**
     * @param       $sql
     * @param array $param_sql
     *
     * @return array|bool|false|int|resource
     * @throws \Exception
     */
    public function open($sql, array $param_sql = array()){
        return Container::getInstance()->get('Bdd')->open($sql, $param_sql);
    }

    /**
     * @throws \Exception
     */
    public function beginTransaction(){
        return Container::getInstance()->get('Bdd')->beginTransaction();
    }

    public function commit(){
        return Container::getInstance()->get('Bdd')->commit();
    }

    public function rollback() {
        return Container::getInstance()->get('Bdd')->rollback();
    }

    public function fetch($stmt){
        return Container::getInstance()->get('Bdd')->fetch($stmt);
    }

    public function fetchAll($stmt){
        return Container::getInstance()->get('Bdd')->fetchAll($stmt);
    }

}