            <div class= "header__breadcrumb top-content side-content">
                <a href="/">На сайт</a>  | <a href="/admin"> админ-панель</a> | <a href="/admin/company">компании</a> | новая организация
            </div>
            
            <?php include_once TITLE_H1; ?>
           

<form action="#" method="post" class="base-form search-form">
<h3 class= "side-content bottom_45">Название компании</h3> 
   <ul >
       <li class= "side-content"><input type="search" name="search" placeholder="Название организации"><button type="submit" class= "side-content"></button></li>
       <li class= "side-content">
       <ul id="name-type">
					<li>
						<input type="radio" id="input8"  name="progression[]" value="по названию, А-Я" checked>
						<label for="input8">по названию, А-Я</label>
					</li>
					<li>
						<input type="radio" id="input9"  name="progression[]" value="по названию, Я-А">
						<label for="input9">по названию, Я-А</label>
					</li>
					<li>
						<input type="radio" id="input10"  name="progression[]" value="по рейтингу">
						<label for="input10">по рейтингу</label>
                    </li>
                    <li>
						<input type="radio" id="input8"  name="progression[]" value="по названию, А-Я" checked>
						<label for="input8">по названию, А-Я</label>
					</li>
					<li>
						<input type="radio" id="input9"  name="progression[]" value="по названию, Я-А">
						<label for="input9">по названию, Я-А</label>
					</li>
					<li>
						<input type="radio" id="input10"  name="progression[]" value="по рейтингу">
						<label for="input10">по рейтингу</label>
					</li>
				</ul>
        <label for="name_type" class="search-form__note ">Например, <span class ="listing__link italic bottom_60">1-shop; 2-legal; 3-shop, legal; 4-shop, legal, name_legal; 5- legal, name_legal; 6-legal, shop (после company)</span></label>
        </li>
       <li class="side-content lowered_30"><input type="text" name="search" placeholder="Форма собственности"></li>
       <li class= "side-content"><input type="text" name="ul" placeholder="улица"></li>
       <li></li>
       <li></li>
       <li></li>

   </ul> 
    
   <h3 class= "side-content">Выбрать категории компании</h3> 
            <?php include_once CAT_MENU; ?>
    
  
    
   
        <ul class="link-buttons side-content">
                <li class="link-buttons__item"><a href="#" class="button-dark">Применить</a></li>
                <li class="link-buttons__item"><a href="#" class="button-dark">Отменить</a></li> 
        </ul> 
</form>



           
            
            <?php 
                // echo '<pre>';
                // print_r($this);
                // echo '</pre>';
            ?>       
           
