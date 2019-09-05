<?php include_once HEAD;?>
<body>
       
    <?php include_once FIGURE; ?>

    <?php include_once ROOT.'/application/views/petrova/header_rezume.inc'; ?>
        
    <div class="container__main">
    <?=$content; ?>
    
        <? if(DEBUG):?>
            <div class="listing side-content">  
                <?php 
                echo '<pre>';
                    print_r($this);
                echo '</pre>'; 
                ?>
            </div>
        <? endif; ?>
              

    </div><!--закрытие container__main-->    
           
    <?php include_once ROOT.'/application/views/petrova/footer_rezume.inc'; ?>
</body>
</html>