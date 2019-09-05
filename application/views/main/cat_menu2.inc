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
$sub = [];
$f = '';
$lft = 0;
$rgt = 0;

  foreach ($catMenu as $category){
      if ($category['level'] == $level) {
          echo "</li>"."\n";

          if($category['lft'] > $lft  && $category['rgt'] < $rgt && $category['parent_id']=== $f){
                if(array_key_exists($level, $sub)){
            
                
                    $sub[$level]= "su11b$level/".$category['parent_id']. '/';
                 }else{
                  // $sub[] = "sub$level/".$category['parent_id']. '/';
                //$sub[]= '/o/o/';
                }
               
           }
           
            $lft = $category['lft'];
            $rgt = $category['rgt'];
            $f= $category['cat_id'];
        }
      else if ($category['level'] > $level){
          echo "\n\t"."<ul>"."\n";
          if($category['lft'] > $lft && $category['rgt'] < $rgt && $category['parent_id']=== $f){   
                if(array_key_exists($level, $sub)){
                    $sub[$level]= "sub$level/".$category['parent_id']. '/';
                } else{
                  $sub[]= "sub$level/".$category['parent_id']. '/';
               // $sub[]= '/f/f/';
                }    
        }
        
            $lft = $category['lft'];
            $rgt = $category['rgt'];
            $f= $category['cat_id'];
      }
      else{
          echo "</li>"."\n";
            
                if($category['lft'] > $lft   && $category['rgt'] < $rgt && $category['parent_id']=== $f){
                     if(array_key_exists($level, $sub)){
                        $sub[$level]= "sub$level/".$category['parent_id']. '/';
                    }else{
                        $sub[]= "sub$level/".$category['parent_id']. '/';
                    }   
                }
         
            $lft = $category['lft'];
            $rgt = $category['rgt'];
            $f= $category['cat_id'];

          for($i = $level - $category['level']; $i; $i--)
              {
              	echo "\t"."</ul>"."\n";
              	echo "\t\t"."</li>"."\n";
               
              }
      }
      echo "\t\t"."<li>";

       

                //if( isset($sub[$level])){
            
                
                    //$sub[$level]= "sub$level/".$category['parent_id']. '/';}
       
        $t = implode('', $sub);
        //var_dump($sub); die;
  
      if(!empty($category['activated'])){
        echo '<a href="/category/section/'. $t.'cat/'.$category['cat_id'].'">'.$category['name']."</a>";
      }
      else {
         echo $category['name']; 
      }
     
       $level = $category['level'];
      
      
  }
  
    
      echo "\t"."</li>"."\n";
      echo "\t"."</ul>"."\n";


?>
</div>
