'use strict'

document.addEventListener("DOMContentLoaded", function() {
    const imagesCollection = document.images;
    const linksCollection = document.links;
    const formsCollection = document.forms;
    const anchorsCollection = document.anchors;

    const first_link = linksCollection.item(0).href;
    const namedImage = document.images.namedItem("Parthenon");

    let dataButton = document.getElementById('dataButton');
    dataButton.addEventListener('click', function(){
        const statisticsInfo = document.getElementById('statisticsInfo');
        statisticsInfo.innerHTML = 
        `In this website there are ${imagesCollection.length} images, ${linksCollection.length} links, ${formsCollection.length} forms, and ${anchorsCollection.length} anchors.<br>
        First link: ${first_link}<br>
        Parthenon image found: ${namedImage ? "Found" : "Not found"}`;
    });
});
