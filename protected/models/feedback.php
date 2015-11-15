<?php
 class Protected_Models_Feedback extends Core_DateBase // 
  {	  

		function isValidData($array_data){

    
		}
		
		function saveComment(){
		
		    $name=strip_tags(substr(trim($this->name),0,50));
            $email=strip_tags(substr(trim($this->email),0,50));
            $response=strip_tags(substr(trim($this->response),0,500),'<code><i><strike><strong><a>');
			
			$response=htmlspecialchars($response);
			
	       	$response=$this->close_tags($response);
			
            $time=time();
		    $published=0;
		    $changed=0;
		   
			$avatar = (isset($_SESSION['bild'])) ? $_SESSION['bild'] : '';
		
		    $sql="INSERT INTO comments(
            name,  email, data, comment, published, changed, avatar)
            VALUES( ?, ?, ?, ?, ?, ?, ? )";
		  
		    $stmt=$this->conn->prepare($sql);
            $stmt->execute(array($name, $email, $time, $response, $published, $changed, $avatar));
		

		}
		
		

    function close_tags($content)
    {
        $position = 0;
        $open_tags = array();
        //теги для игнорирования
        $ignored_tags = array('br', 'hr', 'img');

        while (($position = strpos($content, '<', $position)) !== FALSE)
        {
            //забираем все теги из контента
            if (preg_match("|^<(/?)([a-z\d]+)\b[^>]*>|i", substr($content, $position), $match))
            {
                $tag = strtolower($match[2]);
                //игнорируем все одиночные теги
                if (in_array($tag, $ignored_tags) == FALSE)
                {
                    //тег открыт
                    if (isset($match[1]) AND $match[1] == '')
                    {
                        if (isset($open_tags[$tag]))
                            $open_tags[$tag]++;
                        else
                            $open_tags[$tag] = 1;
                    }
                    //тег закрыт
                    if (isset($match[1]) AND $match[1] == '/')
                    {
                        if (isset($open_tags[$tag]))
                            $open_tags[$tag]--;
                    }
                }
                $position += strlen($match[0]);
            }
            else
                $position++;
        }
        //закрываем все теги
        foreach ($open_tags as $tag => $count_not_closed)
        {
            $content .= str_repeat("</{$tag}>", $count_not_closed);
        }
        return $content;
    }
	
    }
 ?>