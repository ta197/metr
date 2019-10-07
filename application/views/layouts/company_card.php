<!DOCTYPE html>
<html lang="ru-Ru">
<head>
    <meta charset="UTF-8">
    <? if(isset($page->title)):?>
    <title><?= $page->title; ?></title>
    <? endif; ?>
    <link rel="stylesheet" href="/public/css/style.css" type="text/css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <script type="text/javascript" src="/public/js/smoothscroll.js" type="text/javascript"></script>
    <script type="text/javascript" src="/public/js/updown.js" type="text/javascript" defer></script>
    
    <script src="https://api-maps.yandex.ru/2.1/?apikey=<ваш API-ключ>&lang=ru_RU" type="text/javascript"></script>

</head>
<body>

    <?php include_once FIGURE; ?>

    <?php include_once NAV_ICON; ?>
     
    <div class="container__main">
    <?=$content; ?>
    <div class="listing side-content">    
            <?php 
           echo '<pre>';
              //print_r($this);
            echo '</pre>';
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