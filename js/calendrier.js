// Date actuelle affichée
var currentDate = new Date();

// tableau des jours
var jours = ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche"];
var moisNoms = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"];

// Sélection du container
var container = document.querySelector(".grid-container");

function genererCalendrier(date){

    container.innerHTML = "";

    var currentMonth = date.getMonth();
    var currentYear = date.getFullYear();
    var title = document.querySelector(".nomMois");

    var premierJour = new Date(currentYear, currentMonth, 1);

    var premierJourSemaine = premierJour.getDay(); 

    for (let i = 0; i < premierJourSemaine; i++) {
        var emptyDiv = document.createElement("div");
        emptyDiv.className = "grid-item empty";
        container.appendChild(emptyDiv);
    }

    title.textContent = `${moisNoms[currentMonth]} ${currentYear}`;

    while (premierJour.getMonth() === currentMonth) {

        let nomJour = jours[premierJour.getDay()];
        let day = premierJour.getDate();
        let year = premierJour.getFullYear();

        var div = document.createElement("div");
        div.className = "grid-item";

        if (nomJour === "Samedi" || nomJour === "Dimanche") {
            div.classList.add("weekend");
        }

        div.innerHTML = `
            <div class="date">${day}</div>
        `;

        container.appendChild(div);

        // IMPORTANT
        premierJour.setDate(premierJour.getDate() + 1);
    }
}


// Boutons
var btnprec = document.querySelector(".mois-prec");
var btnsuiv = document.querySelector(".mois-suiv");

btnprec.addEventListener("click", function(){
    currentDate.setMonth(currentDate.getMonth() - 1);
    genererCalendrier(currentDate);
});

btnsuiv.addEventListener("click", function(){
    currentDate.setMonth(currentDate.getMonth() + 1);
    genererCalendrier(currentDate);
});


// Génération initiale
genererCalendrier(currentDate);





/********* HTML qui va avec **********/
//<div class="navigation-calendrier">
//        <div class="mois-prec"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg></div>
//        <span class="nomMois"></span>
//        <div class="mois-suiv"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg></div>
//    </div>  

    // <div class="week-days">
    //     <div>L</div>
    //     <div>M</div>
    //     <div>M</div>
    //     <div>J</div>
    //     <div>V</div>
    //     <div>S</div>
    //     <div>D</div>
    // </div>

    // <div class="grid-container"></div>


