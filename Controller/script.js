document.addEventListener("DOMContentLoaded", function () {
    var registerForm = document.getElementById("registerForm");
    var forgotForm = document.getElementById("forgotForm");
    var changePasswordForm = document.getElementById("changePasswordForm");
    var reportItemForm = document.getElementById("reportItemForm");
    var claimForm = document.getElementById("claimForm");
    var searchForm = document.getElementById("searchForm");

    function empty(value) {
        return value.trim() === "";
    }

    function checkRequired(form) {
        var requiredFields = form.querySelectorAll("[data-required='yes']");

        for (var i = 0; i < requiredFields.length; i++) {
            if (empty(requiredFields[i].value)) {
                alert("Please fill all required fields.");
                requiredFields[i].focus();
                return false;
            }
        }

        return true;
    }

    function checkEmail(emailField) {
        var email = emailField.value.trim();

        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;

        if (!emailPattern.test(email)) {
            alert("Please enter a valid email address.");
            emailField.focus();
            return false;
        }

        return true;
    }

    function checkPasswordMatch(passwordField, confirmField) {
        var password = passwordField.value;

        if (password.length < 8) {
            alert("Password must be at least 8 characters long.");
            passwordField.focus();
            return false;
        }

        if (!/[A-Z]/.test(password)) {
            alert("Password must contain at least one uppercase letter.");
            passwordField.focus();
            return false;
        }

        if (!/[a-z]/.test(password)) {
            alert("Password must contain at least one lowercase letter.");
            passwordField.focus();
            return false;
        }

        if (!/[0-9]/.test(password)) {
            alert("Password must contain at least one number.");
            passwordField.focus();
            return false;
        }

        if (!/[!@#$%^&*(),.?":{}|<>_\-+=]/.test(password)) {
            alert("Password must contain at least one special character.");
            passwordField.focus();
            return false;
        }

        if (password !== confirmField.value) {
            alert("Passwords do not match.");
            confirmField.focus();
            return false;
        }

        return true;
    }

    function validateAccountForm(form, passwordField, confirmField) {
        if (!checkRequired(form)) {
            return false;
        }

        var emailField = form.querySelector("input[type='email']");

        if (emailField && !checkEmail(emailField)) {
            return false;
        }

        if (passwordField && confirmField) {
            if (!checkPasswordMatch(passwordField, confirmField)) {
                return false;
            }
        }

        return true;
    }

    if (registerForm) {
        registerForm.addEventListener("submit", function (event) {
            if (!validateAccountForm(
                registerForm,
                registerForm.password,
                registerForm.confirm_password
            )) {
                event.preventDefault();
            }
        });
    }

    if (forgotForm) {
        forgotForm.addEventListener("submit", function (event) {
            if (!validateAccountForm(
                forgotForm,
                forgotForm.password,
                forgotForm.confirm_password
            )) {
                event.preventDefault();
            }
        });
    }

    if (changePasswordForm) {
        changePasswordForm.addEventListener("submit", function (event) {
            if (!checkRequired(changePasswordForm)) {
                event.preventDefault();
                return;
            }

            if (!checkPasswordMatch(
                changePasswordForm.new_password,
                changePasswordForm.confirm_password
            )) {
                event.preventDefault();
            }
        });
    }

    if (reportItemForm) {
        reportItemForm.addEventListener("submit", function (event) {
            if (!checkRequired(reportItemForm)) {
                event.preventDefault();
            }
        });
    }

    if (claimForm) {
        claimForm.addEventListener("submit", function (event) {
            if (!checkRequired(claimForm)) {
                event.preventDefault();
            }
        });
    }

    if (searchForm) {
        searchForm.addEventListener("submit", function (event) {
            event.preventDefault();

            var formData = new FormData(searchForm);
            var resultBody = document.getElementById("searchResults");

            resultBody.innerHTML =
                "<tr><td colspan='7'>Searching...</td></tr>";

            fetch("../Controller/ItemController.php", {
                method: "POST",
                body: formData
            })
                .then(function (response) {
                    return response.json();
                })
                .then(function (data) {
                    resultBody.innerHTML = "";

                    if (!data.success) {
                        resultBody.innerHTML =
                            "<tr><td colspan='7'>" +
                            data.message +
                            "</td></tr>";
                        return;
                    }

                    if (data.items.length === 0) {
                        resultBody.innerHTML =
                            "<tr><td colspan='7'>No items found.</td></tr>";
                        return;
                    }

                    data.items.forEach(function (item) {
                        var row = document.createElement("tr");

                        addCell(row, item.item_name);
                        addCell(row, item.type);
                        addCell(row, item.category_name || "N/A");
                        addCell(row, item.location);
                        addCell(row, item.item_date);
                        addCell(row, item.status);
                        addCell(row, item.description);

                        resultBody.appendChild(row);
                    });
                })
                .catch(function () {
                    resultBody.innerHTML =
                        "<tr><td colspan='7'>Search failed.</td></tr>";
                });
        });
    }

    function addCell(row, text) {
        var cell = document.createElement("td");
        cell.textContent = text;
        row.appendChild(cell);
    }
});