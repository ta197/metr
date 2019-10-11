<dt class="listing__company-name<?=$indent?>">
    <?= $obj; ?>
</dt> 
<dd class="listing__link">
    <a href="<?= $this->route['prefix'] ?><?= $obj::$page_link['one'] ?><?= $obj->primary_key ?>">
        подробнее
    </a>
</dd>
                