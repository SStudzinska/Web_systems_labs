'use strict';

const newListElement_1 = document.createElement('li');
const newContent_1 = document.createTextNode('Alcibiades');
newListElement_1.appendChild(newContent_1);

const newListElement_2 = document.createElement('li');
const newContent_2 = document.createTextNode('Sophocles');
newListElement_2.appendChild(newContent_2);

var removedChild;
var replacedChild;
var section;

const atheniansList = document.getElementById('athenians-list').children[1];

const buttonRemove = document.getElementById('button-remove');
buttonRemove.onclick = function () {
    removedChild = atheniansList.removeChild(atheniansList.children[0]);
}

const buttonAddRemoved = document.getElementById('button-add-removed');
buttonAddRemoved.onclick = function () {
    if (removedChild != null)
        atheniansList.appendChild(removedChild);
}

const buttonInsert = document.getElementById('button-insert');
buttonInsert.onclick = function () {
    atheniansList.insertBefore(newListElement_1, atheniansList.lastChild);
}

const buttonReplace_1 = document.getElementById('button-replace-1');
buttonReplace_1.onclick = function () {
    replacedChild = atheniansList.children[4];
    atheniansList.replaceChild(newListElement_2, replacedChild);
}

const buttonReplace_2 = document.getElementById('button-replace-2');
buttonReplace_2.onclick = function () {
    if (replacedChild != null)
        atheniansList.appendChild(replacedChild);
}

const buttonRemoveSection = document.getElementById('button-remove-section');
buttonRemoveSection.onclick = function () {
    sectionParent = atheniansList.parentNode.parentNode;
    section = sectionParent.removeChild(sectionParent.children[1]);

    const buttonRestoreSection = document.createElement('button');
    buttonRestoreSection.id = 'button-restore-section';
    buttonRestoreSection.innerHTML = 'Restore section';
    const bodyMain = document.getElementById('places-list').parentNode;
    bodyMain.insertBefore(buttonRestoreSection, document.getElementById('places-list').nextSibling);

    buttonRestoreSection.onclick = function () {
        if (section != null) {
            bodyMain.insertBefore(section, document.getElementById('places-list').nextSibling);
            bodyMain.removeChild(buttonRestoreSection);
        }

    }
}
