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

        <div class = "listing  side-content">
        
            <dl class="listing__company">
            <img class = "goods__photo_card" src="/img/goods/99-7031_1.jpg"> 
                <dt class="listing__company-name">
                    <?php 
                    if(!empty($cardGoods->short_description))
                        echo $cardGoods->short_description;
                    ?>
                </dt>
                    <dd class="listing__company-address">
                        <?php   
                        if(!empty($cardGoods->long_description))
                        echo $cardGoods->long_description;
                        ?>
                    </dd>
                    <dd class="listing__company-address">
                        <?php   
                        if(!empty($cardGoods->price))
                        echo 'Средняя цена: '.round((int)$cardGoods->price, 2).' руб.';
                        ?>
                    </dd>
            </dl>
            <?php
             if(!empty($listCompany)):
                echo '<h2 class ="subtitle bottom_60 subtitle__margin-30">Где можно приобрести<span class = "counter">('.count($listCompany).')</span></h2>';   
                $indent = '';
                
                foreach($listCompany as $place){
                    if(substr($place['company_name'], 0, 7) === "&laquo;") $indent = ' listing__company-name_quote-indent';
                    echo '<dl class="listing__company">';
                    echo '<dt class="listing__company-name'.$indent.'"><a href="/company/card/name/'."$place[company_id]".'">'."$place[company_name]".'</a></dt>';
                    echo  '<dd class="listing__company-address">'."$place[addresses]".'<dd>';
                    if(!empty($place['price'])) 
                        echo  '<dd class="listing__company-address">Цена (на '."$place[date]".'):  '."$place[price]".' рублей '."$place[unit]".'<dd>';
                    echo '</dl>';
                }
            endif;
            ?>
        </div>
        
        
        <?php 
    //     echo '<pre>';
    //    print_r($this);
    //    echo '</pre>';
        ?>             
       
       
    </div><!--закрытие container__main-->
            
    <?php include_once FOOTER; ?>
</body>
</html>