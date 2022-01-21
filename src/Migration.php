<?php

namespace VekaServer\Framework;

use VekaServer\Container\Container;

class Migration
{

    private $path_folder_migration;
    private $source;

    public function __construct($path_folder_migration, $source){
        $this->path_folder_migration = $path_folder_migration;
        $this->source = $source;
    }

    public function init(){

        /** creer la table de migration si elle n'existe pas encore */
        $sql = 'CREATE TABLE IF NOT EXISTS migration (
                    filename varchar(255) NOT NULL,
                    source varchar(255) NOT NULL,
                    date_upgrade datetime DEFAULT NOW(),
                    PRIMARY KEY(filename)
                );';
        Model::exec($sql);

    }

    /**
     * @throws \Exception
     */
    public function upgrade(){

        /** recuperer les migrations deja faite */
        $sql = 'SELECT * FROM migration WHERE source = :source ORDER BY date_upgrade DESC';
        $rs = Model::exec($sql, ['s-source' => $this->source]);
        $liste_migration_deja_faite = [];
        foreach ($rs as $line){
            $liste_migration_deja_faite[] = $line['filename'];
        }

        /** recuperer la liste des fichiers de migrations */
        $files = array_diff(scandir($this->path_folder_migration), array('..', '.', '.gitignore'));

        /** parcourir chaque fichier */
        foreach ($files as $file){

            /** verifier si eligible a un upgrade */
            if(in_array($file, $liste_migration_deja_faite)){
                continue;
            }

            /** @var \VekaServer\Interfaces\MigrationInterface $migration_instance */
            $migration_instance = require_once $this->path_folder_migration.'/'.$file;
            if(is_object($migration_instance) === false){
                throw new \Exception('Migration file '.$this->path_folder_migration.'/'.$file.' should return instance of \VekaServer\Interfaces\MigrationInterface ');
            }

            Model::beginTransaction();

            try{
                $migration_instance->upgrade_creation();

                Model::beginTransaction();
                try{
                    $migration_instance->upgrade_data();
                }catch (\Exception $e){
                    Model::rollback();
                    throw $e;
                }

            }catch (\Exception $e){
                $migration_instance->downgrade_nettoyage();
                throw $e;
            }

            try{
                $migration_instance->upgrade_nettoyage();
            }catch (\Exception $e){
                Container::getInstance()->get('Log')->warning('Migration Cleanup Failed : no rollback '.PHP_EOL.'You should cleanup manually', ['exception' => $e]);
            }
            
            $sql = 'INSERT INTO migration (filename, source) VALUES(:filename, :source);';
            Model::exec($sql, ['s-filename' => $file, 's-source' => $this->source]);

            Model::commit();
        }

    }

    /**
     * @throws \Exception
     */
    public function downgrade(){

        /** recuperer les migrations deja faite */
        $sql = 'SELECT * FROM migration WHERE source = :source ORDER BY date_upgrade DESC LIMIT 1';
        $rs = Model::exec($sql, ['s-source' => $this->source]);

        if(empty($rs)){
            throw new \Exception('No migration left');
        }

        if(is_file($this->path_folder_migration.'/'.$rs[0]['filename']) === false){
            throw new \Exception('Migration '.$this->path_folder_migration.'/'.$rs[0]['filename'].' NOT FOUND');
        }

        /** @var \VekaServer\Interfaces\MigrationInterface $migration_instance */
        $migration_instance = require_once $this->path_folder_migration.'/'.$rs[0]['filename'];
        if(is_object($migration_instance) === false){
            throw new \Exception('Migration file '.$this->path_folder_migration.'/'.$rs[0]['filename'].' should return instance of \VekaServer\Interfaces\MigrationInterface ');
        }

        Model::beginTransaction();

        try{
            $migration_instance->downgrade_creation();

            Model::beginTransaction();
            try{
                $migration_instance->downgrade_data();
            }catch (\Exception $e){
                Model::rollback();
                throw $e;
            }

        }catch (\Exception $e){
            $migration_instance->upgrade_nettoyage();
            throw $e;
        }

        try{
            $migration_instance->downgrade_nettoyage();
        }catch (\Exception $e){
            Container::getInstance()->get('Log')->warning('Migration Cleanup Failed : no rollback '.PHP_EOL.'You should cleanup manually', ['exception' => $e]);
        }
        
        $sql = 'DELETE FROM migration WHERE filename = :filename AND source = :source;';
        Model::exec($sql, ['s-filename' => $rs[0]['filename'], 's-source' => $this->source]);

        Model::commit();
    }

}
