let password;
let confirmPassword;

//assign password and confirm password to a variable use to compare later
function setPassword() {
    password = document.getElementById("password-enter");
    confirmPassword = document.getElementById("confirm-password-enter");
    checkPassword();
}

//check if both password and confirm password are the same
function checkPassword() {
    if (password.value === confirmPassword.value) {
        confirmPassword.setCustomValidity("");
    }
    else {
        confirmPassword.setCustomValidity("Passwords Don't Match");
    }
}

//show and hide ABN field depends account type
function accountType() {
    let accountType = document.getElementById("account-type-enter");

    if (accountType.options[accountType.selectedIndex].value === "host") {
        document.getElementById("ABN-profile-group").style.display = "flex";
        document.getElementById("ABN-profile-group").children[1].setAttribute("required", "");
    }
    else {
        document.getElementById("ABN-profile-group").style.display = "none";
        document.getElementById("ABN-profile-group").children[1].removeAttribute("required");
    }
}

function start() {
    accountType();
}

//create a start function that always run first when web page loaded
window.onload = start();