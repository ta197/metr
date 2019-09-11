<?php

    if(!empty($navLetters->list) and empty($countListLetters)){
        $countListLetters = count($navLetters->list);
        $gap = '';
    }
    else{
        $gap = '&nbsp;&nbsp;&nbsp;';
    }
  
    if(!empty($navLetters) and $countListLetters >= MIN_ANCOR) {
       
        echo $gap;
      
            foreach($navLetters->list as $v){
              
                if($navLetters->letter == $v){
                    $active = ' nav__letter_active nav__letter_disabled';
                }else{
                    $active = ''; 
                }
                
                if(empty($navLetters->ancor)){
                    echo '<a href="'. $this->route['prefix'] .$navLetters->base_url.'/'.$navLetters->type_letter.'/'.$v.'" class ="nav__letter'.$active.'">'.$v.'</a>';
                }else{
                   echo '<a href="#letter'.$v.'" class ="nav__letter">'.$v.'</a>';  
                }
            }
      
    }             
            