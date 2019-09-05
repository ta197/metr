<?php 
$count = 0;
    if($bySort){
        foreach($bySort as $k => $val){
            $listSectionSearch[] = "&laquo;$k&raquo;";
            $count += count($val);  
       }
    }

$counter = $count; ?>

            <div class= "header__breadcrumb top-content side-content">
                <a href="/">главная</a>  |  <a href="/search">поиск</a>  |  результат поиска
            </div>              
                    
            <?php include_once TITLE_H1; ?>   
    
            <div class="side-content">
            <form action="/search/response/search/" method="get" class="base-form search-form">
                <input type="text" name="search" value="<?= $clearQuery?>" placeholder="Искать здесь...">
                <button type="submit"></button>
                <!--<label for="" class="search-form__note">восстановление ванн</label>-->
            </form>
            </div>

            <?php
            if($errQuery){
                include_once ERROR;
            }else if(!$bySort or !$arrWords){
                echo '<p class="side-content notice">
                По вашему запросу '.$query.' ничего не найдено.</p>';
            }else 
                include_once ROOT.'/application/views/main/search/responseBySearch_case.inc';
            ?>
                                    