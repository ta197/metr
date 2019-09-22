<p class="side-content notice">
    <?= (!empty($errQuery)) ?? ''; ?>
</p>    
    
    <? if($this->search->errors['others'] && is_array($this->search->errors['others'])){?>
        <p class="side-content notice">
        <? 
            
            echo implode('<br>', $this->search->errors['others']);
           
        ?>
         </p> 
    <?}?>
