            <div class= "header__breadcrumb top-content side-content">
                <a href="/">На сайт</a>  | <a href="/admin"> админ-панель</a> | каталог
            </div>
            
            <?php include_once TITLE_H1; ?> 
            <?php 
        //if(!empty($createCat)){
            
            //echo '<h3 class = "side-content red">Категория <a href ="/category/section/cat/'."$createCat->cat_id".'">'."$quote_query</a> уже есть!</h3>";
       // }
        ?>   

        <div class="side-content">

          <form action="/admin/catalog" method="post" class="base-form search-form">

        <ul>
       <li>
       <input type="text" name="createGoogs" placeholder="Добавить позицию каталога">
       <button type="submit"></button>
       </li>
       </ul >
          </form>
          </div> 

        <div class="side-content">

        <form action="/admin/catalog/delete" method="post" class="base-form search-form">
        
        <ul>
        <li>
        <input type="text" name="deleteGoogs" placeholder="Удалить позицию каталога">
        <button type="submit"></button>
        </li>
        </ul >
        </form>
        </div> 
        

            <?php include_once ADMIN_CAT_MENU ?>
            
            <?php 
                echo '<pre>';
                print_r($this);
                echo '</pre>';
            ?>       
           
