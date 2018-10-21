<?php
$title = 'архивные организации';
$h1 = 'Организации, прекратившие работу';
$counter['counter'] = $countCompany;
include_once HEAD; 
?>
<body>
    <?php include_once FIGURE; ?>
    <?php include_once NAV_ICON; ?>
        
        <div class="container__main">
            <div class= "header__breadcrumb side-content top-content">
                <a href="/">главная</a>  |  <a href="/company">организации</a>  |  архивные организации
            </div>
            
            <?php include_once TITLE_H1; ?> 

            <?php include_once ALPHABET_LETTERS; ?>

            <div class="listing side-content lowered_16">
            <?php include_once LIST_COMPANIES;?>
            </div>
            
            
            <?php 
            //echo '<pre>';
            //print_r($this);
            //echo '</pre>';
            ?>             
           
               
            <ul class="link-buttons side-content">
                <li class="link-buttons__item"><a href="/company/young" class="button-dark">новые организации</a></li>
                <li class="link-buttons__item"><a href="/company" class="button-dark">все организации</a></li>
            </ul>

        </div><!--закрытие container__main-->
            
        <?php include_once FOOTER; ?>
   
</body>
</html>