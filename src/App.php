<?php

namespace VekaServer\Framework;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use VekaServer\Config\Config;
use GuzzleHttp\Psr7\ServerRequest;

abstract class App {

    public function __construct($path)
    {
        // si whoops installer on convertit les erreurs php en exception
        $this->AllErrorToException();

        // initialise le singleton de configuration
        Config::getInstance($path.'/config/config.php');

        // creation du dispatcher
        $Dispatcher = require_once($path.'/config/middleware.php');

        // recuperation de la requete recue
        $request = ServerRequest::fromGlobals();

        $this->before_router($request);

        // lance l'execution des middlewares et recupere la reponse
        $response = $Dispatcher->process($request);

        $this->after_router($request, $response);

        // si la reponse est presente ont l'affiche
        if($response instanceof ResponseInterface)
            $Dispatcher->send($response);
    }

    /**
     * Cette fonction Convertit les erreurs PHP en Exception pour
     * fonctionner avec whoops
     */
    public function AllErrorToException(){

        if(!class_exists('\\Middlewares\\Whoops'))
            return ;

        set_error_handler(function($severity, $message, $file, $line){
            if (!(error_reporting() & $severity)) {
                // This error code is not included in error_reporting
                return;
            }
            throw new \ErrorException($message, 0, $severity, $file, $line);
        });
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