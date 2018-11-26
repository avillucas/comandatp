<?php

use Core\Api\UsuarioApi;
use Core\Api\MozoApi;
use Core\Api\SocioApi;
use Core\Api\PreparadorApi;
use Core\Api\MesaApi;
use Core\Api\AlimentoApi;
use Core\Api\PedidoApi;
use Core\Api\ComandaApi;
use Core\Middleware\MWparaCORS;
use Core\Middleware\MWparaAutentificar;
// Routes

$app->group('/', function () {
    $this->post('login/', UsuarioApi::class . ':login');
    //usuarios
    $this->group('usuarios', function () {
        $this->get('/', UsuarioApi::class . ':TraerTodos');
        $this->get('/{id}/', UsuarioApi::class . ':TraerUno');
        $this->post('/', UsuarioApi::class . ':CargarUno');
        $this->post('/{id}/', UsuarioApi::class . ':ModificarUno');
        $this->delete('/{id}/',  UsuarioApi::class . ':BorrarUno');
    })
    ->add(MWparaAutentificar::class.':verificarSocio');
    //
    $this->group('socio', function () {
        $this->post('/',  SocioApi::class . ':CargarUno');
        //todo definir como manejar estos
    })
    ->add(MWparaAutentificar::class.':verificarSocio');
    //
    $this->group('preparador', function () {
        $this->get('/', PreparadorApi::class . ':TraerTodos');
        $this->get('/{id}/', PreparadorApi::class . ':TraerUno');
        $this->post('/', PreparadorApi::class . ':CargarUno');
        $this->post('/{id}/', PreparadorApi::class . ':ModificarUno');
        $this->delete('/{id}/',  PreparadorApi::class . ':BorrarUno');

    })
        ->add(MWparaAutentificar::class.':verificarSocio');
    //
    $this->group('mozo', function () {
        $this->get('/', MozoApi::class . ':TraerTodos');
        $this->get('/{id}/', MozoApi::class . ':TraerUno');
        $this->post('/', MozoApi::class . ':CargarUno');
        $this->post('/{id}/', MozoApi::class . ':ModificarUno');
        $this->delete('/{id}/',  MozoApi::class . ':BorrarUno');
    })
        ->add(MWparaAutentificar::class.':verificarSocio');
    //
    $this->group('pedidos', function () {
        $this->post('/', PedidoApi::class . ':CargarUno')->add(MWparaAutentificar::class.':verificarSocio');
        $this->get('/', PedidoApi::class . ':TraerTodos')->add(MWparaAutentificar::class.':verificarSocio');
        $this->get('/pendientes/',PedidoApi::class.':TraerPendientes')->add(MWparaAutentificar::class.':verificarUsuario');
        $this->get('/paraservir/',PedidoApi::class.':TraerParaServir')->add(MWparaAutentificar::class.':verificarMozo');
        $this->get('/{id}/', PedidoApi::class . ':TraerUno')->add(MWparaAutentificar::class.':verificarSocio');
        //TODO encontrar porque es que no toma el put
        $this->post('/preparar/', PedidoApi::class . ':preparar')->add(MWparaAutentificar::class.':verificarPreparadorPedido');
        $this->post('/alaorden/', PedidoApi::class . ':alaorden')->add(MWparaAutentificar::class.':verificarPreparadorPedido');
        $this->post('/{id}/', PedidoApi::class . ':ModificarUno');
        $this->delete('/{id}/',  PedidoApi::class . ':BorrarUno');
    })
        ;
    //
    $this->group('mesas', function () {
        $this->post('/', MesaApi::class . ':CargarUno')->add(MWparaAutentificar::class.':verificarSocio');
        $this->post('/comiendo/', MesaApi::class . ':MarcarClienteComiendo')->add(MWparaAutentificar::class.':verificarMozo');
        $this->post('/pagando/', MesaApi::class . ':MarcarPagando')->add(MWparaAutentificar::class.':verificarMozo');
        $this->post('/cerrar/', MesaApi::class . ':cerrar')->add(MWparaAutentificar::class.':verificarSocio');
        $this->get('/', MesaApi::class . ':TraerTodos')->add(MWparaAutentificar::class.':verificarSocio');
        $this->get('/{id}/', MesaApi::class . ':TraerUno')->add(MWparaAutentificar::class.':verificarSocio');
        $this->post('/{id}/', MesaApi::class . ':ModificarUno');
        $this->delete('/{id}/',  MesaApi::class . ':BorrarUno');
    })
    ;
    $this->group('alimentos', function () {
        $this->post('/', AlimentoApi::class . ':CargarUno');
        $this->get('/', AlimentoApi::class . ':TraerTodos');
        $this->get('/{id}/', AlimentoApi::class . ':TraerUno');
        $this->post('/{id}/', AlimentoApi::class . ':ModificarUno');
        $this->delete('/{id}/',  AlimentoApi::class . ':BorrarUno');
    })
    ->add(MWparaAutentificar::class.':verificarSocio');

    $this->group('comandas', function () {
        $this->post('/tomar/', ComandaApi::class . ':tomar')->add(MWparaAutentificar::class.':verificarMozo');
        $this->post('/', ComandaApi::class . ':cargarUno')->add(MWparaAutentificar::class.':verificarSocio');
        $this->post('/{id}/', ComandaApi::class . ':ModificarUno')->add(MWparaAutentificar::class.':verificarSocio');
        $this->get('/', ComandaApi::class . ':TraerTodos')->add(MWparaAutentificar::class.':verificarSocio');
        $this->get('/{id}/', ComandaApi::class . ':TraerUno')->add(MWparaAutentificar::class.':verificarSocio');
        $this->delete('/{id}/',  ComandaApi::class . ':BorrarUno')->add(MWparaAutentificar::class.':verificarSocio');

    });
})
//->add(MWparaCORS::class .':HabilitarCORS8080')
;
//TODO agregar middleware de Validacion de datos de cada peticion
//TODO agregar middleware que revise permisos ( politicas ) del usuario actual sobre la entidad a tocar