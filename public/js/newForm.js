'use strict';
function newForm(f){
//if (f.length == 0) return;
    var id = 1;
    for (var key in f){
        var ul = document.createElement("ul");
        ul.setAttribute('id', key);
        form.appendChild(ul);
       // if (f[i] == 0) continue;
        for (let j = 0; j < f[key].length; j++){
            var li = document.createElement("li");
                ul.appendChild(li);
                var input = document.createElement("input");
                    input.type = decodeURIComponent(f[key][j].type);
                    input.name = decodeURIComponent(f[key][j].name);
                    input.id = 'input'+ id;
                    
                    input.setAttribute('data-item', decodeURIComponent(f[key][j].item));
                    input.value = decodeURIComponent(f[key][j].value);
                    if(f[key][j].checked) input.checked = decodeURIComponent(f[key][j].checked);
                var label = document.createElement("label");
                    label.htmlFor= 'input'+ id;
                    id++;
                    var labelText = document.createTextNode(decodeURIComponent(f[key][j].value));
                    label.appendChild(labelText);
                    if(f[key][j].count){
                        var span = document.createElement("span");
                        span.setAttribute("class", "counter");
                        var countText = document.createTextNode(' ' + '('+decodeURIComponent(f[key][j].count)+')');
                        span.appendChild(countText);
                        label.appendChild(span);
                    }
                li.appendChild(input);
                li.appendChild(label);
        }  
    }
    var reset = document.createElement("a");
    reset.href = "/company";
    var div = document.createElement("div");
    div.setAttribute("class", "filters-form__reset");
    reset.appendChild(div);
    form.appendChild(reset);
    // var reset = document.createElement("input");
    // reset.type = "reset";
    // reset.className = "filters-form__reset";
    // form.appendChild(reset);   
}