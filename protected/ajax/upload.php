<?php
     include_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
	 session_start();
		
		$formats=explode(',',VALID_FORMATS);
		$valid_formats=array();
		  foreach($formats as $one){
		     $valid_formats[]=trim($one, ' ');
		  }
        
            if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") // пришел запрос
            {
                $name = $_FILES['FileInput']['name'] ; // имя файла
                $size = $_FILES['FileInput']['size'] ; // размер файла
				
				$name=strtolower($name);
				
                if(strlen($name))
                {
                    list($txt, $ext) = explode(".", $name) ; // разбиваем на имя и формат
                    if(in_array($ext,$valid_formats))    // смотрим формат такой как мы разрешили?!
                    {
                        if($size < (1024 * 1024 * 1024*2)) // Ограничиваем размер файла в 1MB*2
							{   
							   
							   $actual_image_name = time() . ".jpeg"  ;
							   $tmp = $_FILES['FileInput']['tmp_name'];
							   
							  
							  
								   switch($_FILES['FileInput']['type'])
								    {						// узнаем тип картинки 
									  case "image/gif": $im = imagecreatefromgif($tmp); break; 
									  case "image/jpeg": $im = imagecreatefromjpeg($tmp); break; 
									  case "image/png": $im = imagecreatefrompng($tmp); break; 
									  case "image/pjpeg": $im = imagecreatefromjpeg($tmp); break; 
								    }
														   
								  list($w,$h) = getimagesize($tmp); // берем высоту и ширину 
								   
								   
								   
								if($w<70 && $h<90)
								{
								   
								   if(move_uploaded_file($tmp, PATH_SITE.'/'.UPLOAD_FILE . '/' . $actual_image_name))
								  { 
									echo '<h3>Изображение загружено</h3>';
								 
									$_SESSION['bild']=$actual_image_name;
								 
								 }
							     else echo "Ошибка. =(";
								}   
								  else 
								{  
								  
								  if($w>$h){
								    $koe=$w/70; 
								    $new_h=ceil($h/$koe); 
								    $im1 = imagecreatetruecolor(70, $new_h); 
								    imagecopyresampled($im1, $im,0,0,0,0,70,$new_h,imagesx($im),imagesy($im));
									}
									else
									{$koe=$h/90; 
								    $new_w=ceil($w/$koe); 
								    $im1 = imagecreatetruecolor($new_w, 90); 
								    imagecopyresampled($im1, $im,0,0,0,0,$new_w,90,imagesx($im),imagesy($im));
									}
									
								    imageconvolution($im1, array( 
								    array(-1,-1,-1), 
								    array(-1,16,-1), 
								    array(-1,-1,-1) ), 
								    8, 0); 
								  
								    imagejpeg($im1,  PATH_SITE.'/'.UPLOAD_FILE.'/'. $actual_image_name,75); 
									 imagedestroy($im); 
									 imagedestroy($im1); 

								 
								 if(file_exists(PATH_SITE.'/'.UPLOAD_FILE . '/' . $actual_image_name))
								  {
										echo '<h3>Изображение загружено</h3>';
										$_SESSION['bild']=$actual_image_name;
                                  								 
								 }
							     else echo "Ошибка. =1(";
							    }
							    
									
								
                            }
                        else echo "Максимальный размер файла не должен превышать 1*2 MB"; 
                    }
                    else echo "Допустимые форматы: jpg|jpeg|png|gif)"; 
                }
                else die("Пожалуйста выберите изображение!") ;
            }
			exit;

