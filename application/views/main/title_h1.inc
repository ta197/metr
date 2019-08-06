<?php
$indent = '';
$counted = !empty($counted) ? $counted : '';

if(substr($h1, 0, 2) === "«") $indent = ' header_quote-indent';
    echo '<header class="side-content">';
        echo '<h1 class="header__title'.$indent.'" lang="ru-Ru">';
        echo $h1;
            
            if(!empty($subh1))
                echo '<div class = "header__substr-title">'.$subh1;
            if(!empty($counter))
                echo '<span class = "counter">('.$counted . $counter.')</span>';
            if(!empty($subh1)) echo '</div>';

            
    echo '</h1>'."\n";

    if(!empty($name->archive)){
        echo '<h3 class ="red">Организация закрылась в '.$name->archive.' году</h3>';
    }
    
    echo '</header>';

   
