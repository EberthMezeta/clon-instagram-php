<?php

use Eberth\Instagram\controllers\Signup;
use Eberth\Instagram\controllers\login;
use Eberth\Instagram\controllers\Home;
use Eberth\Instagram\controllers\Actions;
use Eberth\Instagram\controllers\Profile;

$router = new \Bramus\Router\Router();
session_start();

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../config/');
$dotenv->load();

function noAuth(){
    if (!isset($_SESSION['user'])) {
        header('location: /instagram/login');
        exit();
    }
}

function auth(){
    if (isset($_SESSION['user'])) {
        header('location: /instagram/home');
        exit();
    }
}

$router->get('/',function (){
    header('location: /instagram/login');
});

$router->get('/login',function (){
    auth();
    $controller = new Login();
    $controller -> render('login/index');
});

$router->post('/auth',function (){
    auth();
    $controller = new Login();
    $controller -> auth();
});

$router->get('/signup',function (){
    auth();
    $controller = new Signup;
    $controller -> render('signup/index');
});

$router->post('/register',function (){
    auth();
    $controller = new Signup;
    $controller -> register();
});

$router->get('/home',function (){
    noAuth();
    $user = unserialize($_SESSION['user']);
    $controller = new Home($user);
    $controller -> index('home/index');
});

$router->post('/publish',function (){
    noAuth();
    $user = unserialize($_SESSION['user']);
    $controller = new Home($user);
    $controller -> store();
});

$router->get('/profile',function (){
    noAuth();
    $user = unserialize($_SESSION['user']);
    $controller = new Profile();
    $controller -> getUserProfile($user);
});


$router->get('/profile/{username}',function ($username){
    noAuth();
    $controller = new Profile();
    $controller -> getUsernameProfile($username);
});

$router->post('/addlike',function (){
    noAuth();
    $user = unserialize($_SESSION['user']);
    $controller = new Actions($user);
    $controller -> like();
});

$router->get('/signuot',function (){
    noAuth();
    unset($_SESSION['user']);
    header('location: /instagram/login');
});


$router->run();

?>