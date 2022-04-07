# App
Classe de demarage de mon framework


## Migration 

CONFIG 
```php 
    // Migration
    "Migration"   => [
        /** migration de l'app principal */
        'App' => ['path' => realpath($root_dir.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'migration'.DIRECTORY_SEPARATOR), 'name' => 'App']
        ,'Trad' => ['path' => realpath($root_dir.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'trad'.DIRECTORY_SEPARATOR), 'name' => 'Trad']
    ],
```

migration INIT ( install la bdd migration )
```bash 
composer migration  source=App action=init 
```
migration UP (all)
```bash 
composer migration  source=App action=upgrade 
```
migration DOWN (one at a time)
```bash 
composer migration  source=App action=downgrade 
```
