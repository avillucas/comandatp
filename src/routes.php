<?php

use Core\Api\UsuarioApi;
use Core\Api\ResultadosApi;
use Core\Middleware\MWparaCORS;
use Core\Middleware\MWparaAutentificar;

// Routes

$app->group('/', function () {
    $this->post('login/', UsuarioApi::class . ':login');
    //usuarios
    $this->group('usuarios', function () {
        $this->get('/', UsuarioApi::class . ':TraerTodos');//->add(MWparaAutentificar::class .':verificarUsuario');
        $this->post('/', UsuarioApi::class . ':CargarUno');
    });
    $this->group('resultados', function () {
        $this->post('/', ResultadosApi::class . ':CargarUno');
        $this->get('/', ResultadosApi::class . ':TraerTodosPorUsuario');
    });//->add(MWparaAutentificar::class .':verificarUsuario');
})
->add(MWparaCORS::class .':HabilitarCORSTodos')
;
