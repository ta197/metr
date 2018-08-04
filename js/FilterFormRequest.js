'use strict';
class FormRequest
{
    constructor(form){
        let uls = form.getElementsByTagName('ul');
        let id;
        for(let i=0; i<uls.length; i++){
            id = uls[i].getAttribute('id');
            this[id] = this.requestItem(uls[i]);
        }
    }
    			
    requestItem(ul){
        let lis = ul.getElementsByTagName('li');
        let arr = [];
            for(let i=0; i<lis.length; i++){
                let count = 0;
                let input = lis[i].getElementsByTagName("input")[0];
                    if((input.value == 'не указано') || (input.value == 'нет данных'))
                        continue;
                    if(input.type === "checkbox")
                        //count =lis[i].getElementsByTagName("span")[0].firstChild.nodeValue.match(/\d+/);
                    count = lis[i].getElementsByTagName("span")[0].textContent.match(/\d+/)[0];
                arr.push(new FormItem(input.value, input.checked, input.name, count));  
            }
        return arr;
    }
}

class FormItem
{
    constructor(value, checked, name, count){
        this.value = value;
        this.checked = checked;
        this.count = count;
        this.name = name;
    }
}
