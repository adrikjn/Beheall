// Fonction pour valider un formulaire de mot de passe
function validateForm() {
  // Récupérer les valeurs des champs de mot de passe
  let password = document.getElementById("password").value;
  let confirm_password = document.getElementById("confirm_password").value;

  // Réinitialiser les messages d'erreur
  document.getElementById("password-error").innerText = "";
  document.getElementById("confirm-password-error").innerText = "";

  // Vérifier la longueur du mot de passe
  if (password.length < 12 || password.length > 30) {
    document.getElementById("password-error").innerText =
      "Le mot de passe doit contenir entre 12 et 30 caractères.";
    return false;
  }

  // Vérifier la complexité du mot de passe (au moins 12 caractères, 1 chiffre, 1 caractère spécial)
  if (
    !password.match(
      /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&,.])([A-Za-z\d@$!%*#?&,.]{12,})$/
    )
  ) {
    document.getElementById("password-error").innerText =
      "Le mot de passe doit contenir au moins 12 caractères avec au moins 1 chiffre et 1 caractère spécial.";
    return false;
  }

  // Vérifier si les mots de passe correspondent
  if (password !== confirm_password) {
    document.getElementById("confirm-password-error").innerText =
      "Les mots de passe ne correspondent pas.";
    return false;
  }

  // La validation a réussi, effectuez la redirection
  window.location.href = "https://www.beheall.com/login";
  return false;
}
