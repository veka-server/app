<?php

namespace VekaServer\Framework;

use Psr\Log\LogLevel;
use VekaServer\Container\Container;

abstract class Console
{
    protected $root_path ;

    /**
     * @throws \Exception
     */
    public function __construct($root_path){
        try {

            ini_set('memory_limit', -1);
            ini_set('max_execution_time', 0);
            set_time_limit(0);

            $this->root_path = $root_path;

            App::initDependance($root_path);

            $this->run($this->getParams());

        }catch(\Throwable $e){
            if(Container::getInstance()->has('Log')){
                /** @var \Psr\Log\LoggerInterface $log */
                $log = Container::getInstance()->get('Log');
                $log->log(LogLevel::ERROR,'', ['exception' => $e]);
            }
            throw $e;
        }
    }

    public abstract function run($params);

    /**
     * @return array
     */
    private function getParams()
    {
        global $argv;

        $param=[];
        $cmd_now='';
        if (isset($argv[0])) {
            $cptr=0;
            foreach($argv as $arg) {
                if ($cptr==0) {
                    $arg = basename($arg);
                    $cptr++;
                } else {
                    $cmd_now .= ' ';
                }
                $cmd_now .= $arg;
                $arg=trim($arg);
                $pos=strpos($arg,'=');
                if ($pos!==false) {
                    $name=substr($arg,0,$pos);
                    $value=substr($arg,$pos+1);
                    $param[$name]=$value;
                }
                $cptr++;
            }
        }
        return $param;
    }

}
