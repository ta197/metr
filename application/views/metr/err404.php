<?php 
header("Location: err404", true, 404);
$title = '404';
$h1 = 'Ошибка 404';

include_once HEAD; ?>
<body>
  
    <?php include_once FIGURE; ?>
    <?php include_once NAV_ICON; ?>
        
    <div class="container__main">
        <div class= "header__breadcrumb top-content side-content">
            Такой страницы не существует!
        </div>              
                
        <?php include_once TITLE_H1; ?> 

         <h4 class ="side-content red bottom_45">Попробуйте ввести запрос в поиск или воспользуйтесь меню</h4>
    
        <div class="side-content">
        
            <form action="/search/response/search/" method="get" class="base-form search-form">
                <input type="search" name="search" placeholder="Введите название организации (адрес) или категорию...">
                <button type="submit"></button>
                <label for="" class="search-form__note">Например, <span class ="listing__link italic">обои база ленина 13</span></label>
            </form>
            
        </div>

            <div class="side-content">
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