<div class= "header__breadcrumb side-content top-content">
    <a href="/">главная</a>  |  центры
</div>

<?php include_once TITLE_H1; ?>

<div class="listing side-content">   
    <?php foreach ($centres as $centre): ?>
        <dl class="listing__company">
            <dt class="listing__company-name"><?= $centre['name_center']; ?></dt>
                <dd class="listing__company-address"><?= $centre['address']; ?></dd>
                <dd class="listing__link"><a href="<?= $this->route['prefix']; ?>centre/card/id/<?= $centre['id']; ?>">подробнее</a>
                <?php
                    if($centre['site']){
                        echo '<div class="gap">|</div><a href="http://www.'."{$centre['site']}".'" target ="_blank">сайт</a>';
                    }
                ?>
        </dl>
    <?php endforeach; ?>             
</div>

