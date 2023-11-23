'use strict';

document.addEventListener('DOMContentLoaded', function () {
    let isShiftPressed = false;
    let isAltPressed = false;
    let isCtrlPressed = false;
    let isKeyPressed = false;

    document.addEventListener('keydown', function (event) {
      if (event.shiftKey) {
        isShiftPressed = true;
      }
      else if(event.altKey){
        isAltPressed = true;
      }
      else if(event.ctrlKey){
        isCtrlPressed = true;
      }
      else if(event.keyCode === 90){
        isKeyPressed = true;

      }
    });

    document.addEventListener('keyup', function (event) {
        isShiftPressed = false;
        isAltPressed = false;
        isCtrlPressed = false;
        isKeyPressed = false;
    });

    window.addEventListener('keydown', function(event){
        if (isKeyPressed && isCtrlPressed){
            window.location.href = 'main.html';
        }
    });

    document.addEventListener('mouseover', function (event) {
      const hoveredElement = event.target;
      if (isShiftPressed && hoveredElement.classList.contains('zoomable')) {
        hoveredElement.classList.add('zoomed');
      } else {
        hoveredElement.classList.remove('zoomed');
      }
    });

    document.addEventListener('mousemove', function(event){
        const coordinates = document.getElementById('coordinates');
        if (isCtrlPressed){
            coordinates.textContent = `X: ${event.screenX}, Y: ${event.screenY}`;
      }
        else {
            coordinates.textContent= ``;
        }
        });

        

    let isDrawing = false;
    const drawingCanvas = document.getElementById('drawingCanvas');
    const context = drawingCanvas.getContext('2d');
    context.textBaseline = 'top';

    drawingCanvas.addEventListener('mousedown', function (event) {
        if (isAltPressed) {
          isDrawing = true;
          const canvasRect = drawingCanvas.getBoundingClientRect();
          const offsetX = event.clientX - canvasRect.left;
          const offsetY = event.clientY - canvasRect.top;
    
          context.beginPath();
          context.moveTo(offsetX, offsetY);
        }
      });

      drawingCanvas.addEventListener('mousemove', function (event) {
        if (isDrawing && isAltPressed) {
            const canvasRect = drawingCanvas.getBoundingClientRect();
            const offsetX = event.clientX - canvasRect.left;
            const offsetY = event.clientY - canvasRect.top;
      
            context.lineTo(offsetX, offsetY);
            context.stroke();
        }
      });

      drawingCanvas.addEventListener('mouseup', function () {
        if (isDrawing) {
          context.closePath();
          isDrawing = false;
        }
      });

      drawingCanvas.addEventListener('mouseout', function(){
        context.clearRect(0, 0, drawingCanvas.width, drawingCanvas.height);

      })

  });

  