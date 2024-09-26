let isLogged = false;


//Nav
let openBtn = document.getElementById("nav-open")
let closeBtn = document.getElementById("nav-close")
let navWrapper = document.getElementById("nav-wrapper")
let navLatteral = document.getElementById("nav-lateral")
////

// Pages
let homePage = document.getElementById("homePage")
let microOndePage = document.getElementById("microOndePage")
let foodTruckPage = document.getElementById("foodTruckPage")
let jourPage = document.getElementById('JourPage')
let ValidationPageFT = document.getElementById('ValidationPageFT');
let confirmPageFT = document.getElementById('confirmPageFT');
let menuFoodTruck = document.getElementById('menuFoodTruck');
let toutesReservations = document.getElementById('toutesReservations');
let loginPage = document.getElementById("loginPage")
let welcomePage = document.getElementById("welcomePage")
let signPage = document.getElementById("signPage")
let foodTruckInfoPage = document.getElementById("foodTruckInfoPage")
let signPageFT = document.getElementById("signPageFT")

/////

/////////  Boutons
let microOndeBtn = document.getElementsByClassName("microOndeBtn")
let accueilBtn = document.getElementsByClassName("accueilBtn")
let foodTruckBtn = document.getElementsByClassName("foodTruckBtn")
let jourBtn = document.getElementsByClassName("jourBtn")
let hourBtn = document.getElementsByClassName("hourBtn")
let buttonValid = document.getElementById("buttonValid")
let connectUserBtn = document.getElementById("connectUserBtn")
let signUserBtn = document.getElementById("signUserBtn")
let jourBtnFT = document.getElementsByClassName("jourBtnFT")
let reserverBtn = document.getElementById("reserverBtn")
let navLinks = document.getElementsByClassName("nav-link")
let connectFTBtn = document.getElementById("connectFTBtn")
let inscriptionBtnFT = document.getElementById("inscriptionBtnFT")
let loginUserBtn = document.getElementById("loginUserBtn")
///////////


let listPages = [homePage, signPageFT,microOndePage,foodTruckInfoPage, foodTruckPage, menuFoodTruck, JourPage, ValidationPageFT, confirmPageFT,signPage, toutesReservations, loginPage, welcomePage]

let jourPrecis = document.getElementById("jourPrecis")
let jourPrecisValid = document.getElementById("jourPrecisValid")
let hourPrecisValid = document.getElementById("hourPrecisValid")
let jourConfirm = document.getElementById("jourConfirm")
let hourConfirm = document.getElementById("hourConfirm")

const openNav = () => {
    navWrapper.classList.add("active");
    navLatteral.style.left = "0";
}
const closeNav = () => {
    navWrapper.classList.remove("active");
    navLatteral.style.left = "+100%";
}
openBtn.addEventListener("click",openNav)
closeBtn.addEventListener("click", closeNav)
navWrapper.addEventListener("click", closeNav)

const openPage = (pageGarder) => {
    for(let page of listPages){
        page.style.display = 'none';
    }
    pageGarder.style.display = 'block';
}


for (let btn of microOndeBtn) {
    btn.addEventListener("click", () => openPage(microOndePage))
}

for (let btn of accueilBtn) {
    btn.addEventListener("click", () => {
        if(!isLogged){
            return
        }
        openPage(homePage)
        openBtn.style.display = "block"
})
    
}

for (let btn of foodTruckBtn) {
    btn.addEventListener("click", () => openPage(foodTruckPage))
}

let jourActif = 0
for (let btn of jourBtn) {

    btn.addEventListener("click", () => {
        openPage(JourPage)
        jourPage.querySelector('.menu').style.display = "none"})
        if(btn.id == "buttonAnnule"){
            break
        }
    btn.addEventListener("click", () => {
        jourPrecis.textContent = btn.id
        jourActif = btn.id
    
        if(menuFoodTruck.contains(btn)){
            jourPage.querySelector('.menu').textContent = btn.parentElement.id
            jourPage.querySelector('.menu').style.display = "block"
            ValidationPageFT.querySelector('.menu').textContent = btn.parentElement.id
            ValidationPageFT.querySelector('.menu').style.display = "block"
            confirmPageFT.querySelector('.menu').textContent = btn.parentElement.id
            confirmPageFT.querySelector('.menu').style.display = "block"
        }
    })
}



let hourActive = 0
for (let btn of hourBtn) {
    btn.addEventListener("click",() => {
        reserverBtn.style.display = "block"
        hourActive = btn.id
    } )
}

reserverBtn.addEventListener("click", () => {
    console.log(hourActive)
    openPage(ValidationPageFT)
    hourPrecisValid.textContent = hourActive
    jourPrecisValid.textContent = jourActif
    reserverBtn.style.display = "none"
})

buttonValid.addEventListener("click", () => {
    openPage(confirmPageFT)
    jourConfirm.textContent = jourActif
    hourConfirm.textContent = hourActive
    }
)

connectUserBtn.addEventListener("click",() => {
    openPage(loginPage)
    
})

loginUserBtn.addEventListener("click",() => {
    isLogged = true;
    openPage(homePage)
})


signUserBtn.addEventListener("click",() => openPage(signPage))
connectFTBtn.addEventListener("click",() => openPage(signPageFT))
inscriptionBtnFT.addEventListener("click",() => {
    isLogged = true;
    openPage(foodTruckInfoPage)})

for(let btn of jourBtnFT){
    btn.addEventListener("click", () => {
        openPage(menuFoodTruck)
        menuFoodTruck.querySelector(".jourPrecis").textContent = btn.id
        }
    )
}
for (let btn of navLinks) {
    btn.addEventListener("click", closeNav)
}


// Temp
/*for(let page of listPages){
    page.style.display = 'none';
}
//*/

openPage(welcomePage)


let form = document.getElementById('inscriptionForm')
let formCommande = document.getElementById('commandeForm')
let getOrderCount = document.getElementById('getOrderCount')


form.addEventListener('submit', function(e) {
    e.preventDefault(); // Empêche la soumission normale du formulaire
    var formData = new FormData(this);
    fetch('inscription.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // L'utilisateur est maintenant "connécté"
            isLogged = true;
            // On ouvre la page d'accueil
            openPage(homePage)
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        alert("Adresse mail déjà existante");
        console.error('Erreur:', error);
    });
});

formCommande.addEventListener('submit', function(e) {
    e.preventDefault(); // Empêche la soumission normale du formulaire
    var formData2 = new FormData(this);
    fetch('commande.php', {
        method: 'POST',
        body: formData2
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            //alert(data.message);
            alert("Votre commande est validée")
             // Ou utilisez une autre méthode pour afficher le message
            // Vous pouvez aussi mettre à jour le DOM ici si nécessaire
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        alert("Votre commande a un problème");
        console.error('Erreur:', error);
    });
});

getOrderCount.addEventListener('submit', function(e) {
    e.preventDefault(); // Empêche la soumission normale du formulaire
    var formData = new FormData(this);
    fetch('get_order_count.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            //alert(data.message);
            document.getElementById("nbCommande").textContent = data.count
             // Ou utilisez une autre méthode pour afficher le message
            // Vous pouvez aussi mettre à jour le DOM ici si nécessaire
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        alert("Votre commande a un problème");
        console.error('Erreur:', error);
    });
});