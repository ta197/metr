<div class= "header__breadcrumb side-content top-content">
    <a href="/">главная</a>  |  <a href="/company">организации</a>  
    |  <a href="/company/card/name/<?= $name->company_id; ?>"><?= $name->company_name; ?></a> 
    |  <a href="/catalog/company/name/<?= $name->company_id; ?>">каталог</a> 
    <?php  
        $componentLinkBRC = '/catalog/catcompany/name/'.$name->company_id.'/cat/';
            include_once BRC;
       
           echo ' |  <a href="/catalog/catcompany/name/'.$name->company_id.'/cat/'.$catObj->cat_id.'">'.$catObj->name.'</a> | '.$goods->goods;
    ?>
</div>

<?php include_once TITLE_H1; ?>
        
    <div class="listing side-content">
    
        <dl class="listing__company">
        <img class = "goods__photo_card" src="/img/goods/99-7031_1.jpg">
           <dt class="listing__company-name">
            <?php if(!empty($goods->short_description)) echo $goods->short_description; ?>
            </dt>
            
            <dd class="listing__company-address">
                <?php if(!empty($goods->long_description)) echo $goods->long_description; ?>
            </dd>
            
            <dd class="listing__company-address">
                <?php if(!empty($goods->price)) echo 'Цена: '.$goods->price.' рублей '.$goods->unit ; ?>
            </dd>
            
            <?php
            if(!empty($goods->addresses)):
            $address = explode("~~", $goods->addresses);
                foreach ($address as $substr):
                    $substr = ltrim($substr, " | ");
                    echo '<dd class="listing__company-address">'.$substr.'<dd>';
                endforeach;
            endif;
            ?>
            
        </dl>
    </div>


<?php 
if(!empty($listGoods)):
    echo '<h2 class ="subtitle side-content listing bottom_60 subtitle__margin-30">Другие товары категории '. $this->quote_ucfirst($catObj->name) ." в каталоге организации $name->company_name".'<span class = "counter">('.count($listGoods).')</span></h2>';     
include_once LIST_GOODS;
endif; 
?>

<div>
            
</div>

<ul class = "side-content link-buttons">
    <li class="link-buttons__item"><a href="/catalog/company/name/<?= $name->company_id; ?>" class="button-dark">Каталог организации</a></li>
    <li class="link-buttons__item"><a href="/category/section/cat/<?= $catObj->cat_id; ?>" class="button-dark">Категория <q><?= $this->ucfirst_utf8($catObj->name); ?></q></a></li>
</ul> 
