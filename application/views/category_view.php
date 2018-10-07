<?php 
$title = $h1 = $cat->name;
//$counter['counted'] ='организаций: ';
$counter['counter'] = count($countCompany);
include_once HEAD; 
?>
<body>     
    <?php include_once FIGURE; ?>
    <?php include_once NAV_ICON; ?>
        
    <div class="container__main">
        <div class= "header__breadcrumb top-content side-content">
            <a href="/">главная</a> | <a href = "/category">категории</a>  
            <?php include_once BRC; echo " | " . $title; ?>
        </div>
        <?php include_once TITLE_H1; ?>

        <?php 
        if($catMenu){
            include_once CAT_MENU;
        }
        ?>
        
        <?php
        if(!empty($cat->countGoods)) {
                echo '<div class = "side-content category-minimenu">
                <a href = "/catalog/category/cat/'.$cat->cat_id.'" class="button-dark">
                Каталог <q>'.$cat->ucfirst_utf8($cat->name).'</q> 
                <span class = "counter">('.$cat->countGoods.')</span></a></div>';
            }
        ?>

        <?php
        if(!empty($countCompany)){
            if(!empty($catMenu) or !empty($cat->countGoods)){
                echo '<div class="listing side-content">';
                include_once LIST_COMPANIES;
            }else{
                echo '<div class="listing side-content lowered_16">';
                include_once LIST_COMPANIES;
            }
            echo '</div>';
        }
        else{
            include_once EMPTY_RESPONSE;
        }
            // include_once (!$countCompany)
            //     ? EMPTY_RESPONSE
            //     : LIST_COMPANIES;
        ?>
            

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