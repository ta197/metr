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
               
            echo '<h4>Welcom, '.$_SESSION['user']['name'].'</h4>';
            //var_dump($_SESSION['user']);    
                // echo '<pre>';
                // print_r($this);
                // echo '</pre>';
                ?>
                <ul class="add-mininav">
                    <li class="add-mininav__item add-mininav__item_block"><a href="/admin/userlist" class="button-dark">Список пользователей</a></li>
                    <li class="add-mininav__item add-mininav__item_block"><a href="/admin/logout" class="button-dark">Выход</a></li> 
                </ul>        
            </div>
        
        </div><!--закрытие container__main-->
        
        <?php include_once FOOTER; ?>
   
</body>
</html>