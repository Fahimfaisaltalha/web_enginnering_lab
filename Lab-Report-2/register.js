document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('registrationForm');
    const email = document.getElementById('email');
    const emailCode = document.getElementById('email-code');
    const password = document.getElementById('password');
    const passwordConfirm = document.getElementById('password-confirm');
    const phone = document.getElementById('phone');
    const smsCode = document.getElementById('sms-code');
    const serviceAgreement = document.getElementById('service-agreement');
    const consentLetter = document.getElementById('consent-letter');
    const togglePasswordIcons = document.querySelectorAll('.toggle-password');

    // Toggle Password Visibility
    togglePasswordIcons.forEach(icon => {
        icon.addEventListener('click', function() {
            const input = this.previousElementSibling;
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
            // Toggle the icon
            this.classList.toggle('fa-eye-slash');
            this.classList.toggle('fa-eye');
        });
    });

    // Real-time validation handlers
    email.addEventListener('input', function() {
        if (email.value.trim() === '') {
            setError(email, 'Email address is required.');
        } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value.trim())) {
            setError(email, 'Please enter a valid email address.');
        } else {
            setSuccess(email);
        }
    });

    emailCode.addEventListener('input', function() {
        if (emailCode.value.trim() === '') {
            setError(emailCode, 'Email verification code is required.');
        } else {
            setSuccess(emailCode);
        }
    });

    password.addEventListener('input', function() {
        if (password.value === '') {
            setError(password, 'Password is required.');
        } else if (password.value.length < 6 || password.value.length > 20) {
            setError(password, 'Password must be 6-20 characters long.');
        } else if (!/^(?=.*[a-zA-Z])(?=.*\d)|(?=.*[a-zA-Z])(?=.*[^a-zA-Z0-9])|(?=.*\d)(?=.*[^a-zA-Z0-9])/.test(password.value)) {
            setError(password, 'Password must contain at least 2 different character types (letters, numbers, symbols).');
        } else {
            setSuccess(password);
        }
        // Also validate confirm password in real-time
        if (passwordConfirm.value !== '') {
            passwordConfirm.dispatchEvent(new Event('input'));
        }
    });

    passwordConfirm.addEventListener('input', function() {
        if (passwordConfirm.value === '') {
            setError(passwordConfirm, 'Please confirm your password.');
        } else if (password.value !== passwordConfirm.value) {
            setError(passwordConfirm, 'Passwords do not match.');
        } else {
            setSuccess(passwordConfirm);
        }
    });

    phone.addEventListener('input', function() {
        if (phone.value.trim() === '') {
            setError(phone, 'Phone number is required.');
        } else {
            setSuccess(phone);
        }
    });

    smsCode.addEventListener('input', function() {
        if (smsCode.value.trim() === '') {
            setError(smsCode, 'SMS verification code is required.');
        } else {
            setSuccess(smsCode);
        }
    });

    // Form Submission Handler
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        if (validateForm()) {
            alert('Registration Successful!');
            // form.submit();
        }
    });

    const setError = (element, message) => {
        element.classList.add('error');
        element.classList.remove('success');
        const errorDisplay = element.closest('.form-group, .input-with-button, .phone-group').nextElementSibling;
        errorDisplay.innerText = message;
        if(element.type === 'checkbox') {
            document.getElementById(`${element.id}-error`).innerText = message;
        }
    }

    const setSuccess = (element) => {
        element.classList.remove('error');
        element.classList.add('success');
        const errorDisplay = element.closest('.form-group, .input-with-button, .phone-group').nextElementSibling;
        errorDisplay.innerText = '';
        if(element.type === 'checkbox') {
            document.getElementById(`${element.id}-error`).innerText = '';
        }
    }

    const validateForm = () => {
        let isValid = true;
        const emailValue = email.value.trim();
        const emailCodeValue = emailCode.value.trim();
        const passwordValue = password.value;
        const passwordConfirmValue = passwordConfirm.value;
        const phoneValue = phone.value.trim();
        const smsCodeValue = smsCode.value.trim();

        // Validate Email
        if (emailValue === '') {
            isValid = false;
            setError(email, 'Email address is required.');
        } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailValue)) {
            isValid = false;
            setError(email, 'Please enter a valid email address.');
        } else {
            setSuccess(email);
        }

        // Validate Email Verification Code
        if (emailCodeValue === '') {
            isValid = false;
            setError(emailCode, 'Email verification code is required.');
        } else {
            setSuccess(emailCode);
        }

        // Validate Password
        if (passwordValue === '') {
            isValid = false;
            setError(password, 'Password is required.');
        } else if (passwordValue.length < 6 || passwordValue.length > 20) {
            isValid = false;
            setError(password, 'Password must be 6-20 characters long.');
        } else if (!/^(?=.*[a-zA-Z])(?=.*\d)|(?=.*[a-zA-Z])(?=.*[^a-zA-Z0-9])|(?=.*\d)(?=.*[^a-zA-Z0-9])/.test(passwordValue)) {
            isValid = false;
            setError(password, 'Password must contain at least 2 different character types (letters, numbers, symbols).');
        } else {
            setSuccess(password);
        }

        // Validate Confirm Password
        if (passwordConfirmValue === '') {
            isValid = false;
            setError(passwordConfirm, 'Please confirm your password.');
        } else if (passwordValue !== passwordConfirmValue) {
            isValid = false;
            setError(passwordConfirm, 'Passwords do not match.');
        } else {
            setSuccess(passwordConfirm);
        }

        // Validate Phone Number
        if (phoneValue === '') {
            isValid = false;
            setError(phone, 'Phone number is required.');
        } else {
            setSuccess(phone);
        }

        // Validate SMS Verification Code
        if (smsCodeValue === '') {
            isValid = false;
            setError(smsCode, 'SMS verification code is required.');
        } else {
            setSuccess(smsCode);
        }

        // Validate Checkboxes
        if (!serviceAgreement.checked) {
            isValid = false;
            setError(serviceAgreement, 'You must agree to the Service Agreement.');
        } else {
            setSuccess(serviceAgreement);
        }
        if (!consentLetter.checked) {
            isValid = false;
            setError(consentLetter, 'You must agree to the Consent Letter.');
        } else {
            setSuccess(consentLetter);
        }

        return isValid;
    };
});