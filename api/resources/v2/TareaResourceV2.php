<?php

require_once __DIR__ . '/../v1/TareaResource.php';
require_once __DIR__ . '/../../core/AuthFilter.php';

class TareaResourceV2 extends TareaResource
{
    public $auth;

    public function __construct()
    {
        // filtro y validar token de autenticación
        $this->auth = new AuthFilter();
        $this->auth->authenticate();
        // Si el token no es válido o no existe, authenticate() responde 401 y finaliza la ejecución

        // Si la autenticación es exitosa, se ejecuta el constructor de la clase base
        parent::__construct();
    }
}
