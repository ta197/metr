<div class= "header__breadcrumb side-content top-content">
    <a href="/">главная</a>  | авторизация
</div>

<?php include_once TITLE_H1; ?>

<div class="side-content adjustment">
<?php include_once FORM_TITLE ;?>  

    <form method="POST" action="/user/login" class="base-form lowered_30">
        
        <label for="login">Login</label>
        <input id="login" type= "text" name="login" placeholder="от 3 до 15 знаков">
        
        <label for="password">Password</label>
        <input id="password" type= "password" name="password" placeholder="не менее 6 символов">
        
        <div class ="link-buttons">
            <button type="submit" class="button-dark">Вход</button>
        </div>
    </form>
    
</div>
<div class="side-content">
    <h4>Для авторизации нужно быть зарегистрированным пользователем!</h4>
</div>
<ul class = "side-content link-buttons">
    <li class="link-buttons__item"><a href="/user/signup" class="button-dark">регистрация</a></li>
</ul>