<?php include_once HEAD;?>
<body>
       
    <?php include_once FIGURE; ?>

    <?php include_once ADMIN_NAV_ICON; ?>
        
        <div class="container__main">
            <div class= "header__breadcrumb side-content top-content">
                <a href="/">главная</a>  |  организации
            </div>
            
            
            <?php include_once TITLE_H1; ?>

            <ul class="link-buttons side-content">
                <li class="link-buttons__item"><a href="/admin/createcompany" class="button-dark">добавить новую организацию</a></li>
            </ul>

            <h2 class="side-content lowered_0">Выбрать организацию для правки</h2>
            <div class="side-content adjustment">

            <form action="/search/response/search/" method="get" class="base-form search-form">
                <input type="search" name="search" placeholder="Введите название организации (адрес)">
                <button type="submit"></button>
                <label for="" class="search-form__note">Например, <span class ="listing__link italic">хозяин</span></label>
            </form>
  
        </div>

            

            <?php
            if(!empty($error))
                echo '<div class="listing side-content">'.$error.'</div>';
            ?>             

            <?php include_once ALPHABET_LETTERS; ?>
            
            <div id ="listing" class="listing side-content">
            <?php include_once LIST_COMPANIES;?>
            </div>
            
            <div>
                <?php 
                echo '<pre>';
                 print_r($this);
                echo '</pre>';
                ?>             
            </div>
               
           
        </div><!--закрытие container__main-->
            
        <?php include_once ADMIN_FOOTER; ?>
   
</body>
</html>