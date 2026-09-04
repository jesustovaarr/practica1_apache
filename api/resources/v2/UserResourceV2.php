<?php

require_once __DIR__ . '/../v1/UserResource.php';
require_once __DIR__ . '/../../core/AuthFilter.php';

class UserResourceV2 extends UserResource {
    public $auth;

    public function __construct() {
        // Inicializamos el filtro y validamos el token
        $this->auth = new AuthFilter();
        $this->auth->authenticate(); 
        
        // Si sirve, ejecutamos el constructor original de UserResource
        parent::__construct();
    }
}
?>
