function myFunction() {
    var x = document.getElementById("myTopnav");
    if (x.className === "topnav") {
      x.className += " responsive";
    } else {
      x.className = "topnav";
    }
  }



  document.getElementById("navbarDropdown").addEventListener("click" , ()=>{
    document.getElementById("drop").classList.toggle("show")
})




