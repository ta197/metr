<?php 
$title = 'поиск';
$h1 = 'Поиск по сайту';
$counter ='';
$subh1 ='';

include_once HEAD; ?>
<body>
  
    <?php include_once FIGURE; ?>
    <?php include_once NAV_ICON; ?>
        
    <div class="container__main">
        <div class= "header__breadcrumb top-content side-content">
            <a href="/">главная</a>  |  поиск
        </div>              
                
        <?php include_once TITLE_H1; ?>   
    
        <div class="side-content">

            <form action="/search/response/search/" method="get" class="base-form search-form">
                <input type="search" name="search" placeholder="Введите название организации (адрес) или категорию...">
                <button type="submit"></button>
                <label for="" class="search-form__note">Например, <span class ="listing__link italic">обои база ленина 13</span></label>
            </form>
  
        </div>
    
    </div><!--закрытие container__main-->
    
    <?php include_once FOOTER; ?>
</body>
</html>