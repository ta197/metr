<?php 
$title = $c->company.' | каталог';
$h1 = 'Каталог организации '.$c->company_name;
$subh1 =' (адрес: '.$c->address.')';
$counter['counter'] = count($listGoods);  
include_once HEAD;
?>

<body>
    <?php include_once FIGURE; ?>

    <?php include_once NAV_ICON; ?>
        
    <div class="container__main">
        <div class= "header__breadcrumb side-content top-content">
            <a href="/">главная</a>  
            |  <a href="/company">организации</a>   
            |  <a href="/company/card/c/<?= $c->company_id; ?>"><?= $c->company_name; ?></a>
            |  <a href="/catalog/company/c/<?= $c->company_id; ?>">каталог</a>
            |  <?= $c->address; ?>
        </div>
        
    <?php include_once TITLE_H1; ?>
        
    <?php //include_once LIST_GOODS; 
    ?>
        
    <?php //include_once 
    //EMPTY_RESPONSE; 
    ?>

    <?php
        include_once (!$listGoods)
            ? EMPTY_RESPONSE
            : LIST_GOODS;
    ?>

    <div class="side-content lowered_30 bottom_30"><a href="/catalog/company/c/<?=$c->company_id ?>"><button>+ другие адреса компании</button></a></div>
    
        <div class="listing side-content"> 
        <?php
            // echo '<pre>';
            // print_r($this);
            // echo '</pre>';
        ?>             
        </div>

        <div class="footer__under"></div>
    </div><!--container__main-->
    <div class="footer__under-min720"></div>    
            
    <?php include_once FOOTER; ?>

</body>
</html>