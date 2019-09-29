<div class= "header__breadcrumb side-content top-content">
    <a href="/">главная</a>  |  <a href="/centre">центры</a>   |  <?= $centre->name_center; ?>
</div>

<?php include_once TITLE_H1; ?>
<?php if(!empty($centre->about)): ?>
   <p class="side-content lowered_15"><?= $centre->about; ?></p>
<? endif; ?>
<div class="listing side-content"> 
    <h3>
        Компании по этому адресу
        <?php 
            if(!empty($countCompanies)){
                echo '<span class = "counter">('.$countCompanies.')</span>';
            }else{
                echo ' не найдены';
            }
        ?>
    </h3>
</div>
<div class="listing side-content">   
<?php foreach ($companies as $company): ?>
    <dl class="listing__company">
    <dt class="listing__company-name"><?= $company['company_name']; ?></dt>
<?php 
    $addr = '';
    if(!empty($company['unit_floor'])){
        $addr .= $company['unit_floor']. ' этаж';
    }
    if(!empty($company['unit_not'])){
        $addr .= $company['unit_not'];
    }
    if(!empty($company['phones'])){
        if(empty($addr)){
            $company['phones'] = ltrim($company['phones'], '| ');
        }
        $addr .= $company['phones'];
    }
?>
    <dd class="listing__company-address"><?= $addr; ?></dd>
    <dd class="listing__link"><a href="<?= $this->route['prefix']; ?>company/card/name/<?= $company['company_id']; ?>">подробнее</a>
        <?php
            if($company['site']){
                echo '<div class="gap">|</div><a href="http://www.'."{$company['site']}".'" target ="_blank">сайт</a>';
            }
        ?>
    </dl>
<?php endforeach; ?>             
</div>
     

  <div class="listing side-content">
    <?php 
        //echo '<pre>';
        //print_r($this);
       // echo '</pre>';
    ?>       
    </div>
