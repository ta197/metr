<?php include_once HEAD; ?>

<body>
            
    <?php include_once FIGURE; ?>
        
    <div class="logo">
            <div class="logo__icon logo__icon_logo">главная</div>
        </div>  
        
        <div class="container__main">
        <?=$content; ?>

            <? if(DEBUG):?>
            <div class="listing side-content">  
                <?php
                echo '<pre>';
                    //print_r($this);
                echo '</pre>'; 
                ?>
            </div>
            <? endif; ?>
              
         
        </div><!--закрытие container__main-->
     
    <?php include_once FOOTER; ?> 

<!-- <script  src="js/typing_carousel.js"></script> -->
</body>
</html>      