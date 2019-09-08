<div class= "header__breadcrumb side-content top-content">
    <a href="/">На сайт</a>  | <a href="/admin"> админ-панель</a> 
    <? if(!empty($navLetters->letter)){
            echo '| <a href="/admin/company">организации</a>  | на букву '. $navLetters->letter;
        }else{
            echo ' |  организации';
        }
    ?>
    
    
</div>

<?php include_once TITLE_H1; ?>   
<div class="side-content adjustment">
<?php
if(!empty($error))
    echo '<div class="listing side-content">'.$error.'</div>';
?> 
</div>

<div id ="letters" class="adjustment side-content ">            
    <?php include_once NAV_LETTERS; ?>
</div>

<div id ="listing" class="listing side-content">
    <?php include_once LIST_COMPANIES;?>
    <?php include '../application/views/navbar.php'; ?>
</div>