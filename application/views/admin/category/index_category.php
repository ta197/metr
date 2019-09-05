<div class= "header__breadcrumb top-content side-content">
    <a href="/">На сайт</a>  | <a href="/admin"> админ-панель</a> |  категории
</div>
            
<?php include_once TITLE_H1; ?> 
            
<?php if(!empty($createCat)){
    echo '<h3 class = "side-content red">Категория <a href ="/category/section/cat/'."$createCat->cat_id".'">'."$quote_query</a> уже есть!</h3>";
}
?>   

<div class="side-content">
    <form action="/admin/category" method="post" class="base-form search-form">
        <ul>
            <li>
                <input type="text" name="createCat" placeholder="Добавить категорию">
                
            </li>
        </ul >
        <button type="submit"></button>    
    </form>
</div> 

<div class="side-content">
    <form action="/admin/category/delete" method="post" class="base-form search-form">
        <ul>
            <li>
            <input type="text" name="deleteCat" placeholder="Удалить категорию">
            </li>
        </ul >
    <button type="submit"></button>    
    </form>
</div> 
        

<?php include_once ROOT.'/application/views/admin/admin_cat_menu.inc'; ?>
            
            <?php 
                echo '<pre>';
               // print_r($this);
                echo '</pre>';
            ?>       
           
