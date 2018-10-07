<?php
$title = 'организации';
if(!$h1) $h1 = 'Все организации справочника';
$counter['counter'] = $countCompany;
?>
<!DOCTYPE html>
<html lang="ru-Ru">
<head>
    <meta charset="UTF-8">
    <title><?=$title?></title>
    <link rel="stylesheet" href="/css/style.css" type="text/css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="/js/json2.js" type="text/javascript"></script>
    <script type="text/javascript" src="/js/getXmlHttpRequest.js" type="text/javascript"></script>
    <script type="text/javascript" src="/js/FilterFormRequest.js" type="text/javascript"></script>
    <script type="text/javascript" src="/js/newTitle.js" type="text/javascript"></script>
    <script type="text/javascript" src="/js/newForm.js" type="text/javascript"></script>
    <script type="text/javascript" src="/js/newLetters.js" type="text/javascript"></script>
    <script type="text/javascript" src="/js/newListCompanies.js" type="text/javascript"></script>
    <script type="text/javascript" src="/js/smoothscroll.js" type="text/javascript"></script>
    <script type="text/javascript" src="/js/updown.js" type="text/javascript" defer></script>
    <!-- <script>document.write('<style>.js_hidden { display: none; }</style>');</script> -->
    
    <script type="text/javascript">
    'use strict';
    var form,
        letters,
        listing,
        title,
        strSearch = '',
        letterHash ='',
        f = '',
        flag = false;
   
    window.addEventListener('popstate', function (event) {
        if(event.state){
            showData(event.state || window.history.state);
        }
	});
        
    document.addEventListener( "DOMContentLoaded", function(){
        form = document.forms.filtersForm;
        document.getElementById("dark").className = "display-none";
        listing = document.getElementById("listing");
        letters = document.getElementById("letters");
        title = document.getElementsByTagName('h1')[0];
        
        if(!flag){
            if(location.hash !=='' && 'state' in window.history && window.history.state !== null){
                showData(window.history.state);
            }
        flag = true;
        }
    });

    window.onhashchange = function(){
        if(!location.hash){
            //location.assign('/company');
            location.reload(false);
            //window.location.href = "/company";
        }
    }

    //form.
    

//     window.onhashchange = function(){
//  // if(location.hash)
//     updownElem.className = ''; 
//     }


    
    // function checkedLetters() {
    //     //event.preventDefault();
    //     if (event.target.nodeName == 'A') {
	// 		//title = event.target.innerHTML;
    //         //strSearch = location.hash;
    //         checkedForm();
    //         //showData(f);
	// 		letterHash = event.target.getAttribute('href');
	// 		history.pushState('', '', '/company/query/s' + strSearch + letterHash);
	// 		}
    //     }
    
    // function getLetterHash() {
    //     if (event.target.nodeName == 'A') {
	// 				//title = event.target.innerHTML;
	// 				letterHash = event.target.getAttribute('href');
	// 				//history.pushState(null, '', '/company' + strSearch + letterHash);
	// 			}
    //             history.pushState(null, '', '/company' + strSearch + letterHash);
	// }
   
	// function clearForm(){
	// 	while (form.hasChildNodes())
    //     form.removeChild(form.lastChild);
    // }

    
    function showData(f){
        form.innerHTML = "";
        listing.innerHTML = "";
        letters.innerHTML = "";
        title.innerHTML = "";
        newForm(f.filters);
        if(f.listLetters) newLetters(f.listLetters);
        newTitle(f.h1, f.count);          
        newListCompanies(f.listCompany, f.listLetters);
       
    }

    function calculateStrSearch(request){
        var strSearch ='';
        for(let i in request){
            for(let j in request[i]){
                if(request[i][j].checked === true){
                    strSearch += request[i][j].value + '&'; 
                }
            }
        }
        if(strSearch == decodeURIComponent('по%20названию%2C%20А-Я%26')) 
            strSearch ='';
        if(strSearch) strSearch = '#!' + strSearch;
        return strSearch;
    }
              
	function checkedForm(){
      
        let request = new FormRequest(form);
        strSearch = calculateStrSearch(request);
        // if(hash) location.assign(originUrl + "#!" + encodeURIComponent(hash));
        let jsonData = JSON.stringify(request);
		let req = getXmlHttpRequest();
		req.open("POST", "/company/filters", true);
		req.setRequestHeader("Content-Type", "text/plain");
		//req.setRequestHeader("Content-Length", jsonData.length);
        req.send(jsonData);
        req.onreadystatechange = function()
        {
			if (req.readyState != 4) return;
            f = JSON.parse(req.responseText);
           
            showData(f);
            history.pushState(f, '', '/company' + strSearch);
            //clearForm();
        };  
    }            
	</script>
</head>
<body>
       
    <?php include_once FIGURE; ?>

    <?php include_once NAV_ICON; ?>
        
        <div class="container__main">
            <div class= "header__breadcrumb side-content top-content">
                <a href="/">главная</a>  |  организации
            </div>
            
            <?php include_once TITLE_H1; ?>   

            <div class="adjustment">
            
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
                          
            <a href = "/company"><div class="filters-form__reset"></div></a>
                        
            <input type="submit" id="dark" class="button-dark" value="применить"/>
                
            </form>
            </div>

            <?php
            if(!empty($error))
                echo '<div class="listing side-content">'.$error.'</div>';
            ?>             

            <div id ="letters" class="listing side-content">
                <?php
                if(!empty($listLetters) and count($listLetters)>3) {
                    foreach($listLetters as $v){
                        echo '<a href="#letter'.$v.'" class ="alphabet__letter">'.$v.'</a>';
                    }
                }
                ?>             
            </div>
            
            <div id ="listing" class="listing side-content">
            <?php include_once LIST_COMPANIES;?>
            </div>
            
            <div>
                <?php 
                // echo '<pre>';
                // print_r($this);
                // echo '</pre>';
                ?>             
            </div>
               
            <ul class="add-mininav side-content">
                <li class="add-mininav__item"><a href="42.html" class="button-dark">новые организации</a></li>
                <li class="add-mininav__item"><a href="42.html" class="button-dark">архивные организации</a></li>
            </ul>

        </div><!--закрытие container__main-->
            
        <?php include_once FOOTER; ?>
   
</body>
</html>