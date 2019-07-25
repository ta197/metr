<?php include_once HEAD;?>
<body>
    <?php include_once FIGURE; ?>
    <?php include_once NAV_ICON; ?>
        
        <div class="container__main">
                       
        <?=$content; ?>

        <div class="listing side-content">    
            <?php 
                echo '<pre>';
               //print_r($this);
                echo '</pre>';
            ?>       
        </div>

        </div><!--закрытие container__main-->    
    
    <?php include_once FOOTER; ?>
    
</body>
</html>