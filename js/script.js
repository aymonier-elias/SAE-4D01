// Gestion menu déroulant langue
const body = document.querySelector("body");
const menuLangueBtn = document.querySelector(".btn_langue");
const menuLangue = document.querySelector(".menu_langue");
const nav = document.querySelector(".nav");

// Position initiale au chargement (et au redimensionnement)
function givePosition(btn, menu) {
  if (!btn || !menu || !nav) return;
  const btnRect = btn.getBoundingClientRect();
  const navRect = nav.getBoundingClientRect();
  // Alignement horizontal uniquement (même x que le bouton)
  menu.style.left = btnRect.left - navRect.left - 10 - 1.5 + "px";
}

if (menuLangueBtn && menuLangue) {
  givePosition(menuLangueBtn, menuLangue);
  window.addEventListener("resize", () =>
    givePosition(menuLangueBtn, menuLangue),
  );

  // Apparition du menu (aria-hidden="false" = visible)
  menuLangueBtn.addEventListener("click", (e) => {
    e.stopPropagation();
    givePosition(menuLangueBtn, menuLangue);
    toggle(menuLangueBtn, menuLangue);
  });

  // Fermer le menu en cliquant à l'extérieur
  document.addEventListener("click", (e) => {
    if (menuLangue.contains(e.target) || menuLangueBtn.contains(e.target)) return;
    if (menuLangue.getAttribute("aria-hidden") === "false") {
      menuLangue.setAttribute("aria-hidden", "true");
      menuLangueBtn.setAttribute("aria-expanded", "false");
    }
  });
}

function toggle(btn, menu) {
  const isOpen = btn.getAttribute("aria-expanded") === "true";
  menu.setAttribute("aria-hidden", isOpen ? "true" : "false");
  btn.setAttribute("aria-expanded", isOpen ? "false" : "true");
}

// Gestion  page connection / insription
const btnForm = document.querySelectorAll(".form_link > button");
const form = document.querySelector(".connexion_form > .form");
const formSection = document.querySelector(".connexion_form");

btnForm.forEach((btn) => {
  btn.addEventListener("click", () => {
    btnForm.forEach((btns) => {
      btns.ariaExpanded = false;
      btns.classList.remove("active");
    });
    btn.ariaExpanded = true;
    btn.classList.add("active");
  });
});

btnForm.forEach((btn) => {
  btn.addEventListener("click", () => {
    const msgError = formSection ? formSection.querySelector(".msg-error") : null;
    if (msgError) {
      msgError.remove();
    }
    if (btnForm[0].getAttribute("aria-expanded") === "true") {
      form.setAttribute("action", "index.php?action=login");
      form.innerHTML = `
      <div class="input-mail">
      <label><img src="img/svg/identification.svg" alt=""> Identifiant </label>
      <input type="email" name="email" required>
      </div>
      <div class="input-mdp">
        <label><img src="img/svg/clef.svg" alt=""> Mot de passe</label>
        <input type="password" name="mdp" required>
        </div>
      <button type="submit" class="cta">Accéder</button>`;
    } else if (btnForm[1].getAttribute("aria-expanded") === "true") {
      form.setAttribute("action", "index.php?action=inscription");
      form.innerHTML = `
      <div class="form-input_wrap">
        <div class="input-prenom">
        <label><img src="img/svg/identification.svg" alt=""> Prénom</label>
          <input type="text" name="prenom" required>
          </div>
          <div class="input-nom">
          <label><img src="img/svg/identification.svg" alt=""> Nom</label>
          <input type="text" name="nom" required>
        </div>
      </div>
      <div class="input-mail">
      <label><img src="img/svg/identification.svg" alt=""> Email</label>
      <input type="email" name="email" required>
      </div>
      <div class="form-input_wrap">
        <div class="input-mdp">
        <label><img src="img/svg/clef.svg" alt=""> Mot de passe</label>
          <input type="password" name="mdp" required>
          </div>
          <div class="input-mdp">
          <label><img src="img/svg/clef.svg" alt="">Confirmation de Mot de passe</label>
          <input type="password" name="mdp_confirmation" required>
          </div>
          </div>
          <button type="submit" class="cta">S'inscrire</button>`;
    }
  });
});
