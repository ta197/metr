<?php
    if(!empty($listLetters) and empty($countListLetters)){
        $countListLetters = count($listLetters);
        $gap = '';
    }
    else{
         $gap = '&nbsp;&nbsp;&nbsp;';
    }
    if(!empty($listLetters) and $countListLetters >= MIN_ANCOR) {
        echo '<div id ="letters" class="listing side-content">';
        echo $gap;
            foreach($listLetters as $v){
                echo '<a href="#letter'.$v.'" class ="alphabet__letter">'.$v.'</a>';
            }
        echo '</div>';
    }
?>             
            