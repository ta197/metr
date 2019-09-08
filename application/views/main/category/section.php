
        <div class= "header__breadcrumb top-content side-content">
            <a href="/">главная</a> | <a href = "/category">категории</a>  
            <?php 
            include_once BRC; echo " | " . $this->page->header_title; 
            ?>
        </div>
        <?php include_once TITLE_H1; ?>

        <?php 
        if($countCatSubMenu>0){
            include_once CAT_MENU;
        }
        ?>
        
        <?php
        if(!empty($cat->countGoods)) {
                echo '<div class = "side-content link-buttons">
                <a href = "/catalog/category/cat/'.$cat->cat_id.'" class="button-dark">
                Каталог '.$this->quote_ucfirst($cat->name) 
                .'<span class = "counter">('.$cat->countGoods.')</span></a></div>';
            }
        ?>

        <?php
        if(!empty($counter)){
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
            include_once ROOT.'/application/views/main/empty_response.inc';
        }
        ?>
            

        
    <?php 
        // echo '<pre>';
        // print_r($this);
        // echo '</pre>';
    ?>       
       
 