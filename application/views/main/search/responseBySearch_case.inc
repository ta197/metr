<div class="side-content bottom_45">
    По запросу <mark><?= $query?> </mark>найдено совпадений: <mark><?=$counter['counter']?></mark><br/> 
    Затронутых разделов поиска: <mark><?php echo count($bySort)?></mark> (<?php echo implode(', ', $listSectionSearch) ?>)
</div>

<?php 
 foreach($bySort as $section => $items){
    echo '<h2 class="side-content subtitle subtitle__margin-30 bottom_45">'.$section.'<span class = "counter"> ('.count($items).')</span></h2>';
   
    switch($section):
        case 'Компании':  include_once ROOT.'/application/views/main/search/responseBySearch_list_company.inc'; break;
        case 'Категории':  include_once ROOT.'/application/views/main/search/responseBySearch_list_category.inc'; break;
        case 'Товары, услуги':  include_once ROOT.'/application/views/main/search/responseBySearch_list_goods.inc'; break;
        //case 'Местонахождения':  include_once ROOT.'/application/views/main/search/responseBySearch_list_place.inc';
        default:  include_once ROOT.'/application/views/main/search/empty_response.inc'; break;
        
    endswitch;
}

    