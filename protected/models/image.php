<?php

class Protected_Models_Image extends Core_DataBase{

        public function uploadAvatar($admin=false){
    // Пути загрузки файлов

            $path = PATH_SITE.UPLOAD_FILE.'avatars/';
            $tmp_path= PATH_SITE.UPLOAD_FILE.'tmp/';
    // Массив допустимых значений типа файла
            $types = array('image/gif', 'image/png', 'image/jpeg');

    // Максимальный размер файла 2mb
           $size = 2048000;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Проверяем тип файла
            if (!in_array(strtolower($_FILES['FileInput']['type']), $types))

            return $response =["message"=>"<span class='error'>Запрещённый тип файла.</span>", "error"=>true];

            // Проверяем размер файла
            if ($_FILES['FileInput']['size'] > $size)

            return $response =["message"=>"<span class='error'>Слишком большой размер файла.".$_FILES['FileInput']['size']."</span>", "error" => true];

            $name = $this->resizeAvatar($_FILES['FileInput'], $tmp_path);

            // Загрузка файла и вывод сообщения
            if(!@copy($tmp_path.$name, $path.$name)) {
                return $response =["message"=>"<span class='error'>Что-то пошло не так.</span>", "error" => true];
            }
            else {

                if($admin){
                    $_SESSION['admin_avatar_change'][$_POST['id']]= $name;
                } else {
                    $_SESSION['avatar']= $name;
                }


                $response=["message"=>"<span class='success'>Загрузка прошла удачно.</span>", "success"=>true];
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
           /* var_dump($file);
            echo "<br>";
            var_dump($tmp_path);*/

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


        public function deleteAvatar()
        {
            unset ($_SESSION['avatar']);
            $response= ["message"=>"<span class='red'>Изображение удаленно.</span>", "success"=>true];

            return $response;
        }


        public function uploadImage()
        {
            $id= $_POST['id'];
            $path = PATH_SITE.UPLOAD_FILE.'product_images/';
            $thumb_path = PATH_SITE.UPLOAD_FILE.'product_images/thumbs/';
    // Массив допустимых значений типа файла
            $types = array('image/gif', 'image/png', 'image/jpeg', 'image/jpg');

    // Максимальный размер файла 2mb
           // $size = 2048000;
            //schon gewesen20mb
            $size =20480000;

    // Обработка запроса
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Проверяем тип файла
                if (!in_array(strtolower($_FILES['FileInput']['type']), $types))
                   return ["message"=>"Запрещённый тип файла", "error"=>true, "file_type"=>strtolower($_FILES['FileInput']['type'])];

                // Проверяем размер файла
                if ($_FILES['FileInput']['size'] > $size)
                    return ["message"=>'Слишком большой размер файла.'.$_FILES['FileInput']['size'], "error"=>true];

                $name = $this->thumbImage($_FILES['FileInput'], $thumb_path);


               move_uploaded_file($_FILES['FileInput']['tmp_name'], $path.$name);

               unset($_FILES['FileInput']);

                if(!file_exists($path.$name)){
                   $response=["message"=>"Что-то пошло не так.", "error"=>true];
               } else {
                    $response=["message"=>"Загрузка прошла удачно.", "success"=>true, "add_section"=> true ];
                   chmod ($path.$name , 0777);

                    $_SESSION['product_image'][$id] = $name;
                    $response["name"]= $name;
               }
               return $response;
            }

            return ["message"=>"something went wrong","error"=>true];

        }


        // Функция изменения размера
        private function thumbImage($file, $thumb_path)
        {
            $file['name'] = strtolower($file['name']);
            $arr = explode('.', $file['name']);

            $file['name'] = $_POST['id'].'.'.$arr[1];

            $w=300;
            $h=300;

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



        public function deleteImage()
        {
            $response=["message"=>"Изображение удаленно.", "success"=>true ];
            unset ($_SESSION['product_image'][$_POST['id']]);

            return $response;
        }

        public function deleteAdminAvatar()
        {
            $response=['message'=>'Изображение удаленно.', 'success'=>true ];
            unset($_SESSION['admin_avatar_change'][$_POST['id']]);

            return $response;
        }

        public function uploadSlider()
        {
            $path = PATH_SITE.UPLOAD_FILE.'slider/';
            $types = array('image/gif', 'image/png', 'image/jpeg');
    // Максимальный размер файла 2mb
            $size = 2048000;

    // Обработка запроса
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Проверяем тип файла
                if (!in_array(strtolower($_FILES['FileInput']['type']), $types)) return $response=["message"=>"Запрещённый тип файла.", "error"=>true ];
                // Проверяем размер файла
                if ($_FILES['FileInput']['size'] > $size)  return $response=["message"=>"Слишком большой размер файла.".$_FILES['FileInput']['size'], "error"=>true ];

               // $name = $this->thumbImage($_FILES['FileInput'], $thumb_path);
                $name = strtolower($_FILES['FileInput']['name']);

                move_uploaded_file($_FILES['FileInput']['tmp_name'], $path.$name);
                if(!file_exists($path.$name)){
                    $response=["message"=>"Что-то пошло не так.", "error"=>true ];;
                } else {
                    $response=["message"=>"Загрузка прошла удачно.", "success"=>true];
                    chmod ($path.$name , 0777);

                    $_SESSION['slider'] = $name;

                    $response['name']= $name;
                }

            }

            return $response;

        }


        public function deleteSlider()
        {
            $response=['message'=>'Изображение удаленно.', 'success'=>true ];
            unset ($_SESSION['slider']);

            return $response;
        }




        private function thumbCarouselImage($file, $thumb_path)
        {
            $file['name'] = strtolower($file['name']);

            $h = 100;
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



            $ratio = $h_src/$h;

            $w_dest = round($w_src / $ratio);
            //$h_dest = round($h_src / $ratio);
            $h_dest= $h;

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


        public function uploadCarousel(){

            $path = PATH_SITE.UPLOAD_FILE.'carousel/';
    // Массив допустимых значений типа файла
            $types = array('image/gif', 'image/png', 'image/jpeg');
    // Максимальный размер файла 2mb
            $size = 2048000;

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Проверяем тип файла
                if (!in_array(strtolower($_FILES['FileInput']['type']), $types)) return $response=["message"=>"Запрещённый тип файла.", "error"=>true];
                // Проверяем размер файла
                if ($_FILES['FileInput']['size'] > $size)  return $response=["message"=>"Слишком большой размер файла.".$_FILES['FileInput']['size'], "error"=>true];

                 $name = $this->thumbCarouselImage($_FILES['FileInput'], $path);

                if(!file_exists($path.$name)){
                    $response=["message"=>"Что-то пошло не так.","error"=>true];
                } else {
                    $response=["message"=>"Загрузка прошла удачно.", "success"=>true];
                    chmod ($path.$name , 0777);
                    $_SESSION['carousel'] = $name;
                    $response['name']= $name;
                }
            }

            return $response;

        }


        public function deleteCarousel()
        {
            $response = ['message' => 'Изображение  карусели удаленно.', 'success' => true];
            unset ($_SESSION['carousel']);

            return $response;
        }

    }
