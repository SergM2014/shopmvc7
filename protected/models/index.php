<?php

 class Protected_Models_Index extends Core_DateBase
  {	  
    function getSlider(){
     $sql ="SELECT `image`, `url` FROM `slider`";
     $result = $this->conn->query($sql);
     $result = $result->fetchAll(PDO::FETCH_ASSOC);
     return $result;
    }

     function getCategories(){
         $sql ="SELECT `category_id`, `cat_title`, `translit_title`, `parent_id` FROM `categories`";
         $result = $this->conn->query($sql);
         $result = $result->fetchAll(PDO::FETCH_ASSOC);
         return $result;
     }

     function getleftMenu($categories, $parent = 0){
         if(!isset($print)){$print='';}
         foreach($categories as $category){
             if($category['parent_id'] ==$parent ){

                 $print.='<li class="menu-item parent-'.$category['parent_id'].'"><span  data-id="'. $category['category_id'] .'">'.$category['cat_title'].'</span>' ;
                 foreach($categories as $sub_cat){
                     if($sub_cat['parent_id']==$category['category_id']){
                         $flag = TRUE; break;
                     }
                 }

                 if(isset($flag)){
                     $print.= "<ul class='invisible'>";
                     $print.= $this->getleftMenu($categories, $category['category_id']);
                     $print.= "</ul>";
                     $print.= "</li>";
                 } else{
                     $print.="</li>";
                 }
             }
         }
         return $print;
     }

     function getCarousel(){
         $sql = "SELECT `id`, `image`, `url` FROM `carousel`";
         $result = $this->conn->query($sql);
         $result = $result->fetchAll(PDO::FETCH_ASSOC);
         return $result;
     }

	
  }
  
