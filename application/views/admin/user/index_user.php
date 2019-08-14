<div class= "header__breadcrumb side-content top-content">
    <a href="/">На сайт</a>  | <a href="/admin"> админ-панель</a> | список пользователей
</div>

<?php include_once TITLE_H1; ?>   
           
<div class="listing side-content">

<?php
echo <<<HEREDOC
    <table>
        <tr>
            <th>Имя</th>
            <th>Логин</th>
        </tr>
HEREDOC;
        foreach ($users as $user): 
echo <<<HEREDOC
        <tr>
            <td>{$user['name']} </td>
            <td>{$user['login']} </td>
        </tr>
HEREDOC;
        endforeach; 
echo   '</table>';
?> 
<div class="link-buttons"><a href="/admin/user/logout" class="button-dark">Выход</a></div> 
<div class="link-buttons"><a href="/admin/user/admins" class="button-dark">Список админов</a></div>        

</div>