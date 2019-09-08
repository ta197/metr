<?php
$indent = '';
$counted = !empty($counted) ? $counted : '';

if(substr($this->page->header_title, 0, 2) === "«") $indent = ' header_quote-indent';
    echo '<header class="side-content">';
        
            
           if( !$this->page->header_title && $this->page->err){
               echo '<h1 class="header__title red" lang="ru-Ru">';
                if(DEBUG == 1){
                    //throw new \Exception($this->page->err, 404);
                    echo $this->page->err;
                }else{
                    echo 'Ой! Ошибка на странице :(';
                }
            }else{
                echo '<h1 class="header__title'.$indent.'" lang="ru-Ru">';
                echo $this->page->header_title;
            }

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

   
