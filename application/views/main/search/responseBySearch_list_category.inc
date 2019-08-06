<div class="side-content">
<?php
foreach($items as $item):
    echo '<dl class="listing__company_search">'."\n\t";
    
    //$points = str_repeat (' ', $item[0]);
    echo '<div>'."\n";
    for($i=1; $i<=$item[0]; $i++){
        $points = str_repeat ('.', $i);
        echo "\t".'<span class="points">'.$points."</span>\n";
    }
    //echo '<div class="points">'."$points</div>\n"; 
    echo "\t".'</div>'."\n";    
    $indent = '';
    if(substr($item['name'], 0, 7) === "&laquo;") 
        $indent = ' listing__company-name_quote-indent';
    echo "\t".'<dt class="listing__company-name'.$indent.'">'."$item[name]  | ";
    echo '<span class="listing__link"><a href="/category/section/cat/'.$item['cat_id'].'">подробнее</a>'.'</dt>'."\n";
       
    echo "\n</dl>\n";
endforeach;
?>
</div>