<div class= "header__breadcrumb side-content top-content">
    <a href="/">на сайт</a>  | авторизация
</div>
<?php include_once TITLE_H1; ?> 

<div class="side-content adjustment">

<?php include_once FORM_TITLE ;?>  

    <form method="POST" action="/admin/user/login" class="base-form">
        
        <label for="login">Логин</label>
        <input id="login" type= "text" name="login" placeholder="от 3 до 15 знаков">
        
        <label for="password">Пароль</label>
        <input id="password" type= "password" name="password" placeholder="от 6 до 15 знаков">
        
        <div class ="link-buttons">
            <button type="submit" class="button-dark">Вход</button>
        </div>
    </form>
    
</div>

