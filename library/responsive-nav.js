function displayNav() {
    let x = document.getElementById("nav-bar");
    let hero = document.querySelector(".hero-text");
    if (x.className === "nav-list") {
      x.className += " responsive";
      hero.style.display = "none"
    } else {
      x.className = "nav-list";
      
      hero.style.display = "block"
    }
  }