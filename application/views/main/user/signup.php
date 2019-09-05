<div class= "header__breadcrumb side-content top-content">
    <a href="/">главная</a>  |  регистрация
</div>

<?php include_once TITLE_H1; ?>   

<div class="side-content adjustment">

<?php include_once FORM_TITLE ;?> 

    <form method="POST" action = "/user/signup" class="base-form  lowered_30">
        
        <label for="login">Login</label>
        <input id="login" name="login" type= "text" placeholder="можно как имя или email" value ="<?=isset($_SESSION['form-data']['login']) ? engine\libs\H::h($_SESSION['form-data']['login']) : ''; ?>">
        
        <label for="password">Password</label>
        <input id="password" name="password" type= "password" placeholder="не менее 6 символов">

        <label for="name">Name</label>
        <input id="name" name="name" type= "text" placeholder="Иванова Ирина" value ="<?=isset($_SESSION['form-data']['name']) ? engine\libs\H::h($_SESSION['form-data']['name']) : ''; ?>">

        <label for="email">E-mail</label>
        <input id="email" name="email" type= "text" placeholder="example@mail.ru" value ="<?=isset($_SESSION['form-data']['email']) ? engine\libs\H::h($_SESSION['form-data']['email']) : ''; ?>">
        
        <div class ="link-buttons">
            <button type="submit" class="button-dark">Зарегистрироваться</button>
        </div>
    </form>
    <?php
    if(isset($_SESSION['form-data'])) unset($_SESSION['form-data']);
    ?>
</div>

