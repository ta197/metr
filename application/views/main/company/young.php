<div class= "header__breadcrumb side-content top-content">
    <a href="/">главная</a>  |  <a href="/company">организации</a>  
    <? if(!empty($navLetters->letter)){
            echo '| <a href="/company/young">новые организации</a>  | открывшиеся в '. $navLetters->letter .' году';
        }else{
            echo '| новые организации';
        }
    ?>
</div>

<?php include_once TITLE_H1; ?>

<?php
if(!empty($navLetters->list)){
    if($navLetters->letter == $navLetters->list[0] || (empty($navLetters->letter) && $pagination['page_num'] == 1)){
        array_shift($navLetters->list);  //чтобы ссылки на года начинались с предпоследнего, т.к. последний - в первом подзаголовке
    }
$countListLetters = MIN_ANCOR; //чтобы список имел подзаголовки - год создания независимо от количества
?>
    <div id ="letters" class="listing side-content">            
        <?php include_once NAV_LETTERS; ?>
    </div>
<?} ?>



<div id ="listing" class="listing side-content lowered_16">
    <?php include_once LIST_COMPANIES;?>
    <?php include '../application/views/navbar.php'; ?>
</div>

<ul class="link-buttons side-content">
    <li class="link-buttons__item"><a href="/company/archive" class="button-dark">архивные организации</a></li>
    <li class="link-buttons__item"><a href="/company" class="button-dark">все организации</a></li>
</ul>
