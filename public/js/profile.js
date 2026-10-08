/* ==========================================
        SHOW / HIDE PASSWORD
========================================== */

document.addEventListener("DOMContentLoaded", () => {

    const buttons = document.querySelectorAll(".toggle-password");

    buttons.forEach(button => {

        button.addEventListener("click", () => {

            const target = document.getElementById(button.dataset.target);

            const icon = button.querySelector("i");

            if (target.type === "password") {

                target.type = "text";

                icon.classList.remove("fa-eye");

                icon.classList.add("fa-eye-slash");

            } else {

                target.type = "password";

                icon.classList.remove("fa-eye-slash");

                icon.classList.add("fa-eye");

            }

        });

    });

});