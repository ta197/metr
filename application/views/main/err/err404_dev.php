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
<h4 class ="side-content red bottom_45">Попробуйте вернуться назад  или воспользуйтесь поиском</h4>
    
<div class="side-content">
    <form action="/search/answer/search/" method="get" class="base-form search-form">
        <input type="search" name="search" placeholder="Введите название организации (адрес) или категорию...">
        <button type="submit"></button>
        <label for="" class="search-form__note">Например, <span class ="listing__link italic">обои база ленина 13</span></label>
    </form>
</div>

<h4 class ="side-content red bottom_15">Можете перейти на главную страницу</h4>

<ul class = "link-buttons side-content lowered_15">
	<li class = "link-buttons__item link-buttons__item_bottom-15">
        <a href="/" class="button-dark">на главную</a>
    </li>  
</ul>

<div class="side-content">
    <pre>
    <?php
    //print_r($_SESSION['user']);
    print_r($this)
    ?>
    </pre>
</div>