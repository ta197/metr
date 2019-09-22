<div class= "header__breadcrumb side-content top-content">
    <a href="/">главная</a>  |  организации
</div>
<?php include_once TITLE_H1; ?>
   
<div class="side-content adjustment">
<form name="filtersForm" action="/company/filters/search/" class="filters-form" method="get">
    <?php $i=1;?>
    <? foreach($filters as $k=>$arr):?>
        <ul id="<?=$k?>">
            <? foreach($arr as $val):?>
                <li><input type= "<?= $val['type']?>" id="input<?=$i?>" name="<?= $val['name']?>" value="<?=$val['value']?>"<? echo ($val['checked'] == true) ? ' checked' : '';?>>
                     <label for="input<?=$i ?>"><?=$val['value'] ?>
                        <? if($val['type']=== "checkbox"){
                            echo '<span class= "counter"> ('.$val['count'].')</span>';
                        }?>
                </label></li>
                <? $i++;?>  
            <? endforeach ?>
       </ul>
    <? endforeach; ?>
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