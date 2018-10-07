<?php
session_start();
if(empty($_SESSION['user'])){
    header('Location: /admin/login');
}

$title = 'админ-панель';
$h1 = 'Админ-панель';
//setcookie("name", "John", time()-3600);
include_once HEAD; ?>
<body>
       
    <?php include_once FIGURE; ?>

        <div class="container__main">
            <div class= "header__breadcrumb side-content top-content">
                <a href="/">главная</a>  |  админ-панель
            </div>
            
            <?php include_once TITLE_H1; ?>   
            <?php //if(!empty($_COOKIE['role'])) echo $_COOKIE['role'];
            ?>
                    
            <div class="listing side-content">
            <?php
               
            echo 'Welcom, '.$_SESSION['user']['name'];
            //var_dump($_SESSION['user']);    
                // echo '<pre>';
                // print_r($this);
                // echo '</pre>';
                ?>
                <li><a href="/admin/userlist">Список пользователей</a></li>
                <li><a href="/admin/logout">Выход</a>   </li>
                        
            </div>
        
        </div><!--закрытие container__main-->
        
        <?php include_once FOOTER; ?>
   
</body>
</html>