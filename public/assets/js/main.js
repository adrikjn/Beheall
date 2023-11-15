function validateForm() {
    let password = document.getElementById("password").value;
    let confirm_password = document.getElementById("confirm_password").value;

    document.getElementById("password-error").innerText = "";
    document.getElementById("confirm-password-error").innerText = "";

    if (password.length < 12 || password.length > 30) {
        document.getElementById("password-error").innerText = "Le mot de passe doit contenir entre 12 et 30 caractères.";
        return false;
    }

    if (!password.match(/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&,.])([A-Za-z\d@$!%*#?&,.]{12,})$/)) {
        document.getElementById("password-error").innerText = "Le mot de passe doit contenir au moins 12 caractères avec au moins 1 chiffre et 1 caractère spécial.";
        return false;
    }

    if (password !== confirm_password) {
        document.getElementById("confirm-password-error").innerText = "Les mots de passe ne correspondent pas.";
        return false;
    }

    return true;
}