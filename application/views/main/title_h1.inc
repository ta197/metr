<?php
$indent = '';
$counted = !empty($counted) ? $counted : '';

if(substr($page->header_title, 0, 2) === "«") $indent = ' header_quote-indent';
    echo '<header class="side-content">';
       // echo  $page->header_title; die;
            
           if( !$page->header_title && $page->err){
               echo '<h1 class="header__title red" lang="ru-Ru">';
                if(DEBUG == 1){
                    //throw new \Exception($page->err, 404);
                    echo $page->err;
                }else{
                    echo 'Ой! Ошибка на странице :(';
                }
            }else{
                echo '<h1 class="header__title'.$indent.'" lang="ru-Ru">';
                echo $page->header_title;
            }

            if(!empty($page->subh1))
                echo '<div class = "header__substr-title">'.$page->subh1;
            if(!empty($counter))
                echo '<span class = "counter">('.$counted . $counter.')</span>';
            if(!empty($page->subh1)) echo '</div>';

            
    echo '</h1>'."\n";

    if(!empty($name->archive)){
        echo '<h3 class ="red">Организация закрылась в '.$name->archive.' году</h3>';
    }
    
    echo '</header>';

   
