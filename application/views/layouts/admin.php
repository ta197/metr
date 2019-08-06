<?php
// session_start();
// if(empty($_SESSION['user'])){
//     header('Location: /admin/login');
// }

// setcookie("name", "John", time()-3600);
include_once HEAD; ?>
<body>
       
    <?php include_once FIGURE; ?>
    <?php include_once ADMIN_NAV_ICON; ?>

        <div class="container__main">
        <?=$content; ?>
        </div><!--закрытие container__main-->
        
        <?php 
         require_once ADMIN_FOOTER;
        ?>
   
</body>
</html>