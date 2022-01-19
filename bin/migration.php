<?php

$root_path = dirname(__DIR__, 4) ;

// utilisation du loader de composer
require $root_path.'/vendor/autoload.php';

new class($root_path) extends \VekaServer\Framework\Console {

    public function run($params){

        /** si $params['source'] manquant alors afficher l'aide */
        if(empty($params['source'])){
            echo 'parametre source manquant'.PHP_EOL;
            $this->show_help();
        }

        /** recuperation de la config pour les migrations */
        $migration_config = VekaServer\Config\Config::getInstance()->get('Migration');

        if(
            !isset( $migration_config[$params['source']])
            || empty( ($migration_config[$params['source']]['path'] ?? ''))
            || empty( ($migration_config[$params['source']]['name'] ?? ''))
        ){
            throw new Exception('No config found for source='.$params['source']);
        }

        $path = $migration_config[$params['source']]['path'];
        $name = $migration_config[$params['source']]['name'];

        $migration = new \VekaServer\Framework\Migration( $path, $name);

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
                $this->show_help();
                break;
        }

    }

    public function show_help(){
        echo 'Exemple :'.PHP_EOL;
        echo 'php '.basename($_SERVER['SCRIPT_NAME']).' source=app action=upgrade'.PHP_EOL;
        echo 'la liste des sources de migration est dans le fichier de config'.PHP_EOL;
        echo 'liste des actions :'.PHP_EOL;
        echo 'upgrade : fait toute les upgrade disponible'.PHP_EOL;
        echo 'downgrade : annule la derniere upgrade seulement'.PHP_EOL;
        echo 'init : creer la table de migration'.PHP_EOL;
        die();
    }

};
