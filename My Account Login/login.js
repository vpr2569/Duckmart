document.addEventListener("DOMContentLoaded", function () {

    const loginForm = document.getElementById("loginForm");

    loginForm.addEventListener("submit", function (event) {
    
        const email = document.getElementById("email").value.trim();
        const password = document.getElementById("password").value;
        const errorMessage = document.getElementById("errorMessage");

        errorMessage.textContent = "";

        if (email === "" || password === "") {
            event.preventDefault();
            errorMessage.textContent = 
            "Please enter your email and password.";
            return;
        }

        if (!email.includes("@")) {
            event.preventDefault();
            errorMessage.textContent = 
            "Please enter a valid email address.";
        } 
    });
});