<?php
$title = 'Контакты';
$h1 = 'Контакты';
include_once HEAD;
?>
<body>
       
    <?php include_once FIGURE; ?>

    <?php include_once NAV_ICON; ?>
        
    <div class="container__main">
        <div class= "header__breadcrumb side-content top-content">
            <a href="/">главная</a>  |   <a href="/about">о проекте</a>  |  контакты
        </div>
        
        <?php include_once TITLE_H1; ?>

        <div class="side-content bottom_30">

            <p class="lowered_15">
                Если у вас есть предложения по улучшению сайта или замечания к его контенту или возникла необходимость связаться с нами, вы можете сделать это, заполнив форму обратной связи или написав нам по адресу: <b>m2arzamas@list.ru.</b></p>
            <p>Телефон администратора сайта <b>8-903-043-27-33</b> (Татьяна).</p>

            <div class = "link-buttons bottom_60">
                <a href="/about/partners" class="button-dark">рекламодателям</a>
            </div>    
       
            <h2 class="subtitle lowered_30 bottom_30">Форма обратной связи</h2>
            
            <form method="POST" class="base-form">

                <label for="nik">Ваше имя</label>
                <input id="nik" name="nik" placeholder="Петр Петров">

                <label for="email">Адрес вашей электронной почты</label>
                <input id="email" name="email" placeholder="email@mail.ru">

                <label for="message">Текст сообщения</label>
                <input id="message" name="message" type="text-area" placeholder="до 100 знаков">

                <div class = "link-buttons bottom_30">
                    <button type="submit" class="button-dark">Отправить</button>
                </div>

            </form>

        </div>
               
    </div><!--закрытие container__main-->
            
    <?php include_once FOOTER; ?>
</body>
</html>