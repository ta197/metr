<div class= "header__breadcrumb side-content top-content">
    <a href="/">главная</a>  |  <a href="/company">организации</a>  
    |  <a href="/company/card/name/<?= $name->company_id; ?>"><?= $name->company_name; ?></a> 
    |  <a href="/catalog/company/name/<?= $name->company_id; ?>">каталог</a> 
    <?php  
        $componentLinkBRC = '/catalog/company-category/name/'.$name->company_id.'/cat/';
        include_once BRC;
        echo ' | '.$catObj->name;
    ?>
</div>

<?php include_once TITLE_H1; ?>
        
<?php if(!empty($listGoods)) include_once LIST_GOODS; ?>

<ul class = "side-content link-buttons">
    <li class="link-buttons__item"><a href="/catalog/company/name/<?= $name->company_id; ?>" class="button-dark">Каталог организации</a></li>
    <li class="link-buttons__item"><a href="/category/section/cat/<?= $catObj->cat_id; ?>" class="button-dark">Категория <q><?= $this->ucfirst_utf8($catObj->name); ?></q></a></li>
</ul>
