<?php
//$count = count($listCompany);
$title = $h1 = $cardGoods->name;
$componentLinkBRC = '/category/section/cat/';
include_once HEAD;
?>
<body>
       
    <?php include_once FIGURE; ?>

    <?php include_once NAV_ICON; ?>
        
    <div class="container__main">
        <div class= "header__breadcrumb side-content top-content">
            <a href="/">главная</a>  |  <a href="/category">категории</a> 
            <?php  include_once BRC; ?> 
            |  <a href="/category/section/cat/<?= $cardGoods->cat_id; ?>"><?= $cardGoods->category; ?></a>
            |  <a href="/catalog/category/cat/<?= $cardGoods->cat_id; ?>">каталог</a>  
            |  <?= $cardGoods->name; ?>
        
        </div>
        
        <?php include_once TITLE_H1; ?>

        <img class = "goods__photo_card side-content" src="/img/goods/99-7031_1.jpg">
        <div class = "listing  side-content">
        <?php 
        if(!empty($cardGoods->short_description) OR !empty($cardGoods->long_description) OR !empty($cardGoods->price)):
            echo '<dl class="listing__company">';
            echo '<dt class="listing__company-name">';
            
            if(!empty($cardGoods->short_description))
                echo $cardGoods->short_description;
            echo '</dt>';
            echo '<dd class="listing__company-address">';
           
            if(!empty($cardGoods->long_description))
                echo $cardGoods->long_description;
            echo '</dd>';
            echo '<dd class="listing__company-address">';
            
            if(!empty($cardGoods->price))
                echo 'Средняя цена: '.round((int)$cardGoods->price, 2).' руб.';
            echo '</dd>';
            echo '</dl>';
        endif;
        ?>
            <?php
             if(!empty($listCompany)):
                echo '<h2 class ="subtitle bottom_60 lowered_15">Где можно приобрести <span class = "counter">('.count($listCompany).')</span></h2>';   
                $indent = '';
                
                foreach($listCompany as $place){
                    if(substr($place['company_name'], 0, 7) === "&laquo;") $indent = ' listing__company-name_quote-indent';
                    echo '<dl class="listing__company">';
                    echo '<dt class="listing__company-name'.$indent.'"><a href="/company/card/c/'."$place[company_id]".'">'."$place[company_name]".'</a></dt>';
                    echo  '<dd class="listing__company-address">'."$place[addresses]".'<dd>';
                    if(!empty($place['price'])) 
                        echo  '<dd class="listing__company-address">Цена (на '."$place[date]".'):  '."$place[price]".' рублей '."$place[unit]".'<dd>';
                    echo '</dl>';
                }
            endif;
            ?>
        </div>
        
        <div class="listing side-content">
        <?php 
    //     echo '<pre>';
    //    print_r($this);
    //    echo '</pre>';
        ?>             
        </div>

        <div class = "side-content category-minimenu">
            <a href="/catalog">весь каталог сайта</a>
        </div>
       
    </div><!--закрытие container__main-->
            
    <?php include_once FOOTER; ?>
</body>
</html>