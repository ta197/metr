<?php
$title = 'О проекте';
$h1 = 'О проекте';
include_once HEAD;
?>
<body>
       
    <?php include_once FIGURE; ?>

    <?php include_once NAV_ICON; ?>
        
    <div class="container__main">
        <div class= "header__breadcrumb side-content top-content">
            <a href="/">главная</a>  |   о проекте
        </div>
        
        <?php include_once TITLE_H1; ?>
        
        <h2 class="side-content subtitle subtitle__margin-30">
            От печатной версии к электронной
        </h2>
        <p class="side-content">За 10 лет работы над справочником «Квадратный метр» редакция накопила достаточно большой объем сведений об арзамасских организациях и торговых предприятиях в сфере ремонта, строительства, отделки. К сожалению, иногда форма печатной версии накладывает свои ограничения, и поэтому возникла идея еще одной формы подачи информации - этот сайт.</p>
        <h2 class="side-content subtitle">
           Новые возможности
        </h2>
        <p class="side-content">Теперь наши дорогие читатели могут не просто найти список организаций по разделам, но и наоборот, найти организацию (не только по названию, но и, например, по адресу) и посмотреть в каких разделах она представлена, а у некоторых компаний даже есть каталог товаров. Надеемся, пользователи оценят бОльшую оперативность в обновлении информации, лучшую детализацию и удобство пользования справочником. Ждем ваших отзывов, пожеланий и замечаний.</p>
        <ul class = "side-content link-buttons link-buttons_margin-30">
           <li class = "link-buttons__item link-buttons__item_bottom-15 link-buttons__item_top-15"><a href="/about/contacts" class="button-dark">как с нами связаться</a></li>
        </ul>
        <h2 class="side-content subtitle">
           О нас в цифрах
        </h2>
        <p class="side-content">300 организаций <br>250 категорий<br>700 товаров и услуг<br>100 рекламодателей<br></p>
        
        
        <ul class = "side-content link-buttons link-buttons_margin-30">
            <li class = "link-buttons__item  link-buttons__item_top-15"><a href="/about/partners" class="button-dark">рекламодателям</a></li>
        </ul> 

    </div><!--закрытие container__main-->

        <?php 
            // echo '<pre>';
            // print_r($this);
            // echo '</pre>';
        ?>       
           
            
    <?php include_once FOOTER; ?>

</body>
</html>