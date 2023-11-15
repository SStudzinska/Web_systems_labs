const images = ['images/athens1.png', 'images/athens2.png', 'images/athens3.png', 'images/theatre.jpg'];

function showImage(currentImageIndex) {
    const imageElement = document.getElementById('image');
    imageElement.src = images[currentImageIndex];
}

function getAnswer(question) {
    let questionElement = document.getElementById(question);
    if (!questionElement) {
        questionElement = document.querySelector(`input[name="${question}"]`);
    }

    if (questionElement.type === 'radio') {
        const checkedAnswer = document.querySelector(`input[name="${questionElement.name}"]:checked`);
        return checkedAnswer ? checkedAnswer.value : null;
    }
    if (questionElement.type === 'checkbox') {
        return Array.from(document.querySelectorAll(`input[name="${question}"]:checked`))
            .map(checkbox => checkbox.value);
    } else {
        return questionElement.value;
    }
}

function arrayAnswerCorrect(a, b) {
    return JSON.stringify(a.sort()) === JSON.stringify(b.sort());
}

function calculateScore(correctAnswers) {
    const questions = Object.keys(correctAnswers);
    let score = 0;

    let i = 0;
    do {
        const question = questions[i];
        const answer = getAnswer(question);
        if (!answer) {
            i++;
            continue;
        }
        if (Array.isArray(correctAnswers[question])) {
            const arrayAnswer = Array.isArray(answer) ? answer
                .map(str => str.toLowerCase()) : [answer.toLowerCase()];
            if (arrayAnswerCorrect(arrayAnswer, correctAnswers[question])) {
                score++;
            }
        } else if (answer.toLowerCase() === correctAnswers[question]) {
            score++;
        }
        i++;
    } while (i < questions.length);
    window.alert(`Your score is: ${score} out of ${questions.length}`);
}

function openFavoriteWebsite() {
    const favoriteWebsite = document.getElementById('favorite-website').value;
    if (favoriteWebsite)
        window.open(favoriteWebsite);
}

const backgroundColorChanger = document.getElementById('background-color-changer');
const textColorChanger = document.getElementById('text-color-changer');
const fontFamilyChanger = document.getElementById('font-family-changer');

function changeBackgroundColor() {
    document.body.style.setProperty('background-color', backgroundColorChanger.value, 'important')
}

function changeTextColor() {
    document.body.style.setProperty('color', textColorChanger.value, 'important')
}

function changeFontFamily() {
    const elements = document.querySelectorAll('*');

    let i = 0;
    while (i < elements.length) {
        elements[i].style.setProperty('font-family', fontFamilyChanger.value, 'important');
        i++;
    }
}