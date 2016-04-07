<?php

class Protected_Models_Admin extends Core_DataBase
{
    function getAdmin($data)
    {
        if (!isset($data['login']) OR !isset($data['password'])) return false;
        $sql = "SELECT login, password FROM users";
        $stmt = $this->conn->query($sql);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($row['login'] == $data['login'] && $row['password'] == md5($data['password'])) {
                $_SESSION['admin'] = true;
                $_SESSION['login'] = $row['login'];

                return true;
            }
        }
        return false;
    }

    //убираем лишни картинки с всех директорий
    public function scavengeImages()
    {
        $sql="SELECT `images` FROM `products` WHERE `images` IS NOT NULL";
        $res= $this->conn->query($sql);
        $result = $res->fetchAll(PDO::FETCH_ASSOC);

        $db_images=[];
        foreach($result as $one){
        $db_images= array_merge($db_images, unserialize($one['images']));
        }



        $sql= "SELECT `avatar` FROM `comments` WHERE `avatar` IS NOT NUll";
        $res= $this->conn->query($sql);
        $result = $res->fetchAll(PDO::FETCH_ASSOC);

        $comments_images=[];
        foreach ($result as $one){
            $comments_images[] = $one['avatar'];
        }

        $sql= "SELECT `image` FROM `slider` WHERE `image` IS NOT NUll";
        $res= $this->conn->query($sql);
        $result = $res->fetchAll(PDO::FETCH_ASSOC);

        $slider_images=[];
        foreach ($result as $one){
            $slider_images[] = $one['image'];
        }

        $sql= "SELECT `image` FROM `carousel` WHERE `image` IS NOT NUll";
        $res= $this->conn->query($sql);
        $result = $res->fetchAll(PDO::FETCH_ASSOC);

        $carousel_images=[];
        foreach ($result as $one){
            $carousel_images[] = $one['image'];
        }

        $this->getAndDeleteRedunduntImages(PATH_SITE.'/uploads/product_images/', $db_images);
        $this->getAndDeleteRedunduntImages(PATH_SITE.'/uploads/product_images/thumbs/', $db_images);

        $this->getAndDeleteRedunduntImages(PATH_SITE.'/uploads/avatars/', $comments_images);

        $this->getAndDeleteRedunduntImages(PATH_SITE.'/uploads/slider/', $slider_images);

        $this->getAndDeleteRedunduntImages(PATH_SITE.'/uploads/carousel/', $carousel_images);


    }



    private function getAndDeleteRedunduntImages($folder, $images_from_bd)
    {
        $product_folder_content= scandir($folder);

        $product_images=[];
        foreach($product_folder_content as $file){
            if(is_file($folder.$file)) {
                $product_images[] = $file;
            }
        }

        $difference= array_diff($product_images, $images_from_bd);

        foreach ($difference as $image){
            @unlink($folder.$image);
        }

    }



}
?>