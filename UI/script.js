document.addEventListener("DOMContentLoaded", function () {
    const loginBtn = document.getElementById("logInBtn");
    const usernameInput = document.getElementById("username");
    const passwordInput = document.getElementById("password");
    const togglePassword = document.getElementById("togglePassword");
    const errorMessage = document.getElementById("error-message");
    const rememberMeCheckbox = document.getElementById("rememberMe");

    // Debug test: Check if elements are found
    console.log(usernameInput, passwordInput, togglePassword);

    // Load saved username if Remember Me was checked
    if (localStorage.getItem("rememberedUsername")) {
        usernameInput.value = localStorage.getItem("rememberedUsername");
        rememberMeCheckbox.checked = true;
    }

    // ✅ Show/Hide password
    togglePassword.addEventListener("click", function () {
        const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
        passwordInput.setAttribute("type", type);
        this.classList.toggle("fa-eye-slash"); // Change icon when toggled
    });

    // ✅ Login Logic
    loginBtn.addEventListener("click", function () {
        const username = usernameInput.value.trim();
        const password = passwordInput.value.trim();

        const validUsername = "admin";
        const validPassword = "karylleB27";

        errorMessage.textContent = ""; // Clear previous error

        if (username === "" || password === "") {
            errorMessage.textContent = "Please enter both username and password.";
            return;
        }

        if (username === validUsername && password === validPassword) {
            // Save username if Remember Me checked
            if (rememberMeCheckbox.checked) {
                localStorage.setItem("rememberedUsername", username);
            } else {
                localStorage.removeItem("rememberedUsername");
            }
            window.location.href = "students/dashboard/dashboard.html"; // Redirect on success
        } else {
            errorMessage.textContent = "Invalid username or password.";
        }
    });
});
