<?php
session_start();
$users = require_once 'admin_users.inc';
//$users = require_once ADMIN_USERS_FILE;
?>
            <div class= "header__breadcrumb side-content top-content">
                <a href="/">На сайт</a>  | <a href="/admin"> админ-панель</a> | список пользователей
            </div>
            
            <?php include_once TITLE_H1; ?>   
               
                       
            <div class="listing side-content">
<?php
               
           if(!empty($_SESSION['user']))
            echo 'Вы '.$_SESSION['user']['name'];


            if(empty($_SESSION['user']) || empty($_SESSION['user']['is_admin'])){
                echo '<div>У вас недостаточно прав для просмотра</div>';
                //die;
            }
            else{
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

}
            // var_dump($_SESSION['user']);    
                // echo '<pre>';
                // print_r($this);
                // echo '</pre>';
?> 

                <div class="link-buttons"><a href="/admin/users/logout" class="button-dark">Выход</a></div>         
            </div>