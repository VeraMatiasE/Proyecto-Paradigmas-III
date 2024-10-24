let angle = 0;
const accretionDisk = document.getElementById("accretionDisk");

function rotateGradient() {
  angle = (angle + 1) % 360;
  accretionDisk.style.background = `conic-gradient(from ${angle}deg, #ffdd00, #ffb700, #ff8000, #ff4000, #ff0000, #ff4000, #ff8000, #ffb700, #ffdd00)`;
  requestAnimationFrame(rotateGradient);
}

requestAnimationFrame(rotateGradient);
