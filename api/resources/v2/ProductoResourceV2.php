<?php

require_once __DIR__ . '/../v1/ProductoResource.php';
require_once __DIR__ . '/../../core/AuthFilter.php';

class ProductoResourceV2 extends ProductoResource {
    public $auth;

    public function __construct() {
        // Inicializamos el filtro y validamos el token
        $this->auth = new AuthFilter();
        $this->auth->authenticate(); 
        // Si el token no sirve, authenticate() finaliza el script con 401.
        
        // Si sirve, ejecutamos el constructor original de ProductoResource
        parent::__construct();
    }
}
?>
