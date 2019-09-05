<div class= "header__breadcrumb side-content top-content">
    <a href="/">На главную</a>  |  <a href="/user">для участников</a>  | личный кабинет
</div>

<?php include_once TITLE_H1; ?>   
           
<div class="listing side-content">

    <table>
        <tr>
            <td>role</td>
            <td><?=$user->role?></td>
        </tr>
       
        <tr>
            <td>id</td>
            <td><?=$user->id?></td>
        </tr>
        <tr>
            <td>Логин</td>
            <td><?php echo $user->login ?? 'не указан'; ?></td>
        </tr>
        <tr>
            <td>имя</td>
            <td><?php echo $user->name ?? 'не указан'; ?></td>
        </tr>
        <tr>
            <td>email</td>
            <td><?php echo $user->email ?? 'не указан'; ?></td>
        </tr>
</table>
 
<div class="link-buttons"><a href="/admin/user" class="button-dark">Для участников</a></div> 
 

</div>