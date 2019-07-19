<?php include_once HEAD; ?>

<body>
    <?php include_once FIGURE; ?>

    <?php include_once NAV_ICON; ?>
        
    <div class="container__main">
        <div class= "header__breadcrumb side-content top-content">
            <a href="/">главная</a>  
            |  <a href="/company">организации</a>   
            |  <a href="/company/card/name/<?= $name->company_id; ?>"><?= $name->company_name; ?></a>
            |  <a href="/catalog/company/name/<?= $name->company_id; ?>">каталог</a>
            |  <?= $name->address; ?>
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

    <div class="side-content link-buttons">
        <a href="/catalog/company/name/<?=$name->company_id ?>" class="button-dark">Весь каталог организации</a>
    </div>
    
        <div class="listing side-content"> 
        <?php
            // echo '<pre>';
            // print_r($this);
            // echo '</pre>';
        ?>             
        </div>

    </div><!--container__main-->
  
    <?php include_once FOOTER; ?>

</body>
</html>