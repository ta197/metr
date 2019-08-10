            <div class= "header__breadcrumb top-content side-content">
            <a href="/">На сайт</a>  | <a href="/admin"> админ-панель</a> | <a href="/admin/category">категории</a>  |  новая категория
            </div>
            
            <?php include_once TITLE_H1; ?>
           
            <?php 
        if(!empty($createCat)){
            
         echo '<h3 class = "side-content red">Категория <a href ="/category/section/cat/'."$createCat->cat_id".'">'."$quote_query</a> уже есть!</h3>";
        }
        ?>   

           
   

    <div class="side-content bottom_60">

    <form name="settingsForm"  action="/admin/category/create" method="post" >
        <fieldset class="base-form">
        <h3 class="bottom_45"> К какому разделу будет относиться (и его уровень, id)</h3>
        <ul>
            <li>
                <?php 
                //include_once 'cat_menu_optionsForSelect.php'; ?>
            </li>
        </ul >
        </fieldset>
        
        <fieldset class="filters-form">
        <h3 class="bottom_45"> Настройки видимости</h3>    
        <ul id="activated">
            <li>
                <input type="radio" id="activ" name="activ" value="активна" checked>
                <label for="activ">активна</label>
            </li>
            <li>
                <input type="radio" id="noactiv" name="activ" value="не активна">
                <label for="noactiv">не активна</label>
            </li>
        </ul >
        <ul id="visible">
            <li>
                <input type="radio" id="vis" name="vis" value="видима" checked>
                <label for="vis">видима</label>
            </li>
            <li>
                <input type="radio" id="novis" name="vis" value="не видима">
                <label for="novis">не видима</label>
            </li>
        </ul >
        </fieldset>
        
        <input type="submit" id="dark" class="button-dark" value="применить"/>
</form>
</div> 

<h3 class="listing side-content">Существующее меню</h3>
<?php 
    //include_once ADMIN_CAT_MENU 
?>
    <?php 
        echo '<pre>';
        print_r($_POST);
        print_r($this);
        echo '</pre>';
    ?>       
