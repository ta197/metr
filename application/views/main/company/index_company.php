<div class= "header__breadcrumb side-content top-content">
    <a href="/">главная</a>  |  организации
</div>

<?php include_once TITLE_H1; ?>   
<div class="side-content adjustment">

<form name="filtersForm" action="/company/filters/search/" class="filters-form" method="get">
    <?php
    $i=1;
    foreach($filters as $k=>$group){
        echo '<ul id="'.$k.'">'."\n\t\t\t\t";
            foreach($group as $v){
                echo "\t".'<li>'."\n\t\t\t\t\t\t".'<input type="'.$v['type'].'" id="input'.$i.'"  name="'.$v['name'].'" value="'.$v['value'].'"';
                //if($v['value'] === "по названию, А-Я")  echo ' checked';
                if($v['checked'] == true)  echo ' checked';
                echo '>'."\n\t\t\t\t\t\t".'<label for="input'.$i.'">'.$v['value'];
                if($v['type']=== "checkbox"){
                    echo '<span class= "counter"> ('.$v['count'].')</span>';
                }
                echo '</label>'."\n\t\t\t\t\t".'</li>'."\n\t\t\t\t";
                $i++;  
            }
        echo '</ul>'."\n\t\t\t\t";
    }
    ?>
              
<a href = "/company"><div class="filters-form__reset" title="сбросить"></div></a>
            
<input type="submit" id="dark" class="button-dark" value="применить"/>
    
</form>
</div>
<?php
if(!empty($error))
    echo '<div class="listing side-content">'.$error.'</div>';
?>             
<div id ="letters" class="listing side-content">            
    <?php include_once NAV_LETTERS; ?>
</div>


<div id ="listing" class="listing side-content">
    <?php include_once LIST_COMPANIES;?>
    <?php include '../application/views/navbar.php'; ?>
</div>
  
<ul class="link-buttons side-content">
    <li class="link-buttons__item"><a href="/company/young" class="button-dark">новые организации</a></li>
    <li class="link-buttons__item"><a href="/company/archive" class="button-dark">архивные организации</a></li>
</ul>