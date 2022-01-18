<?php

$root_path = dirname(__DIR__, 4) ;

// utilisation du loader de composer
require $root_path.'/vendor/autoload.php';

new class($root_path) extends \VekaServer\Framework\Console {

    public function run($params){

        $migration = new \VekaServer\Framework\Migration(
            $this->root_path.'/src/migration/'
            ,'framework');

        switch($params['action'] ?? ''){

            case 'init' :
                $migration->init();
                break;

            case 'upgrade' :
                $migration->upgrade();
                break;

            case 'downgrade' :
                $migration->downgrade();
                break;

            default :
                echo 'parametre action manquant'.PHP_EOL;
                echo 'Exemple :'.PHP_EOL;
                echo 'php '.basename($_SERVER['SCRIPT_NAME']).' action=upgrade'.PHP_EOL;
                echo 'liste des actions :'.PHP_EOL;
                echo 'upgrade : fait toute les upgrade disponible'.PHP_EOL;
                echo 'downgrade : annule la derniere upgrade seulement'.PHP_EOL;
                echo 'init : creer la table de migration'.PHP_EOL;
                break;
        }

    }

};