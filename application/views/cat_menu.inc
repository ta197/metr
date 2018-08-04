<div class="category-bigmenu">
<?php

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
      if(!empty($category['activated'])){
        echo '<a href="/category/section/cat/'.$category['cat_id'].'">'.$category['name']."</a>";
      }
      else {
         echo $category['name']; 
      }
     
      $level=$category['level'];
  }
  for($i=$level;$i;$i--)
  {
      echo "\t"."</li>"."\n";
      echo "\t"."</ul>"."\n";
  }

?>
</div>
