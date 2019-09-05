<footer>
    <div class="footer__content">
        <div class="side-content">
           
            <ul class="footer__column">
                <li class="footer__column-item"><a  href="/">на сайт</a></li><br/>
            </ul>

            <?php if(!empty($sessAdminId)):
                if($this->route['action'] == 'profile'){
                    $activ = ' footer__nav-item_activ  footer__nav-item_disabled';
                }else{
                    $activ = '';
                }?>
                <ul class="footer__column">
                    <li class="footer__column-item"><a  href="/admin/user/profile/id/<?= $sessAdminId ?>" class="footer__nav-item<?= $activ ?>">личный кабинет</a></li><br/>
                    <li class="footer__column-item"><a  href="/admin/user/logout">выход</a></li>
                </ul>
            <?php endif;?>

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