'use strict';
function newLetters(alphabet){
    if (alphabet.length > 3){
        for (let i = 0; i < alphabet.length; i++){
            var letter = document.createElement("a");
            letter.href = "#letter" + alphabet[i];
            //location.hash = "#letter" + alphabet[i];
            letter.className = "nav__letter";
            var textLetter = document.createTextNode(decodeURIComponent(alphabet[i]));
            letter.appendChild(textLetter);
            letters.appendChild(letter);
         }
    }  
}