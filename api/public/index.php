<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../core/Router.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (strpos($uri, '/api/v2') !== false) {
    // rutas version 2
    require_once '../resources/v2/AuthResource.php';
    require_once '../resources/v2/ProductoResourceV2.php';
    require_once '../resources/v2/UserResourceV2.php';
    
    $basePath = dirname($_SERVER['SCRIPT_NAME']);
    
    $routerV2 = new Router('v2', $basePath);
    
    $authResource = new AuthResource();
    $productoResourceV2 = new ProductoResourceV2();
    $userResourceV2 = new UserResourceV2();
    
    // rutas login
    $routerV2->addRoute('POST', '/login', [$authResource, 'login']);
    
    // rutas de sesión
    $routerV2->addRoute('POST', '/logout', [$authResource, 'logout']);
    $routerV2->addRoute('GET', '/me', [$authResource, 'me']);
    
    // rutas de usuarios
    $routerV2->addRoute('GET', '/users', [$userResourceV2, 'index']);
    $routerV2->addRoute('GET', '/users/{id}', [$userResourceV2, 'show']);
    $routerV2->addRoute('POST', '/users', [$userResourceV2, 'store']);
    $routerV2->addRoute('PUT', '/users/{id}', [$userResourceV2, 'update']);
    $routerV2->addRoute('DELETE', '/users/{id}', [$userResourceV2, 'destroy']);

    // rutas de productos
    $routerV2->addRoute('GET', '/productos', [$productoResourceV2, 'index']);
    $routerV2->addRoute('GET', '/productos/{id}', [$productoResourceV2, 'show']);
    $routerV2->addRoute('POST', '/productos', [$productoResourceV2, 'store']);
    $routerV2->addRoute('PUT', '/productos/{id}', [$productoResourceV2, 'update']);
    $routerV2->addRoute('DELETE', '/productos/{id}', [$productoResourceV2, 'destroy']);
    
    $routerV2->dispatch();

} else {
    // rutas v1
    require_once '../resources/v1/UserResource.php';
    require_once '../resources/v1/ProductoResource.php';

    //$scriptName = dirname($_SERVER['SCRIPT_NAME']);
    //$basePath = $scriptName;

    //$router = new Router('v1', '/22030344/api/public');
    $router = new Router('v1', '/api/public');
    $userResource = new UserResource();
    $productoResource = new ProductoResource();

    // rutas de usuarios
    $router->addRoute('GET', '/users', [$userResource, 'index']);
    $router->addRoute('GET', '/users/{id}', [$userResource, 'show']);
    $router->addRoute('POST', '/users', [$userResource, 'store']);
    $router->addRoute('PUT', '/users/{id}', [$userResource, 'update']);
    $router->addRoute('DELETE', '/users/{id}', [$userResource, 'destroy']);

    // rutas de productos
    $router->addRoute('GET', '/productos', [$productoResource, 'index']);
    $router->addRoute('GET', '/productos/{id}', [$productoResource, 'show']);
    $router->addRoute('POST', '/productos', [$productoResource, 'store']);
    $router->addRoute('PUT', '/productos/{id}', [$productoResource, 'update']);
    $router->addRoute('DELETE', '/productos/{id}', [$productoResource, 'destroy']);

    $router->dispatch();

}
?>