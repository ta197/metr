<div class="header__breadcrumb top-content side-content">
    <a href="/petrova">резюме Петровой Т.В.</a> | <a href="/petrova/education">образование</a>
    | <a href="/petrova/education/#<?= $this->certObj->category_code ?>"><?= $this->certObj->category_name ?></a>
    | <?php echo $this->certObj->type . ' ' . $this::quote($this->certObj->name) ?>
</div>
<?php
include_once TITLE_H1; ?>
<div class="side-content bottom_60">
    <img class="
        <?php
	    switch ($this->certObj->orientation) {
		case 'vertical':
			echo "max_700";
			break;
		case 'horizontal':
			echo "max_1000";
			break;
		default:
			echo "max_800";
			break;
	    }
	    ?>"
     src="/public/img/petrova/<?=$this->certObj->category_code ?>/<?=$this->certObj->img ?>" alt="<?=$this->certObj->type ?>">
</div>

<ul class="link-buttons side-content lowered_15">
    <li class="link-buttons__item link-buttons__item_bottom-15">
        <a href="/petrova/education#<?= $this->certObj->category_code ?>" class="button-dark">вернуться
            в <?= $this->certObj->category_name ?></a>
    </li>
</ul>

