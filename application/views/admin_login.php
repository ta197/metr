<?php
session_start();
$users = require_once 'users.php';
if(!empty($_SESSION['user'])){
    header('Location: /admin');
}
$errors = [];
//if($_SERVER["REQUEST_METHOD"] == "POST"){}
if (!empty($_POST['login']) && !empty($_POST['password'])):
    foreach($users as $user):
        if($user['login']==$_POST['login'] && $user['password']== $_POST['password']){
            $_SESSION['user']= $user;
            header('Location: /admin');
            die;
        }
    endforeach;
    $errors[] = 'Неверный логин или пароль!';
else:
    $errors[] = 'Для авторизации введите логин и пароль';   
endif;
//header('Location: /admin/login');
              //exit;

$title = 'авторизация';
$h1 = 'Авторизация';

include_once HEAD; 

?>
<body>
       
    <?php include_once FIGURE; ?>

    
        
        <div class="container__main">
            <div class= "header__breadcrumb side-content top-content">
                <a href="/">главная</a>  |  страница авторизации и аутентификации
            </div>
            
            <?php include_once TITLE_H1; ?>   
            
            

            <div class="adjustment">

                <ul>
                <?php foreach ($errors as $error): ?>
                    <li><h4><?= $error ?><h4></li>
                <?php endforeach; ?>
                </ul>
            
                <form method="POST" class="base-form">
                    
                    <label for="login">Логин</label>
                    <input id="login" name="login" placeholder="от 3 до 15 знаков">
                    
                    <label for="password">Пароль</label>
                    <input id="password" name="password" placeholder="от 6 до 15 знаков">
                    
                    <div>
                        <button type="submit" class="button-dark">Вход</button>
                    </div>

                </form>
                
            </div>

            <div class="listing side-content">
                <?php //var_dump($_SESSION['user']);    
                // echo '<pre>';
                // print_r($this);
                // echo '</pre>';
                ?>             
            </div>
      
        </div><!--закрытие container__main-->
            
        <?php include_once FOOTER; ?>
   
</body>
</html>