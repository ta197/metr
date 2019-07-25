<?php
if(!empty ($countCatSubMenu) and $countCatSubMenu<7){
    $countCatSubMenu = ' category-bigmenu_three ';
}
else{
    $countCatSubMenu = ' ';
}
echo <<<HEREDOC
<div class="category-bigmenu{$countCatSubMenu}side-left">
HEREDOC;

$level = 0;
  foreach ($catMenu as $category){
      if ($category['level'] == $level) {echo "</li>"."\n";}
      else if ($category['level']>$level){
          if($category['level']== 1) {
            echo "\n\t"."<ul id='tree'>"."\n";
            //echo "<li><span> </span>"."\n";
            echo "<li><span style='color: #0677a0'>".$newCat."</span></li>"."\n";
          }else{
            echo "\n\t"."<ul>"."\n";
          }
          
      }
      else{
          echo "</li>"."\n";
          for($i=$level-$category['level'];$i;$i--)
              {
              	echo "\t"."</ul>"."\n";
              	echo "\t\t"."</li>"."\n";
              }
      }
      echo "\t\t"."<li><span>";
      //if(!empty($category['activated'])){
        echo $category['name'].' ('.$category['cat_id'].")</span>";
    //   }
    //   else {
    //      echo $category['name']; 
    //   }
     
      $level=$category['level'];
  }
  for($i=$level;$i;$i--)
  {
      echo "\t"."</li>"."\n";
      echo "\t"."</ul>"."\n";
  }

?>
</div>
