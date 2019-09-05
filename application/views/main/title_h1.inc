<?php
$indent = '';
$counted = !empty($counted) ? $counted : '';
if(!isset($this->page) || !is_object($this->page)){
    throw new \Exception("Нет данных для страницы", 500);
} 
    

if(substr($this->page->header_title, 0, 2) === "«") $indent = ' header_quote-indent';
    echo '<header class="side-content">';
        echo '<h1 class="header__title'.$indent.'" lang="ru-Ru">';
        echo $this->page->header_title;
            
            if(!empty($this->page->subh1))
                echo '<div class = "header__substr-title">'.$this->page->subh1;
            if(!empty($counter))
                echo '<span class = "counter">('.$counted . $counter.')</span>';
            if(!empty($this->page->subh1)) echo '</div>';

            
    echo '</h1>'."\n";

    if(!empty($name->archive)){
        echo '<h3 class ="red">Организация закрылась в '.$name->archive.' году</h3>';
    }
    
    echo '</header>';

   
