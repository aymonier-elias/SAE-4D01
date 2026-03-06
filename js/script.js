// Gestion menu déroulant langue
const menuLangueBtn = document.querySelector(".btn_langue");
const menuLangue = document.querySelector(".menu_langue");
const nav = document.querySelector(".nav");

function givePosition(btn, menu) {
  if (!btn || !menu || !nav) return;
  const btnRect = btn.getBoundingClientRect();
  const navRect = nav.getBoundingClientRect();
  // Alignement horizontal uniquement (même x que le bouton)
  menu.style.left = btnRect.left - navRect.left - 10  - 1.5 + "px";
}

menuLangueBtn.addEventListener("click", () => {
  givePosition(menuLangueBtn, menuLangue);
  toggle(menuLangueBtn, menuLangue);
});

function toggle(btn, menu) {
  const isOpen = btn.ariaExpanded === "true";
  const isClosed = !isOpen;
  menu.ariaHidden = isOpen;
  btn.ariaExpanded = isClosed;
}

// Position initiale au chargement (et au redimensionnement)
givePosition(menuLangueBtn, menuLangue);
window.addEventListener("resize", () =>
  givePosition(menuLangueBtn, menuLangue),
);
