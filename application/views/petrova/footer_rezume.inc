<footer>
    <div class="footer__content">
        <div class="side-content">
            <?php include_once ROOT.'/application/views/petrova/rezume_jobs.inc'; ?>          
            <?php include_once ROOT.'/application/views/petrova/rezume_ext.inc'; ?> 
            <ul class="footer__column">
                
                <?php 
                    $d = '';
                    if($this->page->id_page == 55 OR $this->page->id_page == 48)  {
	                    $d = ' footer__nav-item_activ  footer__nav-item_disabled';
                    }
                ?>
                <li class="footer__column-item"><a  href="/petrova" class="footer__nav-item<?= $d ?>">главная</a></li><br/>
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