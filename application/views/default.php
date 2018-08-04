<?php include_once HEAD; ?>

<body>
            
    <?php include_once FIGURE; ?>
        
        <div class="logo">
            <div class="logo__icon logo__icon_logo">главная</div>
        </div>
        
        <div class="container__main">
                
            <header class="top-content side-content">  
                <h1 class="title-big ">Где в Арзамасе <br>
                    <span
                        class="txt-rotate"
                        data-period="2000"
                        data-rotate='[ "найти отделочника?", "заказать окно?", "купить шуруповерт?", "выбрать обои?", "составить смету?" ]'>
                    </span>
                    </h1>
            </header>
            
            <div class="footer__under"></div>
            
            <h3 class="subtitle side-content bottom_60">
                    Более 200 организаций торговли и услуг для строительства, ремонта, отделки
            </h3>
            
            <div class="rout side-content">
                    <a  href="category" class="rout__icon rout__icon_routing">категории</a>
                    <a  href="company" class="rout__icon rout__icon_lists">компании</a>
                    <a  href="search" class="rout__icon rout__icon_search">поиск</a>
            </div>

            <div class="listing side-content">
            <?php 
                // echo '<pre>';
                // print_r($this);
                // echo '</pre>';
            ?>       
            </div>

    <div class="footer__under"></div>
        </div><!--закрытие container__main-->
        <div class="footer__under-min720"></div>        
            
    <?php include_once FOOTER; ?> 

<script  src="js/typing_carousel.js"></script>
</body>
</html>      