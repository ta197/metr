<?php 
$title = 'поиск';
$h1 = 'Результат поиска';

$count = 0;
    if($bySort){
        foreach($bySort as $k => $val){
            $listSectionSearch[] = "&laquo;$k&raquo;";
            $count += count($val);  
       }
    }

$counter['counter'] = $count;
include_once HEAD; ?>
<body>

    <?php include_once FIGURE; ?>
    <?php include_once NAV_ICON; ?>
        
        <div class="container__main">
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
                }else include_once RESPONSE_BY_SEARCH_CASE;
            
            ?>
                                    
            <div class="listing side-content">
                <?php 
                echo '<pre>';
               print_r($this);
                echo '</pre>';
                ?>             
            </div>
    
        </div><!--закрытие container__main-->
        
        <?php include_once FOOTER; ?>
    
</body>
</html>