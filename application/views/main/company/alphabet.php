<div class= "header__breadcrumb side-content top-content">
    <a href="/">главная</a> 
    <? if(!empty($navLetters->letter)){
            echo '| <a href="/company">организации</a>  | на букву '. $navLetters->letter;
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
  
<ul class="link-buttons side-content">
    <li class="link-buttons__item"><a href="/company/young" class="button-dark">новые организации</a></li>
    <li class="link-buttons__item"><a href="/company/archive" class="button-dark">архивные организации</a></li>
</ul>