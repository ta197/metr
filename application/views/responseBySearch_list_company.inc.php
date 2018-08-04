<div class="side-content">
<?php
foreach($items as $item):
    echo '<dl class="listing__company_search">'."\n\t";
    
    echo '<div>'."\n";
    for($i=1; $i<=$item[0]; $i++){
        $points = str_repeat ('.', $i);
        echo "\t".'<span class="points">'.$points."</span>\n";
    }

    echo "\t".'</div>'."\n";    
    $indent = '';
    if(substr($item['name'], 0, 7) === "&laquo;") 
        $indent = ' listing__company-name_quote-indent';
    echo "\t".'<dt class="listing__company-name'.$indent.'">'."$item[name]  | ";
    echo '<span class="listing__link"><a href="/company/card/c/'.$item['company_id'].'">подробнее</a>'.'</dt>'."\n";
    echo "\t".'<dd>';
    
    $places = explode("~~", $item['addresses']);
    
    $addr = '';
    $arr = [];
    $str = '';
    foreach ($places as $place):
        if($addr === ''):
            $addr = (new \application\models\Helper())::wordsFromString($place, 0, 2);
            $arr[1]= $place;
        
        else:
            if(strpos($place, $addr) === false){
                $str.= '<span class="">';
                $str.= end($arr)."</span> | ";
                $addr = (new \application\models\Helper())::wordsFromString($place, 0, 2);
                if(!in_array($addr, $arr, true)) 
                    $arr[] = $place;
                    else $arr[] = '^';
            }
            else{
                if(!in_array($addr, $arr, true))
                    $arr[] = $addr;
            }
        endif;
    endforeach;
    
    $str.= '<span>'.end($arr)."</span>";
    $str = str_replace(" | <span>^</span>", "", $str);
                 
    echo $str;
  
    echo '</span></dd>'."\n</dl>\n";
endforeach;
?>
</div>