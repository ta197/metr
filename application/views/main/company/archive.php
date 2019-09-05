<div class= "header__breadcrumb side-content top-content">
    <a href="/">главная</a>  |  <a href="/company">организации</a>  |  архивные организации
</div>

<?php include_once TITLE_H1; ?> 
<?php include_once ALPHABET_LETTERS; ?>
<div class="listing side-content lowered_16">
    <section id = "pagination" >
        <?php include '../application/views/navbar.php'; ?>
    </section>
    <?php include_once LIST_COMPANIES;?>
    <?php include '../application/views/navbar.php'; ?>
</div>
   
<ul class="link-buttons side-content">
    <li class="link-buttons__item"><a href="/company/young" class="button-dark">новые организации</a></li>
    <li class="link-buttons__item"><a href="/company" class="button-dark">все организации</a></li>
</ul>
