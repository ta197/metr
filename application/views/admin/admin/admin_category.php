            <div class= "header__breadcrumb top-content side-content">
                <a href="/">главная</a>  |  категории
            </div>
            
            <?php include_once TITLE_H1; ?> 
            <?php 
        if(!empty($createCat)){
            
            echo '<h3 class = "side-content red">Категория <a href ="/category/section/cat/'."$createCat->cat_id".'">'."$quote_query</a> уже есть!</h3>";
        }
        ?>   

        <div class="side-content">

          <form action="/admin/category" method="post" class="base-form search-form">

        <ul>
       <li>
       <input type="text" name="createCat" placeholder="Добавить категорию">
       <button type="submit"></button>
       </li>
       </ul >
          </form>
          </div> 

        <div class="side-content">

        <form action="/admin/category" method="post" class="base-form search-form">
        
        <ul>
        <li>
        <input type="text" name="deleteCat" placeholder="Удалить категорию">
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
           
