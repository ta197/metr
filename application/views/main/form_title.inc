<?php 
if(!isset($_SESSION['error']) && !isset($_SESSION['success'])){
    echo '<h4 class="lowered_0">Для авторизации заполните форму</h4>';
}
if(isset($_SESSION['error']) && !isset($_SESSION['success'])){
    if(is_array($_SESSION['error'])){
        echo '<ul>';
            foreach ($_SESSION['error'] as $error){
                foreach ($error as $item){
                    echo '<li><h4 class ="red lowered_0">'.$item .'</h4></li>';
                }
            }
        echo '</ul>';
    }else{
       throw new \Exception("error не массив", 500);
    }
    
    unset($_SESSION['error']);    
}
if(!isset($_SESSION['error']) && isset($_SESSION['success'])){
    echo '<h4 class="lowered_0">'.$_SESSION['success'].'</h4>';
    unset($_SESSION['success']);
}
if(isset($_SESSION['error']) && isset($_SESSION['success'])){
    echo '<h4 class="lowered_0">Ошибочка '.$_SESSION['error'].'</h4>';
    unset($_SESSION['success']);
}