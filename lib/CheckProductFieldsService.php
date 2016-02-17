<?php

trait Lib_CheckProductFieldsService {

    public function checkIfNotEmpty()
    {
        $data= $this->getUpdatedProduct();
        $error=[];
        if(empty($data['title'])) $error['title']= "Пустой заголовок";
        if(empty($data['author'])) $error['author']= "Пустое поле автора";
        if(empty($data['description'])) $error['description']= "Нет описания";
        if(empty($data['body'])) $error['body']= "Пустое поле отрывка";
        if(empty($data['price'])) $error['price']= "Нет цены";

        return $error;
    }



    public function getUpdatedProduct()
    {
        $updated['title'] = htmlspecialchars($_POST['title']);
        $updated['author'] = htmlspecialchars($_POST['author']);
        $updated['description'] = $this->stripTags($_POST['description']);
        $updated['body'] =$this->stripTags($_POST['body']);
        $updated['price'] = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

        return $updated;
    }

    private function stripTags($income)
    {
        $content = $this->close_tags($income);

        $content = strip_tags($content,'<a><b><blockquote><br><button><cite><code><div><dd><dl><dt><em><fieldset>
        <font><h1><h2><h3><h4><h5><hr><i><it><img><label><li><ol><p><pre><span><strong><table><tbody><tr>
        <td><th><u><ul>');
        return $content;

    }

    private  function close_tags($content)
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