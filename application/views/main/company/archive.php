<div class= "header__breadcrumb side-content top-content">
    <a href="/">главная</a>  |  <a href="/company">организации</a>  
    <? if(!empty($navLetters->letter)){
            echo '| <a href="/company/archive">архивные организации</a>  | на букву '. $navLetters->letter;
        }else{
            echo '| архивные организации';
        }
    ?>
</div>

<?php include_once TITLE_H1; ?> 

<div id ="letters" class="listing side-content">            
    <?php include_once NAV_LETTERS; ?>
</div>

<div class="listing side-content lowered_16">

    <?php include_once LIST_COMPANIES;?>
    <?php include ROOT.'/application/views/navbar.php'; ?>
</div>
   
<ul class="link-buttons side-content">
    <li class="link-buttons__item"><a href="/company/young" class="button-dark">новые организации</a></li>
    <li class="link-buttons__item"><a href="/company" class="button-dark">все организации</a></li>
</ul>
