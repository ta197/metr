<?php
$title = 'Контакты';
$h1 = 'Контакты';
include_once HEAD;
?>
<body>
       
    <?php include_once FIGURE; ?>

    <?php include_once NAV_ICON; ?>
        
    <div class="container__main">
        <div class= "header__breadcrumb side-content top-content">
            <a href="/">главная</a>  |   <a href="/about">о проекте</a>  |  Контакты
        </div>
        
        <?php include_once TITLE_H1; ?>
        
        <p class="side-content lowered_15">
            Реферат-резюме содержит только основные положения данной темы.</p> 
        
        <div class="listing side-content">
        
        <?php 
   
        // foreach ($p as $item):
        //     echo '<dl class="listing__company">'."\n\t";
        //     echo '<dt class="listing__company-name">'."{$item->addresses}</dt>\n";
        //     if(!empty($item->phones)){
        //         $phones = ltrim($item->phones, " | ");
        //         echo "\t\t".'<dd class="listing__company-address">'."$phones</dd>\n";
        //     }
               
        //     if(!empty($item->work_mode))
        //         echo "\t\t".'<dd class="listing__company-address">режим работы: '."$item->work_mode</dd>\n";
        //     if(!empty($item->email))
        //         echo "\t\t".'<dd class="listing__company-address">e-mail: '."$item->email</dd>\n";
        //     if(!empty($item->categories)){
        //         $cats = explode("~~", $item->categories);
        //         echo "\t\t".'<dd class="listing__link">относится к категориям:<div class="separator_rout"></div>';
        //         foreach ($cats as $key=>$cat):
        //             $dataLink = explode(" | ", $cat);
        //             if($key !== 0) echo " | ";
        //             echo '<a href="/category/section/cat/'."$dataLink[1]".'">'."$dataLink[0]".'</a>';
        //         endforeach;  
        //         echo '</dd>'."\n";
        //     }
        //     echo "</dl>\n";
        // endforeach;    
         
    ?>             
</div>
          
    
        <div class = "side-content category-minimenu">
            <a href="/about/partners">рекламодателям</a></li>
        </div>


          
          <div class="listing side-content">
            <?php 
                // echo '<pre>';
                // print_r($this);
                // echo '</pre>';
            ?>       
            </div>

        
    </div><!--закрытие container__main-->
   
            
    <?php include_once FOOTER; ?>
</body>
</html>