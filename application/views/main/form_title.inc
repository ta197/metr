<?php 
if(!isset($_SESSION['error']) && !isset($_SESSION['success'])){
    echo '<h4>Для авторизации заполните форму</h4>';
}
if(isset($_SESSION['error']) && !isset($_SESSION['success'])){
    if(is_array($_SESSION['error'])){
        echo '<ul>';
            foreach ($_SESSION['error'] as $error){
                foreach ($error as $item){
                    echo '<li><h4 class ="red">'.$item .'</h4></li>';
                }
            }
        echo '</ul>';
    }else{
       throw new \Exception("error не массив", 500);
    }
    
    unset($_SESSION['error']);    
}
if(!isset($_SESSION['error']) && isset($_SESSION['success'])){
    echo '<h4>'.$_SESSION['success'].'</h4>';
    unset($_SESSION['success']);
}