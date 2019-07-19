<?php
$title = 'резюме | опыт работы';

include_once HEAD;
?>
<body>
       
    <?php include_once FIGURE; ?>

    <?php include_once HEADER_REZUME; ?>
        
    <div class="container__main">
        <div class= "header__breadcrumb side-content top-content">
            <a href="/petrova">резюме Петровой Т.В.</a> |   опыт работы
        </div>
        
        <header class="side-content">
            <h1 class="header__title" lang="ru-Ru">
            Опыт работы
            </h1>   
        </header>
        
     <div class="side-content">
        
     <section class="section__hr">
	 <h2>Основные места работы</h2>
	<div class="table-wrapper lowered_30">
        <table>
			<thead>
				<tr>
					<th>Время работы</th>
					<th>Организация</th>
					<th>Должность</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>январь 2019 —<br/>настоящее время</td>
					<td>Газета "Арзамасские новости"</td>
					<td>Корректор</td>
				</tr>
                <tr>
					<td>Февраль 2017 —<br/>март 2017</td>
					<td>Сайт профи.ру</td>
					<td>Анкетмейстер, работа в админке</td>
				</tr>
				<tr>
					<td>Май 2006 —<br/>сентябрь 2017</td>
					<td>ИП Петрова Т.В. (своё ИП)</td>
					<td>Издатель</td>
				</tr>
                <tr>
					<td>Октябрь 2005 —<br/>май 2006</td>
					<td>ИП Георгиевский И.В.</td>
					<td>Дизайнер-верстальщик</td>
				</tr>
				<tr>
					<td>Ноябрь 2001 —<br/>октябрь 2005</td>
					<td>Газета "Арзамасские ведомости"</td>
					<td>Корректор,<br/>оператор верстки</td>
				</tr>
                <tr>
					<td>Май 1998 —<br/>декабрь 2000</td>
					<td>Типография "Вектор ТиС",<br/>г. Нижний Новгород</td>
					<td>Корректор, офис-менеджер</td>
				</tr>
                <tr>
					<td>Сентябрь 1996 —<br/>март 1997</td>
					<td>СШ №16, г.Арзамас</td>
					<td>Учитель истории</td>
				</tr>
			</tbody>
		</table>
	</div>
    </section>
    
    <section class="section__hr">
	<h3>Дополнительный опыт</h3>
	<div class="table-wrapper lowered_30">
		<table>
			<thead>
				<tr>
					<th>Продолжительность</th>
					<th>Организация</th>
					<th>Обязанности</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Апрель 2018 — настоящее время</td>
					<td>Газета "Всё про всё в Арзамасе"</td>
					<td>Корректорская правка</td>
				</tr>
				<tr>
					<td>Периодически с 2005 до 2018</td>
					<td>Частный фотограф</td>
					<td>Обработка фотографий</td>
				</tr>
				<tr>
					<td>Эпизодически с 2014 по 2018 </td>
					<td>Газета "Арзамасские ведомости"</td>
					<td>Корректура, верстка<br/>на замену основных работников</td>
				</tr>
				
			</tbody>
		</table>
	</div>


</section>
</div>
         
        <?php 
           //echo '<pre>';
           //print_r($this);
           // echo '</pre>';
        ?>       
           
        
    </div><!--закрытие container__main-->
            
    <?php include_once FOOTER_REZUME; ?>
</body>
</html>