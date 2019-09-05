'use strict';
function newPagination(f){
if (f.navparams.max_page >1){
    var id = 1;
    //for (var key in f){
        var ul = document.createElement("ul");
        ul.setAttribute('id', "pagination");
        ul.setAttribute('class', "pagination");
        if(f.navparams.page_num <= 1){
            var start = document.createElement("li");
            ul.appendChild(start);
            var span = document.createElement("span");
            start.appendChild(span);
            var startText = document.createTextNode('Начало');
            span.appendChild(startText);
        }else{
            var start = document.createElement("li");
            ul.appendChild(start);
            var span = document.createElement("span");
            start.appendChild(span);
            var astart = document.createElement("a");
            astart.href = f.navparams.url_self;
            var startText = document.createTextNode('Начало');
            span.appendChild(startText);

        }
        for (let j = f.navparams.left; j <= f.navparams.right; j++){
            
        }  
    //}
   
    }
}