<?php
$title = $c->company_name;
$h1 = $c->company_name;
$countPlaces = count($p);
//include_once HEAD;
?>
<!DOCTYPE html>
<html lang="ru-Ru">
<head>
    <meta charset="UTF-8">
    <title><?=$title?></title>
    <link rel="stylesheet" href="/css/style.css" type="text/css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <script type="text/javascript" src="/js/smoothscroll.js" type="text/javascript"></script>
    <script type="text/javascript" src="/js/updown.js" type="text/javascript" defer></script>
    
    <script src="https://api-maps.yandex.ru/2.1/?apikey=<ваш API-ключ>&lang=ru_RU" type="text/javascript">
    </script>

</head>
<body>

    <?php include_once FIGURE; ?>

    <?php include_once NAV_ICON; ?>
        
    <div class="container__main">
        <div class= "header__breadcrumb side-content top-content">
            <a href="/">главная</a>  |  <a href="/company">организации</a>   |  <?= $c->company_name; ?>
        </div>
        
        <?php include_once TITLE_H1; ?>

        <?php
        if(!empty($c->about)){
            echo '<p class="side-content lowered_15">'.$c->about.'</p>';
            echo '<div class="listing side-content">'; 
        }else{
            echo '<div class="listing side-content lowered_16">'; 
        }
           
        foreach ($p as $item):
            echo '<dl class="listing__company">'."\n\t";
            echo '<dt class="listing__company-name">'."{$item->addresses}</dt>\n";
            if(!empty($item->phones)){
                $phones = ltrim($item->phones, " | ");
                echo "\t\t".'<dd class="listing__company-address">'."$phones</dd>\n";
            }
               
            if(!empty($item->work_mode))
                echo "\t\t".'<dd class="listing__company-address">режим работы: '."$item->work_mode</dd>\n";
            if(!empty($item->email))
                echo "\t\t".'<dd class="listing__company-address">e-mail: '."$item->email</dd>\n";

            if(!empty($item->goods)){
                if($countPlaces>1){
                    echo "\t\t".'<dd class="lowered_30 bottom_30"><a href="/catalog/place/p/'.$item->place_id.'" class="button-dark">каталог</a></dd>'."\n";
                }else{
                    echo "\t\t".'<dd class="lowered_30 bottom_30"><a href="/catalog/company/c/'.$c->company_id.'" class="button-dark">каталог</a></dd>'."\n";
                }
            }
                
            if(!empty($item->categories)){
                $cats = explode("~~", $item->categories);
                echo "\t\t".'<dd class="listing__link">относится к категориям:<div class="separator_rout"></div>';
                foreach ($cats as $key=>$cat):
                    $dataLink = explode(" | ", $cat);
                    if($key !== 0) echo " | ";
                    echo '<a href="/category/section/cat/'."$dataLink[1]".'">'."$dataLink[0]".'</a>';
                endforeach;  
                echo '</dd>'."\n";
            }
            if(!empty($item->coords)){
                
               echo '<div id="map" class="lowered_30 8 map" data-lat="'.$item->coords.'" 
               style="width: 600px; height: 400px"
               </div>';
            }
            
            echo "</dl>\n";
        endforeach; 
        
        ?>             
        </div>
             
        
          <div class="listing side-content">
            <?php 
               // echo '<pre>';
               // print_r($this);
               // echo '</pre>';
            ?>       
            </div>

    </div><!--закрытие container__main-->
            
    <?php include_once FOOTER; ?>
    <script type="text/javascript">
    //let coords = document.querySelector(".map").getAttribute('data-lat').split(',', 2);
    let coords = [
        [55.400778, 43.807926],
        [55.397858, 43.846383]
        
    ];
    ymaps.ready(init);    
    function init(){ 
        var myMap = new ymaps.Map("map", {
            center: [55.398958, 43.823494],
            zoom: 14,
            controls: ['smallMapDefaultSet']
        });

   var myGeoObjects = [];

    for (var i = 0; i<coords.length; i++) {
        myGeoObjects[i] = new ymaps.GeoObject({
        geometry: {
            type: "Point",
            coordinates: coords[i]
        }
  });
}

var myClusterer = new ymaps.Clusterer();
myClusterer.add(myGeoObjects);
myMap.geoObjects.add(myClusterer);
// Установим карте центр и масштаб так, чтобы охватить коллекцию целиком.
myMap.setBounds(myClusterer.getBounds());
        }
    </script>

</body>
</html>