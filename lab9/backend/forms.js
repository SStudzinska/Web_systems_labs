'use strict';

const phoneNumberInput = document.getElementById('phonenumber');
const phoneNumberHint = document.getElementById('phonenumber-hint');

if (phoneNumberInput != null) {
    phoneNumberInput.onblur = function () {
        phoneNumberHint.innerHTML = '';
    };
    
    phoneNumberInput.onfocus = function () {
        phoneNumberHint.innerHTML = 'Please enter your phone number in the format +XX XXX-XXX-XXX';
    };
}


const emailInput = document.getElementById('email');
const emailError = document.getElementById('email-error');

if (emailInput != null) {
    emailInput.onblur = function () {
        if (!emailInput.value.includes('@')) {
            emailInput.classList.add('invalid');
            emailError.innerHTML = 'Please enter a valid email address';
        }
    }
    
    emailInput.onfocus = function () {
        if (emailInput.classList.contains('invalid')) {
            emailInput.classList.remove('invalid');
            emailError.innerHTML = '';
        }
    }
}


window.onsubmit = function () {
    if (emailInput != null && emailInput.classList.contains('invalid'))
        return false;
    return window.confirm('Are you sure you want to submit provided information?');
}

window.onreset = function () {
    return window.confirm('Are you sure you want to clear the form?')
}
