<?php

namespace MVC;

use MVC\Controllers\RoleController;
use MVC\Controllers\UserController;
use MVC\Router;

$router = new Router();

$router->addRoute('/', UserController::class, 'index', 'GET');
$router->addRoute('/create-users', UserController::class, 'createUser', 'GET');
$router->addRoute('/add-roles', RoleController::class, 'addRoles', 'POST');
$router->addRoute('/delete-roles', RoleController::class, 'deleteRoles', 'POST');
$router->addRoute('/update-roles', RoleController::class, 'updateRoles', 'POST');
$router->addRoute('/detail-users', UserController::class, 'detailUser', 'GET');
$router->addRoute('/update-users', UserController::class, 'updateUser', 'POST');
$router->addRoute('/delete-users', UserController::class, 'deleteUser', 'POST');
$router->addRoute('/add-users', UserController::class, 'addUser', 'POST');