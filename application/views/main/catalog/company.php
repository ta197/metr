<div class= "header__breadcrumb side-content top-content">
    <a href="/">главная</a>  
    |  <a href="/company">организации</a>   
    |  <a href="/company/card/name/<?= $name->company_id; ?>"><?= $name->company_name; ?></a>
    |  каталог
</div>
        
<?php include_once TITLE_H1; ?>
    
<?php
    include_once (!$listGoods)
        ? EMPTY_RESPONSE
        : LIST_GOODS;
?>
