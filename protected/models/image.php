<?php

class Protected_Models_Image extends Core_DataBase
{
    public function uploadAvatar($admin=false){
// Пути загрузки файлов
        $path = PATH_SITE.UPLOAD_FILE.'avatars/';
        $tmp_path= PATH_SITE.UPLOAD_FILE.'tmp/';
// Массив допустимых значений типа файла
        $types = array('image/gif', 'image/png', 'image/jpeg');

// Максимальный размер файла 2mb
        $size = 2048000;

// Обработка запроса
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Проверяем тип файла
            if (!in_array($_FILES['FileInput']['type'], $types))
                
            return $response =['message'=>'Запрещённый тип файла', 'failure'=>true];

            // Проверяем размер файла
            if ($_FILES['FileInput']['size'] > $size)
                die('Слишком большой размер файла.'.$_FILES['FileInput']['size']);

            $name = $this->resizeAvatar($_FILES['FileInput'], $tmp_path);

            // Загрузка файла и вывод сообщения
            if(!@copy($tmp_path.$name, $path.$name)) {
                $response =['message'=>'<p>Что-то пошло не так.</p>', 'failure'=>true];
            }
            else {

                if($admin){
                    $_SESSION['admin_avatar_change'][$_POST['id']]= $name;
                } else {
                    $_SESSION['avatar']= $name;
                }


                $response=['message'=>'Загрузка прошла удачно.', 'success'=>true];
                chmod ($path.$name , 0777);
            }
            // Удаляем временный файл
            unlink(PATH_SITE.UPLOAD_FILE.'tmp/' . $name);
        }

        return $response;
    }


    // Функция изменения размера
    private function resizeAvatar($file, $tmp_path)
    {
        $file['name'] = strtolower($file['name']);
        $arr = explode('.', $file['name']);
        $file['name'] = $arr[0].'_'.time().'.'.$arr[1];

        // $w =100;
        $h=130;

        // Качество изображения по умолчанию
        $quality = 75;

        // Cоздаём исходное изображение на основе исходного файла
        if ($file['type'] == 'image/jpeg')
            $source = imagecreatefromjpeg($file['tmp_name']);
        elseif ($file['type'] == 'image/png')
            $source = imagecreatefrompng($file['tmp_name']);
        elseif ($file['type'] == 'image/gif')
            $source = imagecreatefromgif($file['tmp_name']);
        else
            return false;

        // Определяем ширину и высоту изображения
        $w_src = imagesx($source);
        $h_src = imagesy($source);

        // Если высота больше заданной
        if($h_src>$h){
            // Вычисление пропорций
            $ratio = $h_src/$h;
            $w_dest = round($w_src / $ratio);
            $h_dest = round($h_src / $ratio);

            // Создаём пустую картинку
            $dest = imagecreatetruecolor($w_dest, $h_dest);

            // Копируем старое изображение в новое с изменением параметров
            imagecopyresampled($dest, $source, 0, 0, 0, 0, $w_dest, $h_dest, $w_src, $h_src);

            // Вывод картинки и очистка памяти
            imagejpeg($dest, $tmp_path. $file['name'], $quality);
            imagedestroy($dest);
            imagedestroy($source);
            chmod ($tmp_path . $file['name'] , 0777);

            return $file['name'];
        } else {
            // Вывод картинки и очистка памяти
            //output image into browser or file
            imagejpeg($source, $tmp_path. $file['name'], $quality);
            imagedestroy($source);
            chmod ($tmp_path . $file['name'] , 0777);

            return $file['name'];
        }
    }


    public function deleteAvatar(){

        @unlink(PATH_SITE.'/uploads/avatars/'.$_SESSION['avatar']);
        $message='Изображение удаленно.';
        unset ($_SESSION['avatar']);

        return $message;
    }


    public function uploadImage(){
        $id= $_POST['id'];

        $path = PATH_SITE.UPLOAD_FILE.'product_images/';

        $thumb_path = PATH_SITE.UPLOAD_FILE.'product_images/thumbs/';
// Массив допустимых значений типа файла
        $types = array('image/gif', 'image/png', 'image/jpeg');

// Максимальный размер файла 2mb
        $size = 2048000;

// Обработка запроса
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Проверяем тип файла
            if (!in_array(strtolower($_FILES['FileInput']['type']), $types))
                die('Запрещённый тип файла.');

            // Проверяем размер файла
            if ($_FILES['FileInput']['size'] > $size)
                die('Слишком большой размер файла.'.$_FILES['FileInput']['size']);

            $name = $this->thumbImage($_FILES['FileInput'], $thumb_path);


           move_uploaded_file($_FILES['FileInput']['tmp_name'], $path.$name);
            if(!file_exists($path.$name)){
               $response['message']='Что-то пошло не так.';
           } else {
                $response['message']='Загрузка прошла удачно.';
               chmod ($path.$name , 0777);
               // $_SESSION['product_image'][$id]= $name;
                $_SESSION['product_image'][$id] = $name;
                $response['name']= $name;
           }

        }

        return $response;

    }


    // Функция изменения размера
    private function thumbImage($file, $thumb_path)
    {
        $file['name'] = strtolower($file['name']);
        $arr = explode('.', $file['name']);

        $file['name'] = $_POST['id'].'.'.$arr[1];

        $w = 130;
        $h = 130;

        // Качество изображения по умолчанию
        $quality = 75;

        // Cоздаём исходное изображение на основе исходного файла
        if ($file['type'] == 'image/jpeg')
            $source = imagecreatefromjpeg($file['tmp_name']);
        elseif ($file['type'] == 'image/png')
            $source = imagecreatefrompng($file['tmp_name']);
        elseif ($file['type'] == 'image/gif')
            $source = imagecreatefromgif($file['tmp_name']);
        else
            return false;

        // Определяем ширину и высоту изображения
        $w_src = imagesx($source);
        $h_src = imagesy($source);

        if($h_src> $w_src) {
            // Вычисление пропорций
            $ratio = $h_src / $h;
        } else{
            $ratio = $w_src/$w;
        }
            $w_dest = round($w_src / $ratio);
            $h_dest = round($h_src / $ratio);

            // Создаём пустую картинку
            $dest = imagecreatetruecolor($w_dest, $h_dest);

            // Копируем старое изображение в новое с изменением параметров
            imagecopyresampled($dest, $source, 0, 0, 0, 0, $w_dest, $h_dest, $w_src, $h_src);

            // Вывод картинки и очистка памяти
            imagejpeg($dest, $thumb_path. $file['name'], $quality);
            imagedestroy($dest);
            imagedestroy($source);
            chmod ($thumb_path . $file['name'] , 0777);

            return $file['name'];
    }



    public function deleteImage(){

        $_SESSION['delete_image_product'][$_POST['id']]= $_SESSION['product_image'][$_POST['id']];
        $message='Изображение удаленно.';
        unset ($_SESSION['product_image'][$_POST['id']]);

        return $message;
    }

    public function deleteAdminAvatar(){

       // unlink(PATH_SITE.'/uploads/avatars/'.$_SESSION['admin_avatar_change'][$_POST['id']]);
        $response=['message'=>'Изображение удаленно.', 'success'=>true ];
        unset ($_SESSION['admin_avatar_change'][$_POST['id']]);

        return $response;
    }

}
