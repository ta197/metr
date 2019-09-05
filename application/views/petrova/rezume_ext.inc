<?php if(!empty ($nav['rezume_ext'])):?>
    <?php $disabled = ''; ?>

    <ul class="footer__column">

        <?php foreach($nav['rezume_ext'] as $k=>$item): ?>
            <?php if($item['id_page'] === $this->page->id_page){
                $disabled = ' footer__nav-item_activ  footer__nav-item_disabled'; 
            }else{
                $disabled = '';
            } ?>

            <li class="footer__column-item"><a href="<?= $item['link'] ?>" class="footer__nav-item<?= $disabled; ?>"><?= $item['name'] ?></a></li><br/>

        <? endforeach;?>

    </ul>      
   
<? endif;?>
   