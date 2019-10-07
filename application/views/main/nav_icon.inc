<nav>

<?php if(!empty($nav['nav_icon'])){ 
        $disabled = ''; 
        foreach($nav['nav_icon'] as $k=>$item):
                if($item['id_page'] === $page->id_page || $item['id_page']=== $page->id_parent){
                        $disabled = ' nav__icon_activ nav__icon_disabled'; 
                }else{
                        $disabled = '';
                } 
                ?>
                <a href="<?= $item['link'] ?>" class="nav__icon<?= $disabled; ?> <?= $item['icon'] ?>"><?= $item['name'] ?></a> 
        <?php endforeach;?>
<?php }elseif($page->err){
        if(DEBUG == 1){
                //throw new \Exception($page->err, 404);
                echo $page->err;
        }else{
                echo 'Ошибка на странице :(';
        }
}?> 

</nav>