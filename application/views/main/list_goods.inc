<div class="listing side-content">

<?php 
   
    foreach ($listGoods as $item):
      
        echo '<dl class="listing__company long">'."\n\t";
           echo '<img class = "goods__photo" src="/img/goods/99-7031_1.jpg">';
            echo '<dt class="listing__company-name leftfield"><a href="/catalog/goods/g/'.$item->goods_id.'">'.$item->goods.'</a></dt>'."\n";

                if($item->price){
                    echo "\t\t".'<dd class="listing__company-address leftfield">';
                    
                    //echo '<span class="gap">| </span>';
                    if(!isset($this->name->company_id)) echo '~';
                    echo round((int)$item->price, 2). ' руб.';
                    if(isset($item->unit)) echo ' '."$item->unit"."</dd>\n"; 
                }
                    

            echo "\t\t".'<dd class="listing__company-address leftfield">'."$item->short_description</dd>\n";
                $address = explode("~~", $item->addresses);
           
            if(!empty($name->company_id)){
                foreach ($address as $substr):
                    $substr = ltrim($substr, " | ");
                    echo "\t\t".'<dd class="listing__link ellipsis leftfield">
                    <div class="separator_list"></div>'."$substr\n";
                echo "\t\t".'</dd>'."\n";
                endforeach;
            }else{
                foreach ($address as $substr):
                    $sub = explode("^", $substr);
                    //list($companies_name, $companies_id, $companies_addr, $companies_phones) =  explode("^", $substr);
                    echo "\t\t".'<dd class="listing__link ellipsis leftfield">
                        <a href="/catalog/catcompany/name/'.$sub[1].'/cat/'.$this->catObj->cat_id.'/g/'."$item->goods_id".'">
                        <div class="separator_list"></div>'."$sub[0]"
                        .'</a>: ';
                    if(!empty($sub[2])) echo $sub[2];
                    if(!empty($sub[3])) echo $sub[3];
                    echo "\n";
                    echo "\t\t".'</dd>'."\n";
                endforeach;
            }

            if(!empty($item->category))   
            echo "\t\t".'<dd class="listing__link leftfield"><a href="/catalog/catcompany/name/'.$name->company_id.'/cat/'."$item->cat_id".'">
            <div class="separator_rout__first"></div>'."$item->category".' в каталоге организации</a>'.'</dd>'."\n";     

            if($item->long_description)   
            echo "\t\t".'<dd class="listing__link leftfield"><a href="/catalog/goods/g/'."$item->goods_id".'">подробнее</a>'.'</dd>'."\n";

                //if($item->date) echo '<div class="gap">| </div>  Дата обновления: '."{$item->date}";
        echo "</dl>\n";
        
    endforeach;     
?>

</div>