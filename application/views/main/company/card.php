<div class= "header__breadcrumb side-content top-content">
    <a href="/">главная</a>  |  <a href="/company">организации</a>   |  <?= $name->company_name; ?>
</div>

<?php include_once TITLE_H1; ?>
<?php
if(!empty($c->about)){
    echo '<p class="side-content lowered_15">'.$c->about.'</p>';
    echo '<div class="listing side-content">'; 
}else{
    echo '<div class="listing side-content lowered_16">'; 
}
   
foreach ($p as $item):
    echo '<dl class="listing__company">'."\n\t";
    echo '<dt class="listing__company-name">'."{$item->addresses}</dt>\n";
    if(!empty($item->phones)){
        $phones = ltrim($item->phones, " | ");
        echo "\t\t".'<dd class="listing__company-address">'."$phones</dd>\n";
    }
       
    if(!empty($item->work_mode))
        echo "\t\t".'<dd class="listing__company-address">режим работы: '."$item->work_mode</dd>\n";
    if(!empty($item->email))
        echo "\t\t".'<dd class="listing__company-address">e-mail: '."$item->email</dd>\n";
    if(!empty($item->goods)){
        if($countPlaces>1){
            echo "\t\t".'<dd>
                            <ul class="link-buttons">
                                <li class="link-buttons__item">
                                    <a href="/catalog/place/p/'.$item->place_id.'" class="button-dark">Каталог
                                    </a>
                                </li>
                            </ul>
                        </dd>'."\n";
        }else{
            echo "\t\t".'<dd>
                            <ul class="link-buttons">
                                <li class="link-buttons__item">
                                    <a href="/catalog/company/name/'.$name->company_id.'" class="button-dark">Каталог
                                    </a>
                                </li>    
                            </ul>
                        </dd>'."\n";
        }
    }
        
    if(!empty($item->categories)){
        $cats = explode("~~", $item->categories);
        echo "\t\t".'<dd class="listing__link">относится к категориям:<div class="separator_rout"></div>';
        foreach ($cats as $key=>$cat):
            $dataLink = explode(" | ", $cat);
            if($key !== 0) echo " | ";
            echo '<a href="/category/section/cat/'."$dataLink[1]".'">'."$dataLink[0]".'</a>';
        endforeach;  
        echo '</dd>'."\n";
    }
    if(!empty($item->coords)){
        
       echo '<div id="map" class="lowered_30 8 map" data-lat="'.$item->coords.'" 
       style="width: 600px; height: 400px"
       </div>';
    }
    
    echo "</dl>\n";
endforeach; 

?>             
</div>
     

  <div class="listing side-content">
    <?php 
        // echo '<pre>';
        // print_r($this);
        // echo '</pre>';
    ?>       
    </div>
