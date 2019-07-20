<?php
include_once HEAD;
?>
<body>
    <?php include_once FIGURE; ?>
    <?php include_once NAV_ICON; ?>
        
        <div class="container__main">
            <div class= "header__breadcrumb top-content side-content">
                <a href="/">главная</a>  |  все категории
            </div>
            
            <?php include_once TITLE_H1; ?>  
            <?php include_once CAT_MENU; ?>
            
            <?php 
                // echo '<pre>';
                // print_r($this);
                // echo '</pre>';
            ?>       
           
        </div><!--закрытие container__main-->    
    
    <?php include_once FOOTER; ?>
    
</body>
</html>