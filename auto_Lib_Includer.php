<?php

$dir = PATH_SITE.'/lib/';
$ext = 'php';
    $opened_dir = opendir($dir);

    while ($element=readdir($opened_dir)){
        $fext=substr($element,strlen($ext)*-1);
        if(($element!='.') && ($element!='..') && ($fext==$ext)){
            include_once($dir.$element);
        }
    }
    closedir($opened_dir);
