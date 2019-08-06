<div class= "header__breadcrumb top-content side-content">
    Такой страницы не существует!
</div>              
<?php include_once TITLE_H1; ?>
<div class="side-content bottom_30">
<?php
    echo 
    "<p>Вид ошибки: $error</p>
    <p>Код ошибки: $errno</p>
    <p>Текст ошибки: $errstr</p> 
    <p>Файл: $errfile</p>
    <p>Строка: $errline</p>
    <p>Код ответа: $response</p>";
?> 
</div>
 <h4 class ="side-content red bottom_15">Попробуйте перейти на главную страницу</h4>
 <ul class = "link-buttons side-content lowered_15">
	<li class = "link-buttons__item link-buttons__item_bottom-15">
        <a href="/petrova" class="button-dark">на главную</a>
   	</li>  
</ul>

<div class="side-content">
    <pre>
    <?php
    print_r($this);
    ?>
    </pre>
</div>

