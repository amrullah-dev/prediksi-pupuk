/* =====================================================
                    LOGIN.JS
===================================================== */

document.addEventListener("DOMContentLoaded", () => {

    /* ==========================================
            AUTO FOCUS EMAIL
    ========================================== */

    const emailInput = document.querySelector('input[type="email"]');

    if (emailInput) {

        emailInput.focus();

    }

    /* ==========================================
            SHOW / HIDE PASSWORD
    ========================================== */

    const togglePassword = document.querySelector(".toggle-password");

    const passwordInput = document.querySelector('input[type="password"]');

    if (togglePassword && passwordInput) {

        togglePassword.addEventListener("click", () => {

            const icon = togglePassword.querySelector("i");

            if (passwordInput.type === "password") {

                passwordInput.type = "text";

                icon.classList.remove("fa-eye");

                icon.classList.add("fa-eye-slash");

            } else {

                passwordInput.type = "password";

                icon.classList.remove("fa-eye-slash");

                icon.classList.add("fa-eye");

            }

        });

    }

    /* ==========================================
            LOGIN BUTTON LOADING
    ========================================== */

    const form = document.querySelector("form");

    const loginButton = document.querySelector(".login-btn");

    if (form && loginButton) {

        form.addEventListener("submit", function (e) {

            const email = emailInput.value.trim();

            const password = passwordInput.value.trim();

            /* ======================
                VALIDASI
            ======================= */

            if (email === "" || password === "") {

                e.preventDefault();

                alert("Email dan Password wajib diisi.");

                return;

            }

            /* ======================
                LOADING
            ======================= */

            loginButton.classList.add("loading");

            loginButton.disabled = true;

            loginButton.innerHTML = `

                <i class="fa-solid fa-spinner fa-spin"></i>

                Sedang Masuk...

            `;

        });

    }

});