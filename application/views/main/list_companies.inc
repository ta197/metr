<?php
if(empty($listCompany)){return;}
if(!empty($listLetters) and empty($countListLetters)){
    $countListLetters = count($listLetters);
}

$ancor_label ='';
    foreach ($listCompany as $item):
        if(!empty($listLetters) and $countListLetters >= MIN_ANCOR){
            if(!empty($item['ancor']) and ($ancor_label!==$item['ancor']) && (strlen($item['ancor'])>1)){
                $ancor_label = $item['ancor'];
                echo '<h2 id="letter'.$ancor_label.'" class ="listing__letter">'.$ancor_label.'</h2>'."\n";
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
           echo "\t\t".'<dd class="listing__link"><a href="/company/card/name/'.$item['company_id'].'">подробнее</a>';
           if($item['site']) echo '<div class="gap">|</div><a href="http://www.'."{$item['site']}".'" target ="_blank">сайт</a>';
           
           //if(!empty($item['max_catid'])){
           //   echo '<div class="gap">|</div><a href="/catalog/catcompany/name/'."{$item['company_id']}".'/cat/'.$cat->cat_id.'">каталог</a>';
           //}
           
            //ссылка на каталог раздела в одной компании
            if(!empty($item['cat_catalog'])){
               echo '<div class="gap">|</div><a href="/catalog/catcompany/name/'."{$item['company_id']}".'/cat/'.$cat->cat_id.'"> '.$cat->name.' в каталоге организации</a>';
            }

           echo '</dd>'."\n";
        echo "</dl>\n";
    endforeach;