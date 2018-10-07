<?php
if(!empty($goods)){
    $h1 = $goods->goods;
    $title = $c->company.' | '.$goods->goods;
    $subh1 = ' в организации '.$c->company_name;
    //$counter['counter'] =count($goods);
}
else{
    $h1 = 'Каталог &laquo;'.$catObj->ucfirst_utf8($catObj->name).'&raquo;';
    $title = $c->company.' | '.$catObj->name;
    $subh1 = ' организации '.$c->company_name;
    $counter['counter'] =count($listGoods);
}
include_once HEAD;
?>

<body>
       
    <?php include_once FIGURE; ?>

    <?php include_once NAV_ICON; ?>
        
    <div class="container__main">
        <div class= "header__breadcrumb side-content top-content">
            <a href="/">главная</a>  |  <a href="/company">организации</a>  
            |  <a href="/company/card/c/<?= $c->company_id; ?>"><?= $c->company_name; ?></a> 
            |  <a href="/catalog/company/c/<?= $c->company_id; ?>">каталог</a> 
            <?php  
                $str = '/catalog/catcompany/c/'.$c->company_id.'/cat/';
                    include_once BRC;
                if(!empty($goods)){
                   echo ' |  <a href="/catalog/catcompany/c/'.$c->company_id.'/cat/'.$catObj->cat_id.'">'.$catObj->name.'</a>';
                   echo ' | '.$goods->goods;
                }
                else{
                    echo ' | '.$catObj->name;
                }
            ?>
        </div>
        
        <?php include_once TITLE_H1; ?>
                
        <?php 
        if(!empty($goods)):?>
            <img class = "goods__photo_card side-content" src="/img/goods/99-7031_1.jpg">
            <div class="listing side-content">
                <dl class="listing__company">
                    
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
            if(!empty($listGoods)){
                echo '<h2 class = "subtitle side-content">
                Ещё товары этой компании в категории <q>'.$catObj->ucfirst_utf8($catObj->name).'</q>
                <span class = "counter">('.count($listGoods).')</span>
                </h2>';
            }
        endif;
        ?>
        
        <?php if(!empty($listGoods)) include_once LIST_GOODS; ?>
        
        <div>
        <?php 
        // echo '<pre>';
        // print_r($this);
        // echo '</pre>';
        ?>             
        </div>
        
        <ul class = "side-content category-minimenu">
            <li><a href="/catalog/company/c/<?= $c->company_id; ?>">Каталог организации</a></li>
            <li><a href="/category/section/cat/<?= $catObj->cat_id; ?>">Категория <q><?= $catObj->ucfirst_utf8($catObj->name); ?></q></a></li>
        </ul>

    </div><!--закрытие container__main-->
            
    <?php include_once FOOTER; ?>
 
</body>
</html>