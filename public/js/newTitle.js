'use strict';
function newTitle(h1, counter){
if (!h1) return;
    
    var textH1 = document.createTextNode(decodeURIComponent(h1));
    title.appendChild(textH1);
    var span = document.createElement("span");
    span.className = "counter";
    var count = document.createTextNode('('+ decodeURIComponent(counter) + ')');
    span.appendChild(count);
    title.appendChild(span);     
}