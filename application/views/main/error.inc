<p class="side-content notice">
    <?= (!empty($errQuery)) ?? ''; ?>
</p>    
    
    <? if($search->errors['others'] && is_array($search->errors['others'])){?>
        <p class="side-content notice">
        <? 
            
            echo implode('<br>', $search->errors['others']);
           
        ?>
         </p> 
    <?}?>
