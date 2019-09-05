<div class= "header__breadcrumb side-content top-content">
    <a href="/">На сайт</a>  | <a href="/admin"> админ-панель</a> | <a href="/admin/user">список пользователей</a> | список админов
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
    <div class="link-buttons"><a href="/admin/user/users" class="button-dark">Пользователи</a></div> 
</div>

<div class="listing side-content">
<?php
//echo '<pre>';
   // print_r($this);
//echo '</pre>'; 

//$this->route['prefix'] == '/'
//$user['role'] != 'admin'   
?>                
</div>           