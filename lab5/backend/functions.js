
const images = ['images/athens1.png', 'images/athens2.png', 'images/athens3.png', 'images/aztec.jpg', 'images/colosseum.jpg', 'images/theatre.jpg'];
let currentImageIndex = 0;

function showImage(index) {
    const imageElement = document.getElementById('image');
    imageElement.src = images[index];
}


window.addEventListener('keydown', (event) => {
    if (event.defaultPrevented) {
      return;
    }

    switch (event.key) {
        case 'ArrowLeft':
            currentImageIndex = (currentImageIndex - 1 + images.length) % images.length;
            showImage(currentImageIndex);
            break;
        case 'ArrowRight':
            currentImageIndex = (currentImageIndex + 1) % images.length;
            showImage(currentImageIndex);
            break;
        default:
            break;
    }
    event.preventDefault();
},
true);

showImage(currentImageIndex);