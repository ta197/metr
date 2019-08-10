<div class= "header__breadcrumb side-content top-content">
    <a href="/">главная</a>  |  signup
</div>

<?php include_once TITLE_H1; ?>   


<div class="side-content adjustment">
    

    <form method="POST" action = "/user/signup" class="base-form">
        
        <label for="login">Логин</label>
        <input id="login" name="login" type= "text" placeholder="от 3 до 15 знаков">
        
        <label for="password">Пароль</label>
        <input id="password" name="password" type= "password" placeholder="от 6 до 15 знаков">

        <label for="name">Имя</label>
        <input id="name" name="name" type= "text" placeholder="от 6 до 15 знаков">

        <label for="email">E-mail</label>
        <input id="email" name="email" type= "text" placeholder="от 3 до 15 знаков">
        
        <div class ="link-buttons">
            <button type="submit" class="button-dark">Зарегистрироваться</button>
        </div>
    </form>
    
</div>

