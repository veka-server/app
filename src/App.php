<?php

namespace VekaServer\Framework;

abstract class App {

    public function __construct()
    {
        // utilisation du loader de composer
        require 'vendor/autoload.php';

        // initialise le singleton de configuration
        \VekaServer\Config\Config::getInstance(__DIR__.'/config/config.php');

        // creation du dispatcher
        $Dispatcher = require_once(__DIR__.'/config/middleware.php');

        // recuperation de la requete recue
        $request = \GuzzleHttp\Psr7\ServerRequest::fromGlobals();

        $this->before_router($request);

        // lance l'execution des middlewares et recupere la reponse
        $response = $Dispatcher->process($request);

        $this->after_router($request, $response);

        // si la reponse est presente ont l'affiche
        if($response instanceof \Psr\Http\Message\ResponseInterface)
            $Dispatcher->send($response);
    }

    /**
     * Cette methode sera executer avant le router et le dispatcher
     */
    public abstract function before_router($request);

    /**
     * Cette methode sera executer apres le router mais avant l'affichage
     */
    public abstract function after_router($request,\Psr\Http\Message\ResponseInterface $response);

}