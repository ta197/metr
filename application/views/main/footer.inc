<footer>
    <div class="footer__content">
        <div class="side-content">
           
        <?php include_once ROOT.'/application/views/main/aboutMenu.inc'; ?>
            <ul class="footer__column">

            <?php 
            if(!empty($sessUserId)){
                if($this->route['action'] == 'profile'){
                    $activ = ' footer__nav-item_activ  footer__nav-item_disabled';
                }else{
                    $activ = '';
                }

                if(!empty($sessAdminId)){?>
                    <li class="footer__column-item"><a href="/admin/user/profile/id/<?= $sessAdminId ?>" class="footer__nav-item<?= $activ ?>">личный кабинет</a></li><br/>
                <?php }else{?>
                    <li class="footer__column-item"><a href="/user/profile/id/<?= $sessUserId ?>" class="footer__nav-item<?= $activ ?>">личный кабинет</a></li><br/>
                <?php }?> 

            <li class="footer__column-item"><a href="/user/logout" class="footer__nav-item">выйти</a></li>
            <? }else{ ?>
            <li class="footer__column-item"><a href="/user/login" class="footer__nav-item">войти</a></li>
            <? } ?>

            </ul>

            <ul class="footer__column">
                <li class="footer__column-item"><a  href="/petrova">&copy; Петрова Т.В., 2017-2018</a></li>
            </ul>
        </div>
    </div> <!--закрытие footer__content-->
        
</footer>
        
<div id ="updown">
    <a href="#">
        <div class="updown up"> </div>
    </a>
</div>
    <!-- <script type="text/javascript" src="/js/updown.js" type="text/javascript"></script> -->