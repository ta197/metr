var pageYLabel = 0;

document.addEventListener( "DOMContentLoaded", function(){
        var updownElem = document.getElementById('updown');
        updownElem.innerHTML = "";
        //updownElem.className = '';

        if(typeof form !== 'undefined'){
            form.addEventListener('change', function (){
                    updownElem.className = '';
                    pageYLabel = 0;
                    checkedForm();
                });
        }
        

        updownElem.addEventListener('click', function(){
                var pageY = window.pageYOffset || document.documentElement.scrollTop;
            switch (this.className) {
                case 'updown up':
                    pageYLabel = pageY;
                    //this.className = 'updown down';
                    window.scrollTo({'top': 0, 'left': 0, 'behavior': 'smooth'});
                    break;
                case 'updown down':
                    window.scrollTo({'top': pageYLabel,'left': 0, 'behavior': 'smooth'});
                    this.className = 'updown up';
            }
        });


        window.addEventListener ('scroll', function() {
            var pageY = window.pageYOffset || document.documentElement.scrollTop;
            var innerHeight = document.documentElement.clientHeight;

            switch (updownElem.className) {
                case '':
                  if (pageY > innerHeight) {
                    updownElem.className = 'updown up';
                  }
                  break;
              
                case 'updown up':
                if (pageY >= innerHeight) break;
                if (pageYLabel !==0) {
                  updownElem.className = 'updown down';
                }else {
                  updownElem.className = '';
                }
                break;
            
                case 'updown down':
                  if (pageY > innerHeight) {
                    updownElem.className = 'updown up';
                  }
                  break;
            }
        });


    });

    