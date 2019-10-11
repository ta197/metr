<?php $items = $this->search->results[$section]; ?>

<h2 class="side-content subtitle subtitle__margin-30 bottom_45"><?=$title_section ?>
    <span class= "counter"> (<?= $count_section?>)</span>
</h2>

<div class="side-content">
    <? foreach($items as $q => $item): ?>
        <? foreach($item as $list): ?>
            <? foreach($list as $obj):?>
                <dl class="listing__company_search">
    
                    <div>
                        <span class="points">
                            <?php echo str_repeat('.', (int)$q); ?>
                        </span>
                    </div>
    
                    <?php $indent = '';
                        if(substr($obj, 0, 7) === "&laquo;") 
                            $indent = ' listing__company-name_quote-indent'; 
                    ?>
                    
                    <?php
                        if(is_file($this->search::SEARCH_ROOT.'/view/chunk_'.$section.'.php')){
                            include ($this->search::SEARCH_ROOT.'/view/chunk_'.$section.'.php');
                        }else{
                            include ($this->search::CHUNK_SEARCH_DEFAULT);
                    }?>
                    
                </dl>
            <? endforeach;?>
        <? endforeach;?>
    <? endforeach;?>
</div>
