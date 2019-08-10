<!DOCTYPE html>
<html lang="ru-Ru">
<head>
    <meta charset="UTF-8">
    <title><?=$title?></title>
    <link rel="stylesheet" href="/css/style.css" type="text/css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <script type="text/javascript" src="/js/smoothscroll.js" type="text/javascript"></script>
    <script type="text/javascript" src="/js/updown.js" type="text/javascript" defer></script>

    <script src="/js/dragNdrop/lib.js" type="text/javascript"></script>
    <script src="/js/dragNdrop/DragManager.js" type="text/javascript"></script>
    <script src="/js/dragNdrop/DragAvatar.js" type="text/javascript"></script>
    <script src="/js/dragNdrop/DragZone.js" type="text/javascript"></script>
    <script src="/js/dragNdrop/DropTarget.js" type="text/javascript"></script>
    <script src="/js/dragNdrop/TreeDragAvatar.js" type="text/javascript"></script>
    <script src="/js/dragNdrop/TreeDragZone.js" type="text/javascript"></script>
    <script src="/js/dragNdrop/TreeDropTarget.js" type="text/javascript"></script>
</head>
<body>
    <?php include_once FIGURE; ?>
    <?php include_once ADMIN_NAV_ICON; ?>
        
        <div class="container__main">
            <div class= "header__breadcrumb top-content side-content">
            <a href="/">На сайт</a>  | <a href="/admin"> админ-панель</a> | <a href="/admin/category">категории</a>  |  новая категория
            </div>
            
            <?php include_once TITLE_H1; ?>
           

    
    <!-- <h3 class = "listing side-content">Список имеющихся категорий</h3> -->
    
    <?php include_once 'cat_menu_draggable.php'; ?>
   

    <div class="side-content">

<form name="settingsForm"  action="/admin/creatcategory" method="post" class="filters-form">

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
  
</form>
<input type="submit" id="dark" class="button-dark" value="применить"/>

</div> 

    <?php 
        echo '<pre>';
        print_r($_POST);
        print_r($this);
        echo '</pre>';
    ?>       
    
    </div><!--закрытие container__main-->    

<?php include_once ADMIN_FOOTER; ?>
<script>
    let tree = document.getElementById('tree');
    new TreeDragZone(tree);
    new TreeDropTarget(tree);
  </script>

</body>
</html>