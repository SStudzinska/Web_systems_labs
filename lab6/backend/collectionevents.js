'use strict'

document.addEventListener("DOMContentLoaded", function() {
    const imagesCollection = document.images;
    const linksCollection = document.links;
    const formsCollection = document.forms;
    const anchorsCollection = document.anchors;

    let dataButton = document.getElementById('dataButton');
    dataButton.addEventListener('click', function(){
        document.getElementById('statisticsInfo').textContent = `In this website there are ${imagesCollection.length} images, ${linksCollection.length} links, ${formsCollection.length} forms and ${anchorsCollection.length} anchors.`;
    });
});