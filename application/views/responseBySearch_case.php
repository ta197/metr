<div class="side-content bottom_45">
    По запросу <mark><?= $query?> </mark>найдено совпадений: <mark><?=$counter['counter']?></mark><br/> 
    Затронутых разделов поиска: <mark><?php echo count($bySort)?></mark> (<?php echo implode(', ', $listSectionSearch) ?>)
</div>

<?php 
 foreach($bySort as $section => $items){
    echo '<h2 class="side-content subtitle subtitle__margin-30 bottom_45">'.$section.'<span class = "counter"> ('.count($items).')</span></h2>';
   
    switch($section):
        case 'Компании':  include_once RESPONSE_BY_SEARCH_LIST_COMPANY; break;
        case 'Категории':  include_once RESPONSE_BY_SEARCH_LIST_CATEGORY; break;
        case 'Товары, услуги':  include_once RESPONSE_BY_SEARCH_LIST_GOODS; break;
        //case 'Местонахождения':  include_once RESPONSE_BY_SEARCH_LIST_PLACE; break;
        default:  include_once EMPTY_RESPONSE; break;
        
    endswitch;
}

    