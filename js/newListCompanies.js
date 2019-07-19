'use strict';
function newListCompanies(l, listLetters = null){
    var letter ='';
   for(let i in l){
        if(listLetters && listLetters.length > 3){
            if(letter !== l[i].letter && /[А-Яа-я]/.test(l[i].letter)){
                letter = l[i].letter;
                var h2 = document.createElement("h2");
                h2.id = "letter" + letter;
                h2.className = "listing__letter";
                var textH2 = document.createTextNode(decodeURIComponent(letter));
                h2.appendChild(textH2);
                listing.appendChild(h2);
            }
        }
        var dl = document.createElement("dl");
        dl.setAttribute('class', "listing__company");
              
        var dt = document.createElement("dt");
        
        var name = document.createTextNode(decodeURIComponent(l[i].company_name));
        dt.appendChild(name);
        dt.setAttribute('class', "listing__company-name");
            if(l[i].company_name.charAt(0) == "«"){
                dt.setAttribute('class', "listing__company-name listing__company-name_quote-indent");
            }    
        

        var ddLink = document.createElement("dd");
        ddLink.setAttribute('class', "listing__link");
        
        var aLink = document.createElement("a");
        aLink.setAttribute('href', "/company/card/name/"+ l[i].company_id);
        var textLink = document.createTextNode("подробнее");
        aLink.appendChild(textLink);
        ddLink.appendChild(aLink);
        if(l[i].site){
            var aLinkSite = document.createElement("a");
            aLinkSite.setAttribute('href', "http:////www." + l[i].site);
            var textSite = document.createTextNode("сайт");
            aLinkSite.appendChild(textSite);
            
            var gap = document.createElement("div");
            gap.setAttribute('class', "gap");
            var textGap = document.createTextNode(" | ");
            gap.appendChild(textGap);
            ddLink.appendChild(gap);

            ddLink.appendChild(aLinkSite);
        }
        
        
        dl.appendChild(dt);

        var arrRaw = decodeURIComponent(l[i].addresses);
        var arr = arrRaw.split('~~');
        if(arr.length>0){
            arr.forEach(function(item, j, arr) {
                if(item.charAt(1) == "|") item = item.substring(3);
                let address = document.createElement("dd");
                address.setAttribute('class', "listing__company-address");
                let textAddr = document.createTextNode(item);
                address.appendChild(textAddr);
                dl.appendChild(address);
              });
        }

        dl.appendChild(ddLink);
        listing.appendChild(dl);
        }
}