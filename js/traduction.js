// traduction.js
let lang = localStorage.getItem("lang") || "fr"; // récupère la langue sauvegardée ou fr par défaut
let translations = {};

// Charger le JSON des traductions
fetch("../langues/trad.json")
  .then(res => res.json())
  .then(data => {
    translations = data;
    updateFlag();    // Met le bon drapeau au chargement
    translatePage(); // Traduit la page au chargement
  });

// Fonction pour récupérer une valeur depuis le JSON
function getValue(path) {
  try {
    const obj = path.split(".").reduce((o, key) => o[key], translations);
    return obj ? obj[lang] : null;
  } catch {
    return null;
  }
}

// Traduire la page
function translatePage() {
  document.querySelectorAll("[data-i18n]").forEach(el => {
    const key = el.dataset.i18n;
    const val = getValue(key);
    if (val) {
      el.textContent = val;
    } else {
      console.warn("clé manquante :", key);
    }
  });
}

// Mettre le bon drapeau selon la langue
function updateFlag() {
  const btnImg = document.querySelector(".btn_langue img");
  if (!btnImg) return;
  // Chemins des drapeaux
  btnImg.src = lang === "uk" ? "img/svg/uk.svg" : "img/svg/fr.svg";
}

// Changement de langue au clic sur un drapeau
document.querySelectorAll(".menu_langue img").forEach(flag => {
  flag.addEventListener("click", () => {
    lang = flag.dataset.lang; // 'fr' ou 'uk' selon le JSON
    localStorage.setItem("lang", lang); // sauvegarde la langue
    updateFlag();    // met à jour le drapeau
    translatePage(); // retraduit la page
    console.log("Langue choisie :", lang);
  });
});