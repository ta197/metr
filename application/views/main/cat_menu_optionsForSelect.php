<select>
<?php
  foreach ($catMenuIncLevelZero as $category){
    echo '<option value="'.$category[level]. ' / ' .$category[rgt]. '">'.$category[name]. '  / ' .$category[level]. '  / ' .$category[cat_id].'</option>'; 
  }
?>
</select>
