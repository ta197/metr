<?php
$indent = '';
if(substr($h1, 0, 7) === "&laquo;") $indent = ' header_quote-indent';
    echo '<header class="side-content">';
        echo '<h1 class="header__title'.$indent.'" lang="ru-Ru">';
        echo $h1."\n";
            
            if($subh1)
                echo '<div class = "header__substr-title">'.$subh1;
            if(!empty($counter['counter']))
                echo '<span class = "counter"> ('.$counter['counted'] . $counter['counter'].')</span>';
            if($subh1) echo '</div>';

            
    echo '</h1>'."\n";

    if(!empty($c->archive)){
        echo '<h3 class ="red">Организация закрылась в '.$c->archive.' году</h3>';
    }
    
    echo '</header>';

    
