<div class= "header__breadcrumb side-content top-content">
    <a href="/">главная</a>  |  админ-панель
</div>

<?php include_once TITLE_H1; ?>   
<?php //if(!empty($_COOKIE['role'])) echo $_COOKIE['role'];
?>
        
<div class="listing side-content">
<?php
   
//echo '<h4>Welcom, '.$_SESSION['user']['name'].'</h4>';
//var_dump($_SESSION['user']);    
    // echo '<pre>';
    // print_r($this);
    // echo '</pre>';
    ?>
    <ul class="link-buttons">
        <li class="link-buttons__item"><a href="/admin/userslist" class="button-dark">Список пользователей</a></li>
        <li class="link-buttons__item"><a href="/admin/logout" class="button-dark">Выход</a></li> 
    </ul>        
</div>
