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

    // Form Submission Handler
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        if (validateForm()) {
            alert('Registration Successful!');
            // In a real application, you would submit the form data to the server here.
            // form.submit(); 
        }
    });

    const setError = (element, message) => {
        element.classList.add('error');
        const errorDisplay = element.closest('.form-group, .input-with-button, .phone-group').nextElementSibling;
        errorDisplay.innerText = message;
        // Specific handling for checkboxes
        if(element.type === 'checkbox') {
            document.getElementById(`${element.id}-error`).innerText = message;
        }
    }

    const setSuccess = (element) => {
        element.classList.remove('error');
         const errorDisplay = element.closest('.form-group, .input-with-button, .phone-group').nextElementSibling;
        errorDisplay.innerText = '';
        // Specific handling for checkboxes
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

        // Clear previous errors
        document.querySelectorAll('.error').forEach(el => el.classList.remove('error'));
        document.querySelectorAll('.error-message').forEach(el => el.innerText = '');

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