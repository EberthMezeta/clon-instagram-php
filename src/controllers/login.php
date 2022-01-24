<?php 
namespace Eberth\Instagram\controllers;

use Eberth\Instagram\lib\Controller;
use Eberth\Instagram\models\User;

class Login extends Controller
{
    public function __construct() {
        parent :: __construct();
    }

    public function auth() 
    {
        $username = $this->post('username');
        $password = $this->post('password');

        if (!is_null($username) && !is_null($password)) {

            if (User::exists($username)) {
                $user = User:: getUser($username);
                if ($user -> comparePassword($password)) {
                    $_SESSION['user'] = serialize($user);

                    header('location: /instagram/home');
                }else{
                   echo('contraseña incorrecta');
                }
            }else{
                echo('no existe el usuario');
            }
            
        }else{
            echo('evia bien los datos');
        }
    }
}




?>