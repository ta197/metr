<nav>

<?php 
//var_dump($nav['nav_icon']); die;
if(!empty($nav['nav_icon'])){ ?>
 <?php $disabled = ''; ?>
    <?php foreach($nav['nav_icon'] as $k=>$item): ?>
    <?php if($item['id_page'] === $this->page->id_page){
            $disabled = ' nav__icon_activ nav__icon_disabled'; 
    }else{
            $disabled = '';
    } ?>
       <a href="<?= $item['link'] ?>" class="nav__icon<?= $disabled; ?> <?= $item['icon'] ?>"><?= $item['name'] ?></a> 
   <?php endforeach;?>
<?php } ?> 

</nav>