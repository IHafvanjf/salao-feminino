document.addEventListener("DOMContentLoaded", function () {
    const forms = {
        login: document.querySelector(".login-form"),
        signup: document.querySelector(".signup-form"),
        forgotPassword: document.querySelector(".forgot-password-form"),
        newPassword: document.querySelector(".new-password-form")
    };

    function showForm(formName) {
        Object.values(forms).forEach(form => form.classList.remove("active"));
        forms[formName].classList.add("active");
    }

    document.querySelector(".go-to-signup").addEventListener("click", function (event) {
        event.preventDefault();
        showForm("signup");
    });

    document.querySelector(".go-to-forgot-password").addEventListener("click", function (event) {
        event.preventDefault();
        showForm("forgotPassword");
    });

    document.querySelectorAll(".go-to-login").forEach(link => {
        link.addEventListener("click", function (event) {
            event.preventDefault();
            showForm("login");
        });
    });

    showForm("login"); // Começa com o login visível
});
