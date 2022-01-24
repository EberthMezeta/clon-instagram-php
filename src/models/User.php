<?php 


namespace Eberth\Instagram\models;

use Eberth\Instagram\lib\Database;
use Eberth\Instagram\lib\Model;
use PDO;
use PDOException;

class User extends Model
{
    private int $id;
    private array $posts;
    private string $profile;


    public function __construct(private string $username, private string $password) {
        parent :: __construct();
        $this->posts = [];
        $this->profile = "";
        $this->id = -1;
    }


    public function save()
    {
        try {

            //Validate if user exists after

            $hash = $this->getHashedPassword($this->password);
            $query = $this->prepare('INSERT INTO users (username,password,profile) VALUES (:username, :password, :profile)');
            $query-> execute([
                'username' => $this->username,
                'password' => $hash,
                'profile' => $this->profile
            ]);

        } catch (PDOException $e) {
            
        }
    }

    public function getHashedPassword ($password)
    {
        return password_hash($password, PASSWORD_DEFAULT,['cost' => 10]);
    }


    public static function exists($username)
    {
        try {
            
            $db = new Database();
            $query = $db->connect()->prepare('SELECT username FROM users where username = :username');
            $query -> execute(['username' => $username]);

            if ($query->rowCount() > 0) {
                return true;
            }else{
                return false;
            }
            
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public static function getUser($username)
    {
        try {
            $db = new Database();
            $query = $db->connect()->prepare('SELECT * FROM users where username = :username');
            $query -> execute(['username' => $username]);

            $data = $query-> fetch(PDO::FETCH_ASSOC);
            $user = new User($data['username'],$data['password']);
            $user->setId($data['user_id']);
            $user->setProfile($data['profile']);

            return $user;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }


    public static function getUserById(string $user_id): User
    {
        try {
            $db = new Database();
            $query = $db->connect()->prepare('SELECT * FROM users where user_id = :user_id');
            $query -> execute(['user_id' => $user_id]);

            $data = $query-> fetch(PDO::FETCH_ASSOC);
            $user = new User($data['username'],$data['password']);
            $user->setId($data['user_id']);
            $user->setProfile($data['profile']);

            return $user;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }


    public function publish(PostImage $post)
    {
       try {
        $query = $this->prepare('INSERT INTO posts(user_id,title,media) VALUES (:user_id, :title,:media)');
        $query-> execute([
            'user_id' => $this->id,
            'title' => $post-> getTitle(),
            'media' => $post-> getImage()
        ]);
            return true;
       } catch (PDOException $e) {
           return false;
       }
    }


    public function fetchposts(){
        $this->posts = PostImage::getAll($this->id);
    }


    public function comparePassword(string $password):bool{
        return password_verify($password,$this->password);
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id= $id;
    }

    
    public function getPosts()
    {
        return $this->posts;
    }

    
    public function setPosts($posts)
    {
        $this->posts = $posts;
    }

    public function getProfile()
    {
        return $this->profile;
    }

    
    public function setProfile($profile)
    {
        $this->profile = $profile;
    }

    
    public function getUsername()
    {
        return $this->username;
    }

}


?>