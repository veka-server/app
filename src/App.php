<?php

namespace VekaServer\Framework;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

abstract class App {

    public function __construct()
    {

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
        if($response instanceof ResponseInterface)
            $Dispatcher->send($response);
    }

    /**
     * Cette methode sera executer avant le router et le dispatcher
     * @param ServerRequestInterface $request
     * @return mixed
     */
    public abstract function before_router(ServerRequestInterface $request);

    /**
     * Cette methode sera executer apres le router mais avant l'affichage
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return mixed
     */
    public abstract function after_router(ServerRequestInterface $request,ResponseInterface $response);

}