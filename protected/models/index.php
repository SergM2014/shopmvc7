<?php

 class Protected_Models_Index extends Core_DataBase
  {	  
    public function getSlider()
        {
         $sql ="SELECT `image`, `url`, `title` FROM `slider`";
         $result = $this->conn->query($sql);
         $result = $result->fetchAll(PDO::FETCH_ASSOC);
         return $result;
        }

     public function getCategories()
         {
             $sql ="SELECT `id`, `title`, `translit_title`, `parent_id` FROM `categories`";
             $result = $this->conn->query($sql);
             $result = $result->fetchAll(PDO::FETCH_ASSOC);
             return $result;
         }

     public function getleftMenu($categories, $parent = 0)
         {
             if(!isset($print)){$print='';}
             foreach($categories as $category){
                 if($category['parent_id'] ==$parent ){

                     $print.='<li class="menu-item parent-'.$category['parent_id'].'"><span  data-id="'. $category['id'] .'">'.$category['title'].'</span>' ;
                     foreach($categories as $sub_cat){
                         if($sub_cat['parent_id']==$category['id']){
                             $flag = TRUE; break;
                         }
                     }

                     if(isset($flag)){
                         $print.= "<ul class='invisible'>";
                         $print.= $this->getleftMenu($categories, $category['id']);
                         $print.= "</ul>";
                         $print.= "</li>";
                     } else{
                         $print.="</li>";
                     }
                 }
             }
             return $print;
         }

     public function getCarousel()
         {
             $sql = "SELECT `id`, `image`, `url` FROM `carousel`";
             $result = $this->conn->query($sql);
             $result = $result->fetchAll(PDO::FETCH_ASSOC);
             return $result;
         }


     public function getAboutInformation()
         {
             $sql="SELECT `about` FROM  `background`";
             $result= $this->conn->query($sql);
             $result = $result ->fetch(PDO::FETCH_ASSOC);
             return htmlspecialchars_decode($result['about']);
         }

	
  }
  
