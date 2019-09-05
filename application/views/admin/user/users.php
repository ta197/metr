<div class= "header__breadcrumb side-content top-content">
    <a href="/">На сайт</a>  | <a href="/admin"> админ-панель</a> | список пользователей
</div>
            
<?php include_once TITLE_H1; ?>   
               
<div class="listing side-content">
<?php
     if(!empty($sessAdminId)){
        echo '<div>Вы '.$_SESSION['user']['name'].'</div>';
     }else{
        echo '<div>У вас недостаточно прав для просмотра</div>';
     }
?>
</div>

<?php 
include_once '../application/views/main/list_users.inc'; 
?> 
   
<div class="listing side-content">
    <div class="link-buttons"><a href="/admin/user" class="button-dark">Пользователи и админы</a></div>
    <div class="link-buttons"><a href="/admin/user/admins" class="button-dark">Админы</a></div>        
</div>

<?php

// var_dump($_SESSION['user']);    
    echo '<pre>';
    //print_r($this);
    echo '</pre>';
?> 
