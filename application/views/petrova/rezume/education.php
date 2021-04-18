<div class="header__breadcrumb side-content top-content">
    <a href="/petrova">резюме Петровой Т.В.</a> | образование
</div>

<header class="side-content">
    <h1 class="header__title" lang="ru-Ru">
        Образование
    </h1>
</header>

<div class="side-content">

    <section id="univer" class="section__hr">

        <h3>Высшее</h3>
        <div class="table-wrapper lowered_30">
            <table>
                <thead>
                <tr>
                    <th>Год</th>
                    <th>Учебное заведение</th>
                    <th>Специализация</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>1998</td>
                    <td>Академия государственного и муниципального управления РАГС при Президенте РФ</td>
                    <td>правовой менеджмент</td>
                </tr>
                <tr>
                    <td>1997</td>
                    <td>Арзамасский государственный педагогический институт им. А.П. Гайдара, Арзамас</td>
                    <td>филология, история</td>
                </tr>
                </tbody>
            </table>
        </div>
    </section>
	
	<?
	foreach (['english', 'retraining'] as $code) : ?>
        <section id="<?= $code ?>" class="section__hr">
            <h3><?= self::ucfirst_utf8($this->$code[0]['category_name']) ?></h3>
			<?
			include ROOT . '/application/views/petrova/petrova_name_type_training.inc'; ?>
        </section>
	<? endforeach; ?>

    <section id="bitrix" class="section__hr">
        <h3><a href="https://dev.1c-bitrix.ru/learning/index.php#tab-certif-link" class="link-dashed">«1С-Битрикс:</a> Управление сайтом»</h3>
		<?
		include_once ROOT . '/application/views/petrova/petrova_bitrix.inc'; ?>
    </section>

    <section id="geek_brains" class="section__hr">
        <h3>Сертификаты <a href="https://gb.ru/" class="link-dashed">GeekBrains</a></h3>
		<?
		include_once ROOT . '/application/views/petrova/petrova_geek_brains.inc'; ?>
    </section>
    
    <section id="mod" class="section__hr">
        <h3>Прочие курсы</h3>
        <div class="table-wrapper lowered_30">
            <table>
                <thead>
                <tr>
                    <th>Год</th>
                    <th>Сертификат</th>
                    <th>Кем выдан</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>2012</td>
                    <td>Дизайнер-модельер-конструктор</td>
                    <td>АНО "Институт Исследования Технологий"</td>
                </tr>
                </tbody>
            </table>
        </div>
    </section>

</div>