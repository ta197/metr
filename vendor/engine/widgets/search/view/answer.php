<div class= "header__breadcrumb top-content side-content">
    <a href="/">главная</a>  |  <a href="/search">поиск</a>  |  результат поиска
</div>              
            
<?php 
    $counter = array_sum(array_column($this->search->res_map, 'count'));
        include_once TITLE_H1; 
?>   
    <div class="side-content">
        <form action="/search/answer/search/" method="get" class="base-form search-form">
            <input type="text" name="search" value="<?= $search->search_query?>" placeholder="Искать здесь...">
            <button type="submit"></button>
            <!--<label for="" class="search-form__note">восстановление ванн</label>-->
        </form>
    </div>

<? if($search->errors):
        include ROOT.'/application/views/main/error.inc';
    else :?>

        <div class="side-content bottom_45">
            По запросу <mark><?= $search->search_query?> </mark>найдено совпадений: <mark><?= $counter ?></mark><br/> 
            Затронутых разделов поиска: <mark><?php echo count($search->res_map)?></mark> (
            <?php 
                echo  implode(', ', array_map('static::quote_ucfirst', array_column($search->res_map, 'title')));
            ?>
            )
        </div>

        <?php 
        foreach ($search->res_map as $key => $value):
            $section = $value['section'];
            $title_section = $value['title'];
            $count_section = $value['count'];
            
            if(!empty($value['view_section'])){
                include ($value['view_section']);
            }else{
                include ($search::VIEW_SECTION_DEFAULT);
            }
        endforeach; ?>

<?endif;?>
    
<?php   echo '<pre>';
       //print_r($this->search->res_map);
     //print_r($this->search->results);
     //print_r($this);
       echo '</pre>';

                                    