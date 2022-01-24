<?php 

namespace Eberth\Instagram\lib;

class Controller
{
    private View $view;

    public function __construct() {
        $this->view = new View();
    }

    public function render(string $name , array $data = [])
    {
        $this->view->render($name,$data);
    }

    protected function post($param)
    {
        $receivedParameter = $_POST[$param];

        if (!isset( $_POST[$param])) {
            return null;
        }

        return  $_POST[$param];
    }

    protected function get($param)
    {
        $receivedParameter = $_GET[$param];

        if (!isset($_GET[$param])) {
            return null;
        }

        return $_GET[$param];
    }

    protected function file($param)
    {
        $receivedParameter = $_FILES[$param];

        if (!isset($_FILES[$param])) {
            return null;
        }

        return $_FILES[$param];
    }

}

?>