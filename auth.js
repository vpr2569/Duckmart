
function validateRegister() {

    const password = document.getElementById("password").value;

    const confirmPassword =
        document.getElementById("confirm_password").value;

    if (password.length < 8) {
        alert("Your password must be at least 8 characters.");
        return false;
    }

    if (password !== confirmPassword) {
        alert("Your passwords do not match.");
        return false;
    }

    return true;
}

function validateLogin() {

    const username =
        document.getElementById("username").value.trim();

    const password =
        document.getElementById("password").value;

    if (username === "" || password === "") {
        alert("Please enter your username and password.");
        return false;
    }

    return true;
}
