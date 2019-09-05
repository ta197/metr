'use strict';
    var form,
        letters,
        listing,
        title,
        //pagination;
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
        //pagination = document.getElementById("pagination");

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

    
    function showData(f){
        form.innerHTML = "";
        listing.innerHTML = "";
        letters.innerHTML = "";
        title.innerHTML = "";
        //pagination.innerHTML = "";
        newForm(f.filters);
        if(f.listLetters) newLetters(f.listLetters);
        newTitle(f.h1, f.count);          
        newListCompanies(f.listCompany, f.listLetters);
        //newPagination(f.navparams);
    }

    function calculateStrSearch(request){
        var strSearch ='';
        for(let i in request){
            
            for(let j in request[i]){
                if(request[i][j].checked === true || request[i].page_num){
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