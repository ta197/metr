<?php

echo <<<HEREDOC
<div class="category-bigmenu side-left">
HEREDOC;
if(isset($catMenu)):
$level = 0;

  foreach ($catMenu as $category){
      if ($category['level'] == $level) {echo "</li>"."\n";}
      else if ($category['level']>$level){
          echo "\n\t"."<ul>"."\n";
      }
      else{
          echo "</li>"."\n";
          for($i=$level-$category['level'];$i;$i--)
              {
              	echo "\t"."</ul>"."\n";
              	echo "\t\t"."</li>"."\n";
              }
      }
      echo "\t\t"."<li>";
      if(!empty($category['activated']) and !empty($category['visible'])){
        echo '<a href="/admin/category/update/'.$category['cat_id'].'">'.$category['name']."</a>";
       // echo '<input type="checkbox" id="input1" name="activated" value="activated"><label for="input1"></label>';   
                         
      }
      elseif(empty($category['visible'])){
        echo '<a href="/admin/category/update/'.$category['cat_id'].'"><mark>'.$category['name']."</mark></a>";
         //echo '<input type="checkbox" id="input1" name="activated" value="activated"><label for="input1"></label>';
                    
      }

      else {
         echo $category['name'];
           //echo '<input type="checkbox" id="input1" name="activated" value="activated"><label for="input1"></label>';
      }
     
      $level=$category['level'];
  }
  for($i=$level;$i;$i--)
  {
      echo "\t"."</li>"."\n";
      echo "\t"."</ul>"."\n";
  }
else: echo 'меню нет';
endif;
?>
</div>
