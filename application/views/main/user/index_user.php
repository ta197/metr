<div class= "header__breadcrumb side-content top-content">
    <a href="/">На главную</a>  |  для пользователей
</div>

<?php include_once TITLE_H1; ?> 

<?php include_once '../application/views/main/list_users.inc'; ?> 

<div class="listing side-content">
    <div class="link-buttons"><a href="/user/profile/id/<?=$sessUserId?>" class="button-dark">Личный кабинет</a></div> 
</div>

<?php   echo '<pre>';
               // print_r($this);
        echo '</pre>';