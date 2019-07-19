<?php 
header("Location: err404", true, 404);
$title = '404';
$h1 = 'Ошибка 404';

include_once HEAD; ?>
<body>
  
    <?php include_once FIGURE; ?>
    <?php include_once HEADER_REZUME; ?>
        
    <div class="container__main">
        <div class= "header__breadcrumb top-content side-content">
            Такой страницы не существует!
        </div>              
                
        <?php include_once TITLE_H1; ?> 

         <h4 class ="side-content red bottom_15">Попробуйте перейти на главную страницу</h4>
    
         <ul class = "link-buttons side-content lowered_15">
				<li class = "link-buttons__item link-buttons__item_bottom-15">
                	<a href="/petrova" class="button-dark">на главную</a>
           		</li>  
			</ul>

            <div class="side-content">
                <?php 
                // echo '<pre>';
                // print_r($this);
                // echo '</pre>';
                ?>             
            </div>
    
    </div><!--закрытие container__main-->
    
    <?php include_once FOOTER_REZUME; ?>
</body>
</html>