<div class= "header__breadcrumb side-content top-content">
    <a href="/petrova">резюме Петровой Т.В.</a> |   <a href="/petrova/develop">создание сайтов</a> | сайт metrkv
</div>
  
<header class="side-content">
    <h1 class="header__title" lang="ru-Ru">
    <a href="/" target ="blank">Сайт с рабочим названием metrkv</a>
    </h1>   
</header>

<?php include ROOT.'/application/views/petrova/menu_example.inc'; ?>
<div class="side-content">	
    <section id="idea" class="section__hr">
      <h3>Основная идея сайта</h3>
      <h4>Целевая аудитория сайта - те, кто строит дом или обустраивает его, делает ремонт в квартире в Арзамасе.</h4>
      <p class="lowered_60">Задача была обеспечить возможность поиска информации по сайту тремя способами:</p>	
        <ol>
	        <li>по названию работы или категории товара -<br/>для тех, кому нужна услуга или товар, и надо найти все организации, их предоставляющие;</li>
	        <li>по названию организации (или по виду организации) с возможностью использования фильтра, без перезагрузки страницы -<br/>для тех, кто ищет конкретную организацию;</li>
	        <li>по введенному запросу в поле поиска (по нескольким словам одновременно) -<br/>для тех, кто ищет по отрывочным данным, например по названию улицы, номеру телефона, одному слову в названии и т.д.</li>
        </ol>
        <p lowered_15">Исходя из задачи на сайте 3 раздела: <a href="/petrova/develop/example/metr#cat" class="blue">категории</a>, <a href="/petrova/develop/example/metr#filter" class="blue">компании</a>, <a href="/petrova/develop/example/metr#search" class="blue">поиск</a>.</p>
        <ul class = "link-buttons">
            <li class = "link-buttons__item link-buttons__item_bottom-15 ">
              <a href="/"  target ="_blank" class="button-dark">на сайт</a>
	        </li> 
        </ul>
    </section>
      
    <section id="cat" class="section__hr">
        <h3>Раздел "Категории" (Nested Sets)</h3>	
		<p>Поскольку сфера ремонта и отделки предполагает довольно обширный перечень категорий и подкатегорий с разным уровнем их вложенности, я применила для этого меню <span class="notice">Nested Sets</span>, чтобы упростить вывод из базы данных. </p>
	    <p>И отвела для меню отдельную страницу целиком для удобства чтения.</p>
            <ul class = "link-buttons">
                <li class = "link-buttons__item link-buttons__item_bottom-15">
                    <a href="/category" target ="_blank" class="button-dark">"Категории" на сайте</a>
                </li>
            </ul>
    </section>
      
    <section id="filter" class="section__hr">
        <h3>Раздел "Компании" (AJAX)</h3>	
            <p>В этом разделе нужен был <span class="notice">фильтр,</span> который помогал бы выбрать организацию по сфере деятельности (торговля, например), по форме собственности или применить оба критерия.</p>
            <p>Для применения фильтра без перезагрузки страницы воспользовалась AJAXом. Тут без JS было не обойтись, но вообще я старалась использовать его по минимуму. И даже здесь предусмотрела вариант работы фильтра в случае (хотя и маловероятном) отсутствия JS.</p>
            <ul class = "link-buttons">
                <li class = "link-buttons__item link-buttons__item_bottom-15">
                    <a href="/company" target ="_blank" class="button-dark">"Компании" на сайте</a>
                </li>
            </ul>
    </section>
    <section id="search" class="section__hr">
        <h3>Раздел "Поиск" (PHP)</h3>	
            <p>Сайт написан на PHP. И на нем же написан обработчик поиска. </p>
            <p>Целью было написать такой скрипт, который бы не только находил данные по вхождению слова, но и выводил их в зависимости от того, к какому разделу сайта оносится искомое: компания ли это, товар ли, категория ли, а может быть, и то, и то. Кроме того, наиболее вероятный ответ должен быть верхним в списке.</p>
            <p>Кстати, обработка данных для фильтра раздела "Компании" тоже написана на PHP.</p>
            <blockquote>Я не брала готовый код, а писала сама, потому что считаю, что так эффективнее делать, пока учишься. А JS-код, наоборот, чаще брала готовый (кроме кода фильтра).</blockquote>
            <ul class = "link-buttons">
                <li class = "link-buttons__item link-buttons__item_bottom-15">
                    <a href="/search" target ="_blank" class="button-dark">"Поиск" на сайте</a>
                </li>
            </ul>
    </section>
      
    <section id="mvc" class="section__hr">
        <h3>Архитектура (MVC)</h3>	
            <p>Логика, представление и работа с данными у меня разделены. Я попыталась придерживаться модели <span class="notice">MVC.</span> Это определило структуру каталогов в корне сайта (m, v, c): модели, представления и контроллеры соответственно. </p>
            <p>Применяла и другие шаблоны, например, <span class="notice">Singleton.</span> Он используется и во фронт-контроллере, и в классе, работающем с БД.</p>
    </section>
    <section id="sql" class="section__hr">
        <h3>База данных (MySQL)</h3>	
        <p>При проектировании БД основной принцип был такой: данные не должны дублироваться, а в зависимости от запроса БД должна сама компоновать данные перед тем, как их выдать. Достигается это с помощью использования <span class="notice">функций</span> и <span class="notice">представлений</span>, написанных на SQL, хранящихся в базе и выполняемых соответственно на стороне сервера базы данных.</p>
        <h5 class="lowered_30">Пример кода определения функции (places_to_string)</h5>
        <pre><code>BEGIN
SET @city = `p.city`, 
    @street = `p.street`, 
    @house = `p.house`, 
    @centres_address =`centres.address`, 
    @name_center = `centres.name_center`, 
    @detail = `p.detail`, 
    @unit_floor = `p.unit_floor`, 
    @unit_not = `p.unit_not`;
RETURN
CONCAT_WS(', ', 
    COALESCE(@centres_address, 
        CONCAT_WS(', ', @city, @street, @house)), 
            @name_center, @detail, 
            CONCAT(@unit_floor, ' этаж'), @unit_not);
END</code></pre>
    <h5 class="lowered_15">Пример запроса</h5>
            <pre><code>public function getCompaniesByCategory($id){    
  return self::$db->queryEach(
    "SELECT
    p.place_id,
    c.company, LEFT(c.company, 1) AS letter, c.company_id, c.site, 
    company_to_string(c.name_type, c.shop, legal.name, c.name_legal, c.quotes, c.company) AS company_name, 
    GROUP_CONCAT(DISTINCT CONCAT_WS('', places_to_string(p.city, p.street, p.house, centres.address, centres.name_center, p.detail, p.unit_floorp.unit_not),
               	phones_to_string(p.tel, p.addtel, p.cell, p.add_cell))
                SEPARATOR '~~') 
                AS addresses
    FROM `places` AS p
    LEFT JOIN `places_cats` ON (places_cats.place_id = p.place_id)
    JOIN `companies` AS c ON (p.company_id =  c.company_id)
    LEFT JOIN `centres` ON (p.centre = centres.id)
    LEFT JOIN `legal` ON (legal.id = c.legal)
    WHERE c.archive IS NULL AND places_cats.cat_id = ?
    GROUP BY c.company_id
    ORDER BY c.company",
    [$id]);
  }</code></pre>
            <p>Конечно, такой подход, на первый взгляд, усложняет код некоторых запросов, но зато помогает гибко манипулировать данными.</p>
        </section>

        <section id="bem" class="section__hr">
        <h3>Наименование стилей</h3>	
            <p>При написании CSS я старалась по возможности придерживаться <span class="notice">методологии БЭМ</span> в части наименований.</p>
            <h5 class="lowered_15">Пример описания стилей (блок footer)</h5>
            <pre><code>footer{
    position: absolute;
    width: 100%;
    line-height: 30px;
    padding-top: 30px;
    border-top: 1px solid #2e5a75;
    font-size: 14px;
    max-width: 2000px;
    min-height: 126px;
    bottom: 0;
}

.footer__content{
    margin-left: 320px;  
}

.footer__nav-item{
    display: block;  
}

.footer__nav-item_activ{
    color: #86a6b9;
    font-weight: 200;
}

.footer__nav-item_disabled:hover{
    cursor: default;
    text-decoration: none;
}

.footer__column{
    display: inline-block;
    vertical-align: top;
    padding-right: 8%;
    margin: 0;
}

.footer__column-item{
    display: inline-block;
    white-space: nowrap;
}</code></pre>
    </section>
        
    <section id="adaptiv" class="section__hr">
    <h3>Адаптивность и кроссбраузерность</h3>
        <p>Для кроссбраузерности старалась использовать свойства, поддерживаемые всеми браузерами (и давно). В крайнем случае только - префиксные свойства.</p>
        <p>За счёт использования <span class="notice">медиа-запросов</span> сайт по-разному отображается на экранах различных размеров.</p>
    </section>
</div>
<img src="/public/img/adapt3.jpg" alt="вид на разных устройствах" class ="right-img"/>
	
<div class="side-content">	  
    <section id="design" class="section__hr">
        <h3>Дизайн</h3>
            <p>Дизайн-макета как такового не существует, потому что верстала сразу на HTML и CSS. По началу накидала небольшой прототип в Axure, но в процессе разработки, как говорится, концепция поменялась, от переделки прототипа решила отказаться: мне было проще сразу переписать код.</p>
            <p>Сложную многозадачность сайта надо было визуально облегчить. Отсюда основными целями в дизайне видела  <span class="notice">простоту, логичность, лаконичность,</span> чтобы создать атмосферу деловитости, серьезности и в то же время современности и ненавязчивости по форме. Думаю продолжить работать над дизайном в этом ключе.</p>
            <p id= "icon-shrift"><span class="notice">Иконки</span> (для визуального акцента на главном меню) нужны были тоже максимально минималистичные. Нарисовала их сама в Adobe Illustrator, сохранив как <span class="notice">SVG-файлы.</span> А затем с помощью Fontello создала из них <span class="notice">шрифт.</span> Весят теперь значки меньше, чем если бы были картинками, хорошо масштабируются за счет своей не растровой, а векторной природы.</p>
            
        <div class="rout lowered_60 bottom_30">
            <a  href="/"  target ="_blank" class="rout__icon logo__icon_logo">главная</a>
            <a  href="/category" target ="_blank" class="rout__icon rout__icon_routing">категории</a>
            <a  href="/company"  target ="_blank"class="rout__icon rout__icon_lists">компании</a>
            <a  href="/search"  target ="_blank"class="rout__icon rout__icon_search">поиск</a>
        </div>

        <p id= "icon-shrift"><span class="notice">Типографика</span> должна была быть приближена к печатной (например, кавычки, вынесенные за полосу набора). Это напоминает о том, что сайт - электронный вариант <span class="notice">печатного издания.</span> На эту же мысль работают широкие поля (даже верхнее), отказ от привычного горизонтального меню в шапке, цвет основного фона не белый, а немного приглушенный до естественного цвета бумаги.</p>

        <blockquote>Такая "незадизайненность" сайта не говорит о том, что я не могу пользоваться графическими редакторами. О моих навыках и опыте дизайнера-верстальщика (правда, в полиграфии)
            <a href="/petrova/design" class="notice"> здесь.</a>
        </blockquote>
    </section>

    <section id="git" class="section__hr">
        <h3>GIT</h3>
            <p>Хотя сайт и пишу одна, но гитом всё же пользуюсь. Во-первых, чтобы разобраться как это работает, а во-вторых, чтобы хранить на гитхабе и иметь возможность показать код.</p>
            <ul class = "link-buttons">
                <li class = "link-buttons__item link-buttons__item_bottom-15">
                    <a href="https://github.com/ta197/metr"  target ="blank" class="button-dark">github</a>
                </li>
            </ul>
    </section>
       
    <section class="section__hr">
        <ul class = "link-buttons">
            <li class = "link-buttons__item link-buttons__item_bottom-15">
                <a href="/petrova/develop" class="button-dark">вернуться к резюме</a>
            </li>
        </ul>
    </section>
        
</div> 
    
<?php include ROOT.'/application/views/petrova/menu_example.inc';?>