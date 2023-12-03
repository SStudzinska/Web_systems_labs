'use strict';

const backgroundColorChanger = document.getElementById('background-color-changer');
const textColorChanger = document.getElementById('text-color-changer');
const fontFamilyChanger = document.getElementById('font-family-changer');

function changeBackgroundColor() {
    document.body.style.setProperty('background-color', backgroundColorChanger.value, 'important');
}

function changeTextColor() {
    document.body.style.setProperty('color', textColorChanger.value, 'important');
}

function changeFontFamily() {
    const elements = document.querySelectorAll('*');

    let i = 0;
    while (i < elements.length) {
        elements[i].style.setProperty('font-family', fontFamilyChanger.value, 'important');
        i++;
    }
}