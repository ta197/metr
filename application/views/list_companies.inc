<?php
if(empty($listCompany)){return;}
$letter ='';
    foreach ($listCompany as $item):
        if(!empty($listLetters) and count($listLetters)>3){
            if(($letter!==$item['letter']) && (strlen($item['letter'])>1)){
                $letter = $item['letter'];
                echo '<h2 id="letter'.$letter.'" class ="listing__letter">'.$letter.'</h2>'."\n";
            }
        }
    
        echo '<dl class="listing__company">'."\n\t";
        $indent = '';
        if(substr($item['company_name'], 0, 2) === "«") $indent = ' listing__company-name_quote-indent';
          
               echo '<dt class="listing__company-name'.$indent.'">'."$item[company_name]</dt>\n";
           

            $places = explode("~~", $item['addresses']);
            
               foreach ($places as $place){
                  $place = ltrim($place, " | ");
                   echo "\t\t".'<dd class="listing__company-address">'."$place</dd>\n";
               }
           echo "\t\t".'<dd class="listing__link"><a href="/company/card/c/'.$item['company_id'].'">подробнее</a>';
           if($item['site']) echo '<div class="gap">|</div><a href="http://www.'."{$item['site']}".'">сайт</a>';
           if(!empty($item['max_catid'])){
               echo '<div class="gap">|</div><a href="/catalog/catcompany/c/'."{$item['company_id']}".'/cat/'.$cat->cat_id.'">каталог</a>';
           }
           echo '</dd>'."\n";
        echo "</dl>\n";
    endforeach;