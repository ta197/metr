<?php 
$title = $catObj->name.' | каталог';
$counter['counter'] = count($listGoods);
$h1 = 'Каталог категории &laquo;'.$catObj->ucfirst_utf8($catObj->name).'&raquo;';
$componentLinkBRC = '/category/section/cat/'; 
include_once HEAD;
?>
<body>
       
    <?php include_once FIGURE; ?>

    <?php include_once NAV_ICON; ?>
        
    <div class="container__main">
        <div class= "header__breadcrumb side-content top-content">
            <a href="/">главная</a>  |  <a href="/category">категории</a> 
            <?php include_once BRC; ?> 
            |  <a href="/category/section/cat/<?= $catObj->cat_id; ?>"><?= $catObj->name; ?></a> 
            |  каталог 
            <!--категории <q><?= $catObj->name; ?></q>-->
        </div>
        
        <?php include_once TITLE_H1; ?>
        
        <?php //include_once LIST_GOODS; 
        ?>

        <?php
        include_once (!$listGoods)
            ? EMPTY_RESPONSE
            : LIST_GOODS;
        ?>
        
        <?php
            //echo '<pre>';
            //print_r($this);
            //echo '</pre>';
        ?>             

        <ul class = "side-content link-buttons">
            <li class="link-buttons__item"><a href="/category/section/cat/<?= $catObj->cat_id; ?>" class="button-dark">Категория &laquo;<?= $catObj->ucfirst_utf8($catObj->name) ?>&raquo;</a></li>
        </ul>
       
    </div><!--закрытие container__main-->
            
    <?php include_once FOOTER; ?>
  
</body>
</html>