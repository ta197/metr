
var listing = document.querySelector('.listing');
listing.addEventListener('click', showPhoto);

function showPhoto(e){
    if(e.target.className === 'listing__link-inner'){
        e.preventDefault();

        var figure = document.querySelector('figure');
    
        var photoLink = e.target.getAttribute('href');
        
        var img = document.createElement('img');
            img.className = "inner-photo";
            img.setAttribute('src', photoLink);
            img.setAttribute('alt', e.target.parentNode.parentNode.firstElementChild.textContent);
        
        figure.replaceChild(img, figure.firstChild);
    }
}


