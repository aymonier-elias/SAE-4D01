// traduction.js

const langKey = "lang";
let lang = localStorage.getItem(langKey) || "fr";
let translations = {};

// Base path du site (où se trouve index.php) pour charger langues/trad.json
const scriptTag = document.currentScript;
const basePath = scriptTag && scriptTag.src
  ? scriptTag.src.replace(/\/js\/[^/]*$/, "/")
  : (document.querySelector("base")?.href || window.location.href.replace(/[#?].*$/, "").replace(/\/[^/]*$/, "/"));

async function loadTranslations() {
  try {
    const url = basePath + "langues/trad.json";
    const res = await fetch(url);
    if (!res.ok) throw new Error("HTTP " + res.status + " " + url);
    translations = await res.json();

    updateFlag();
    translatePage();
  } catch (err) {
    console.error("Erreur chargement traductions :", err);
  }
}

// Récupérer une valeur dans le JSON
function getValue(path) {
  const obj = path.split(".").reduce((o, k) => o?.[k], translations);
  return obj?.[lang] ?? null;
}

// Traduire les éléments de la page
function translatePage() {
  document.querySelectorAll("[data-i18n]").forEach(el => {
    const val = getValue(el.dataset.i18n);
    if (val) {
      el.textContent = val;
    } else {
      console.warn("Clé manquante :", el.dataset.i18n);
    }
  });
}

// Mettre à jour le drapeau
function updateFlag() {
  const img = document.querySelector(".btn_langue img");
  if (!img) return;

  img.src = `img/svg/${lang}.svg`;
}

// Changer la langue
function changeLang(newLang) {
  lang = newLang;
  localStorage.setItem(langKey, lang);

  updateFlag();
  translatePage();
}

// Listener sur les drapeaux
document.querySelectorAll(".menu_langue img").forEach(flag => {
  flag.addEventListener("click", (e) => {
    e.stopPropagation();
    changeLang(flag.dataset.lang);
    const menu = document.querySelector(".menu_langue");
    const btn = document.querySelector(".btn_langue");
    if (menu && btn) {
      menu.setAttribute("aria-hidden", "true");
      btn.setAttribute("aria-expanded", "false");
    }
  });
});

// Initialisation
loadTranslations();