<div class= "header__breadcrumb side-content top-content">
    <a href="/">главная</a>  |  <a href="/company">организации</a>  | новые организации
</div>

<?php include_once TITLE_H1; ?>

<?php
if(!empty($listLetters)){
    array_shift($listLetters);  //чтобы ссылки на года начинались с предпоследнего, т.к. последний - в первом подзаголовке
    $countListLetters = MIN_ANCOR; //чтобы список имел подзаголовки - год создания независимо от количества
}
?>

<?php include_once ALPHABET_LETTERS; ?>
<div class="listing side-content lowered_16">
<?php include_once LIST_COMPANIES; ?>
</div>
<ul class="link-buttons side-content">
    <li class="link-buttons__item"><a href="/company/archive" class="button-dark">архивные организации</a></li>
    <li class="link-buttons__item"><a href="/company" class="button-dark">все организации</a></li>
</ul>
