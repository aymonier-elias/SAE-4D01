let lang = localStorage.getItem("lang") || "fr";
let translations = {};

// charger le json
fetch("translations.json")
  .then(response => response.json())
  .then(data => {
    translations = data;
    updateTexts();
    updateFlag();
  });

// récupérer un texte dans le json
function getTranslation(path) {
  return path
    .split(".")
    .reduce((obj, key) => obj[key], translations)[lang];
}

// mettre à jour tous les textes
function updateTexts() {
  document.querySelectorAll("[data-i18n]").forEach(el => {
    const key = el.dataset.i18n;
    el.textContent = getTranslation(key);
  });
}

// changer la langue
function setLang(newLang) {
  lang = newLang;
  localStorage.setItem("lang", newLang);
  updateTexts();
  updateFlag();
}

// changer le drapeau du bouton
function updateFlag() {
  const flag = document.querySelector(".btn_langue img");
  if (flag) {
    flag.src = `img/svg/${lang}.svg`;
  }
}

// clic sur les options de langue
document.querySelectorAll("[data-lang]").forEach(btn => {
  btn.addEventListener("click", () => {
    setLang(btn.dataset.lang);
  });
});