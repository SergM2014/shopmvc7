<?php

class Protected_Models_Image extends Core_DataBase
{
    public function uploadAvatar(){
// Пути загрузки файлов
        $path = PATH_SITE.UPLOAD_FILE.'avatars/';
        $tmp_path= PATH_SITE.UPLOAD_FILE.'tmp/';
// Массив допустимых значений типа файла
        $types = array('image/gif', 'image/png', 'image/jpeg');

// Максимальный размер файла 20mb
        $size = 20480000;

// Обработка запроса
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Проверяем тип файла
            if (!in_array($_FILES['FileInput']['type'], $types))
                die('<p>Запрещённый тип файла.</p>');

            // Проверяем размер файла
            if ($_FILES['FileInput']['size'] > $size)
                die('Слишком большой размер файла.'.$_FILES['FileInput']['size']);

            $name = $this->resizeAvatar($_FILES['FileInput'], $tmp_path);

            // Загрузка файла и вывод сообщения
            if(!@copy($tmp_path.$name, $path.$name)) {
                $message='<p>Что-то пошло не так.</p>';
            }
            else {

                $_SESSION['avatar']= $name;

                $message='Загрузка прошла удачно.';
                chmod ($path.$name , 0777);
            }
            // Удаляем временный файл
            unlink(PATH_SITE.UPLOAD_FILE.'tmp/' . $name);
        }

        return $message;
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

        @unlink('uploads/avatars/'.$_SESSION['avatar']);
        $message='Изображение удаленно.';
        unset ($_SESSION['avatar']);

        return $message;
    }

}
