document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    if (!form) return;

    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');
    const addressInput = document.getElementById('address');
    const phoneInput = document.getElementById('phone');

    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirm_password');

    const currentPasswordInput = document.getElementById('current_password');
    const newPasswordInput = document.getElementById('new_password');

    function getErrorElement(input) {
        if (!input) return null;

        let errorElement = input.nextElementSibling;

        if (
            !errorElement ||
            !errorElement.classList.contains('error')
        ) {
            errorElement = document.createElement('div');
            errorElement.className = 'error';
            input.insertAdjacentElement('afterend', errorElement);
        }

        return errorElement;
    }

    function showError(input, message) {
        const errorElement = getErrorElement(input);
        if (!errorElement) return;

        errorElement.textContent = message;

        input.classList.remove('valid');
        input.classList.add('invalid');
    }


    function showValid(input) {
        const errorElement = getErrorElement(input);
        if (!errorElement) return;

        errorElement.textContent = '';

        input.classList.remove('invalid');
        input.classList.add('valid');
    }

    function resetValidation() {
        const inputs = form.querySelectorAll('input');

        inputs.forEach(function (input) {
            input.classList.remove('valid', 'invalid');

            const errorElement = input.parentElement.querySelector('.error');
            if (errorElement) {
                errorElement.textContent = '';
            }
        });
    }

    function isValidEmail(email) {
        return email.includes('@') && email.includes('.');
    }


    form.addEventListener('submit', function (event) {
        let isFormValid = true;

        resetValidation();

        if (nameInput && nameInput.value.trim() === '') {
            showError(nameInput, 'Name is required.');
            isFormValid = false;
        } else if (nameInput) {
            showValid(nameInput);
        }

        if (emailInput && emailInput.value.trim() === '') {
            showError(emailInput, 'Email is required.');
            isFormValid = false;
        } else if (
            emailInput &&
            !isValidEmail(emailInput.value.trim())
        ) {
            showError(emailInput, 'Please enter a valid email address.');
            isFormValid = false;
        } else if (emailInput) {
            showValid(emailInput);
        }

        if (addressInput && addressInput.value.trim() === '') {
            showError(addressInput, 'Address is required.');
            isFormValid = false;
        } else if (addressInput) {
            showValid(addressInput);
        }

        if (phoneInput && phoneInput.value.trim() === '') {
            showError(phoneInput, 'Phone number is required.');
            isFormValid = false;
        } else if (phoneInput && !/^[0-9]+$/.test(phoneInput.value.trim())) {
            showError(phoneInput, 'Phone number must contain only digits and may start with +.');
            isFormValid = false;
        } else if (phoneInput) {
            showValid(phoneInput);
        }

        //reg form
        if (passwordInput) {
            if (passwordInput.value === '') {
                showError(passwordInput, 'Password is required.');
                isFormValid = false;
            } else if (passwordInput.value.length < 8) {
                showError(
                    passwordInput,
                    'Password must be at least 8 characters.'
                );
                isFormValid = false;
            } else {
                showValid(passwordInput);
            }

            if (
                confirmPasswordInput &&
                confirmPasswordInput.value === ''
            ) {
                showError(
                    confirmPasswordInput,
                    'Confirm password is required.'
                );
                isFormValid = false;
            } else if (
                confirmPasswordInput &&
                passwordInput.value !== confirmPasswordInput.value
            ) {
                showError(
                    confirmPasswordInput,
                    'Passwords do not match.'
                );
                isFormValid = false;
            } else if (confirmPasswordInput) {
                showValid(confirmPasswordInput);
            }
        }

        //profile pass
        if (currentPasswordInput && newPasswordInput && confirmPasswordInput && (currentPasswordInput.value !== '' ||
            newPasswordInput.value !== '' ||
            confirmPasswordInput.value !== '')
        ) {
            if (currentPasswordInput.value === '') {
                showError( currentPasswordInput, 'Current password is required.' );
                isFormValid = false;
            } else {
                showValid(currentPasswordInput);
            }

            if (newPasswordInput.value === '') {
                showError( newPasswordInput, 'New password is required.');
                isFormValid = false;
            } else if (newPasswordInput.value.length < 6) {
                showError( newPasswordInput, 'New password must be at least 6 characters.');
                isFormValid = false;
            } else {
                showValid(newPasswordInput);
            }

            if (confirmPasswordInput.value === '') {
                showError(
                    confirmPasswordInput,
                    'Confirm password is required.'
                );
                isFormValid = false;
            } else if (newPasswordInput.value !== confirmPasswordInput.value) {
                showError(confirmPasswordInput, 'Passwords do not match.');
                isFormValid = false;
            } else {
                showValid(confirmPasswordInput);
            }
        }

        if (!isFormValid) {
            event.preventDefault();
        }
    });
});