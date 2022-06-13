const compteur = document.getElementById('compteur');
const shop = document.getElementsByClassName('shop');

let compte  = 0
for (let i = 0; i < shop.length; i++) {
    shop[i].addEventListener("click",()=>{
        compte++
        compteur.style.display ="flex"
        compteur.innerHTML = compte
        localStorage.setItem("compte" , compte)
    })
    
}



let currpage = document.location.href
let lasturl = sessionStorage.getItem("last_url")

if(lasturl == null || lasturl.length === 0 || currpage !== lasturl ){
    update()
    
}else{
    update()
}

function update(params) {
    compte = localStorage.getItem("compte");
    //request
     if(compte > 0 ){
         //
         compteur.style.display = "flex";
         compteur.innerHTML = localStorage.getItem("compte");
     }else{
         compteur.style.display = "none";
     }
}