        <div class= "header__breadcrumb side-content top-content">
			<?php echo $title; ?>
        </div>
        
        <header class="side-content">
            <h1 class="header__title" lang="ru-Ru">
				<?= $this->page->header_title; ?>
            </h1>   
        </header>

        <?php include_once ROOT.'/application/views/petrova/petrova_contacts.inc'; ?>
        
        <div class="side-content">
            <section class="section__hr"> 
                <h2>Основные сведения</h2>
		    </section> 
        </div>

        <div class="category-bigmenu category-bigmenu_three side-left">
		<ul>
			<li><h4>Что мне интересно</h4>
			<ul>
				<li><a href="/petrova/rezume/develop">веб-разработка</a></li>
				<li><a href="/petrova/rezume/design">дизайн</a></li>
	            <li><a href="/petrova/rezume/proofs">корректура</a></li>
				<li>верстка</li>
			</ul>
			</li>
			<li><h4>Опыт работы</h4>
			<ul>
				<li><a href="/petrova/rezume/experience">весь</a></li>
                <li><a href="/petrova/rezume/design#design-experience">дизайнером</a></li>
				<li><a href="/petrova/rezume/proofs#proofs-experience">корректором</a></li>
			</ul>
			</li>

			<li><h4>Образование</h4>
			<ul>
				<li><a href="/petrova/rezume/education#univer">высшее</a></li>
				<li><a href="/petrova/rezume/education#certif">самообразование</a></li>
			</ul>
			</li>
			<li><h4>Личные данные</h4>
			<ul>
				<li>женщина</li>
	            <li>родилась 19.10.1974</li>
			</ul>
			</li>

			<li><h4>Место жительства</h4>
			<ul>
				<li>Н.Новгород</li>
				<li><a href="/petrova/rezume/add#city">Арзамас</a></li>
                <li>любой город</li>
			</ul>
			</li>
			<li><h4>Рекомендации</h4>
			<ul>
				<li><a href="/petrova/rezume/add#recom">Шорина О.Н.</a></li>
				<li><a href="/petrova/rezume/add#recom">Рыжова С.А.</a></li>
			</ul>
			</li>
		</ul>
	    </div>

           
        <div class="side-content">
            <section class="section__hr"> 
                <h2>Дополнительнo</h2>
                <p>Об увлечениях и другие дополнительные сведения <a href="/petrova/rezume/add#hobby" class="notice">здесь</a>.</p>
		    </section> 
        </div>
 
