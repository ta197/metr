<div class="listing side-content">

<table>
    <tr>
<?php
if($this->route['prefix'] == '/admin/') 
    echo "\t\t<th>Роль</th>\n";

echo <<<HEREDOC
        
        <th>Имя</th>
        <th>Соообщения</th>
    </tr>
HEREDOC;

foreach ($users as $user):

if($this->route['prefix'] == '/admin/'){
        if($this->route['action'] == 'admins' && $user['role'] == 'admin'){
    echo "\n\t<tr>";
echo <<<HEREDOC
    <td>{$user['role']}</td>
        
        <td>{$user['name']} </td>
        <td>{$user['email']} </td>
    </tr>
HEREDOC;
        }
        elseif($this->route['action'] == 'users' && $user['role'] == 'user'){
        echo "\n\t<tr>";
echo <<<HEREDOC
<td>{$user['role']}</td>
       
        <td>{$user['name']} </td>
        <td>{$user['email']} </td>
    </tr>
HEREDOC;
        }elseif($this->route['controller'] == 'user' && $this->route['action'] == 'index_user'){
        echo "\n\t<tr>";
echo <<<HEREDOC
    <td>{$user['role']}</td>
           
            <td>{$user['name']} </td>
            <td>{$user['email']} </td>
        </tr>
HEREDOC;
        }
    }elseif($this->route['prefix'] == '/'){
        if($user['role'] != 'admin'){
            echo "\n<tr>";
echo <<<HEREDOC
         
            <td>{$user['name']} </td>
            <td><a href ="/message/write/user/{$user['id']}">написать</a</td>
        </tr>
HEREDOC;
       }
    }

       endforeach;

     
?> 
</table>
</div>