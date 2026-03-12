(function () {
    'use strict';

    var currentDate = new Date();
    var moisNoms = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"];
    var container = document.getElementById("calendrier-grid");
    var titleEl = document.querySelector(".nomMois");
    var selectVersion = document.getElementById("select-version");
    var inputDate = document.getElementById("input-date");
    var dateChoisieAffichage = document.getElementById("date-choisie-affichage");

    if (!container || !titleEl) return;

    function getCreneauxPourVersion() {
        var idVersion = selectVersion ? selectVersion.value : "";
        if (!idVersion || !window.creneauxParVersion) return {};
        return window.creneauxParVersion[idVersion] || {};
    }

    function formatDateYMD(d) {
        var y = d.getFullYear();
        var m = String(d.getMonth() + 1).padStart(2, "0");
        var j = String(d.getDate()).padStart(2, "0");
        return y + "-" + m + "-" + j;
    }

    function getStatutDate(dateStr) {
        var creneaux = getCreneauxPourVersion();
        var heures = creneaux[dateStr];
        if (!heures || typeof heures !== "object") return "libre";
        var keys = Object.keys(heures);
        if (keys.length === 0) return "libre";
        var hasAchete = keys.some(function (h) { return heures[h] === "achete"; });
        var hasPanier = keys.some(function (h) { return heures[h] === "panier"; });
        if (hasAchete && hasPanier) return "mixte";
        if (hasAchete) return "achete";
        return "panier";
    }

    function genererCalendrier(date) {
        container.innerHTML = "";
        var currentMonth = date.getMonth();
        var currentYear = date.getFullYear();
        var premierJour = new Date(currentYear, currentMonth, 1);
        var jourSemaine = premierJour.getDay();
        var offset = jourSemaine === 0 ? 6 : jourSemaine - 1;
        var creneaux = getCreneauxPourVersion();

        titleEl.textContent = moisNoms[currentMonth] + " " + currentYear;

        for (var i = 0; i < offset; i++) {
            var emptyDiv = document.createElement("div");
            emptyDiv.className = "grid-item empty";
            container.appendChild(emptyDiv);
        }

        var jour = new Date(currentYear, currentMonth, 1);
        while (jour.getMonth() === currentMonth) {
            var div = document.createElement("div");
            div.className = "grid-item";
            var dayNum = jour.getDate();
            var dateStr = formatDateYMD(jour);
            var todayStr = formatDateYMD(new Date());
            if (dateStr < todayStr) {
                div.classList.add("passe");
            } else {
                var statut = getStatutDate(dateStr);
                div.classList.add(statut);
                div.setAttribute("data-date", dateStr);
                div.setAttribute("role", "button");
                div.setAttribute("tabindex", "0");
                div.setAttribute("aria-label", "Choisir le " + dayNum + " " + moisNoms[currentMonth]);
            }
            div.innerHTML = "<div class=\"date\">" + dayNum + "</div>";
            container.appendChild(div);
            jour.setDate(jour.getDate() + 1);
        }
    }

    function formatDateAffichage(dateStr) {
        var parts = dateStr.split("-");
        if (parts.length !== 3) return dateStr;
        return parts[2] + "/" + parts[1] + "/" + parts[0];
    }

    function onDayClick(dateStr) {
        var todayStr = formatDateYMD(new Date());
        if (dateStr < todayStr) return;
        if (inputDate) inputDate.value = dateStr;
        if (dateChoisieAffichage) dateChoisieAffichage.textContent = formatDateAffichage(dateStr);
    }

    container.addEventListener("click", function (e) {
        var cell = e.target.closest(".grid-item[data-date]");
        if (cell && cell.getAttribute("data-date")) {
            onDayClick(cell.getAttribute("data-date"));
        }
    });
    container.addEventListener("keydown", function (e) {
        if (e.key !== "Enter" && e.key !== " ") return;
        var cell = e.target.closest(".grid-item[data-date]");
        if (cell && cell.getAttribute("data-date")) {
            e.preventDefault();
            onDayClick(cell.getAttribute("data-date"));
        }
    });

    var btnPrec = document.querySelector(".mois-prec");
    var btnSuiv = document.querySelector(".mois-suiv");
    if (btnPrec) {
        btnPrec.addEventListener("click", function () {
            currentDate.setMonth(currentDate.getMonth() - 1);
            genererCalendrier(currentDate);
        });
    }
    if (btnSuiv) {
        btnSuiv.addEventListener("click", function () {
            currentDate.setMonth(currentDate.getMonth() + 1);
            genererCalendrier(currentDate);
        });
    }

    if (selectVersion) {
        selectVersion.addEventListener("change", function () {
            genererCalendrier(currentDate);
        });
    }

    genererCalendrier(currentDate);
})();
