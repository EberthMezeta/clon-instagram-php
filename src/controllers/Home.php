<?php 

namespace Eberth\Instagram\controllers;

use Eberth\Instagram\lib\Controller;
use Eberth\Instagram\lib\UtilImages;
use Eberth\Instagram\models\User;
use Eberth\Instagram\models\PostImage;

class Home extends Controller
{
    public function __construct(private User $user) 
    {
        
        parent :: __construct();
        
        $this->user = $user;
    }

    public function index()
    {
        $posts = PostImage::getFeed();
        $this->render('home/index',['user'=>$this->user, 'posts' => $posts]);
    }

    public function store()
    {
        $title = $this->post('title');
        $image = $this->file('image');

        if (!is_null($title) && !is_null($image)) {
            $filename = UtilImages::storeImage($image);
            $post = new PostImage($title,$filename);
            $this->user->publish($post);
            header('location: /instagram/home');
        }else{
            header('location: /instagram/home'); 
        }

    }

}



?>