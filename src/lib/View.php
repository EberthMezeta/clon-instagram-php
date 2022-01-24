<?php 

namespace Eberth\Instagram\lib;

class View{

    function render(string $name, array $data = [])
    {
        $this->data = $data;
        require 'src/views/' . $name . '.php';
    }

}

?>