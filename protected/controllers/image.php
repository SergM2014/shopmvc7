<?php

class Protected_Controllers_Image extends Core_BaseController
{
    public function upload()
    {
// Пути загрузки файлов

        $path = PATH_SITE.UPLOAD_FILE.'avatars/';
        $tmp_path= PATH_SITE.UPLOAD_FILE.'tmp/';
// Массив допустимых значений типа файла
        $types = array('image/gif', 'image/png', 'image/jpeg');

// Максимальный размер файла
       // $size = 1024000;
        $size= 2048000;

// Обработка запроса
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Проверяем тип файла
            if (!in_array($_FILES['FileInput']['type'], $types))
                die('<p>Запрещённый тип файла.</p>');

            // Проверяем размер файла
            if ($_FILES['FileInput']['size'] > $size)
                die('Слишком большой размер файла.'.$_FILES['FileInput']['size']);

            $name = $this->resize($_FILES['FileInput'], $tmp_path, $path);

            // Загрузка файла и вывод сообщения

                if(!@copy($tmp_path.$name, $path.$name)) {
                    $message='<p>Что-то пошло не так.</p>';
                }
            else {
                $_SESSION['avatar']= $tmp_path.$name;

                $message='<p>Загрузка прошла удачно.</p>';
                chmod ($path.$name , 0777);
            }
            // Удаляем временный файл
            unlink(PATH_SITE.UPLOAD_FILE.'tmp/' . $name);
        }
        return ['ajax'=>1, 'message'=> $message, 'view'=>'uploadimage/uploadresponce.php'];
    }


    // Функция изменения размера
    private function resize($file, $tmp_path)
    {
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

        // Если ширина больше заданной
       // if ($w_src > $w) {
        if($h_src>$h){
            // Вычисление пропорций
           // $ratio = $w_src / $w;
            $ratio = $h_src/$h;
            $w_dest = round($w_src / $ratio);
            $h_dest = round($h_src / $ratio);

            // Создаём пустую картинку
            $dest = imagecreatetruecolor($w_dest, $h_dest);

            // Копируем старое изображение в новое с изменением параметров
            imagecopyresampled($dest, $source, 0, 0, 0, 0, $w_dest, $h_dest, $w_src, $h_src);

            // Вывод картинки и очистка памяти
            imagejpeg($dest, $tmp_path . $file['name'], $quality);
            imagedestroy($dest);
            imagedestroy($source);
            chmod ($tmp_path . $file['name'] , 0777);

            return $file['name'];
        } else {
            // Вывод картинки и очистка памяти
            //output image into browser or file
            imagejpeg($source, $tmp_path . $file['name'], $quality);
            imagedestroy($source);
            chmod ($tmp_path . $file['name'] , 0777);

            return $file['name'];
        }
    }

    public function delete(){

        @unlink($_SESSION['avatar']);
        $message='<p>Изображение удаленно.</p>';
       // unset ($_SESSION['avatar']);
        return ['view'=> 'uploadimage/deletedimage.php', 'message'=>$message, 'ajax'=> 1];
}

}
?>