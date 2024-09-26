const orbitalCanvas = document.getElementById("orbitalCanvas");
const orbitalCtx = orbitalCanvas.getContext("2d");

orbitalCanvas.width = orbitalCanvas.clientWidth;
orbitalCanvas.height = orbitalCanvas.clientHeight;
const orbitalCanvasWidth = orbitalCanvas.width;
const orbitalCanvasHeight = orbitalCanvas.height;

var computedStyle = getComputedStyle(orbitalCanvas);
let accentColor = computedStyle.getPropertyValue("--accent-color");
let fontColor = computedStyle.getPropertyValue("--font-color");
let backgroundColor = computedStyle.getPropertyValue("--background-color");

const planetImg = new Image();
planetImg.src = "../../images/Missions/Logos/mars.svg";

const satelliteImg = new Image();
satelliteImg.src = "../../images/Missions/Icons/Satellite.svg";

const planet = { x: orbitalCanvasWidth/2, y: orbitalCanvasHeight/2, radius: orbitalCanvasWidth / 10 };
const satellite = { radius: 10, distance: orbitalCanvasWidth / 6 };
let angle = 0;
let isHovered = false;
let isOrbitHovered = false;
const orbitWidth = 10;

function drawPlanet() {
  orbitalCtx.drawImage(
    planetImg,
    planet.x - planet.radius,
    planet.y - planet.radius,
    planet.radius * 2,
    planet.radius * 3
  );
}

function drawSatellite() {
  let x = planet.x + satellite.distance * Math.cos(angle);
  let y = planet.y + satellite.distance * Math.sin(angle);

  orbitalCtx.filter = computedStyle.getPropertyValue("--filter-img");
  // Dibuja el satélite
  orbitalCtx.drawImage(
    satelliteImg,
    x - satellite.radius,
    y - satellite.radius,
    satellite.radius * 2,
    satellite.radius * 2
  );
  orbitalCtx.filter = "none";

  // Muestra el texto al lado del satélite si está hoverado
  if (isHovered || isOrbitHovered) {
    orbitalCtx.font = "16px sans-serif";
    const text = "Órbita: 100 km";
    const textWidth = orbitalCtx.measureText(text).width;
    const textHeight = 20;

    orbitalCtx.fillStyle = accentColor;

    orbitalCtx.roundRect(
      x + 15 - 5,
      y - textHeight - 10,
      textWidth + 10,
      textHeight + 10,
      5
    );

    orbitalCtx.fillStyle = backgroundColor;
    orbitalCtx.fillText(text, x + 15, y - 15);
  }
}

function drawOrbit() {
  orbitalCtx.strokeStyle = fontColor;
  orbitalCtx.lineWidth = 2;
  orbitalCtx.beginPath();
  orbitalCtx.arc(planet.x, planet.y, satellite.distance, 0, 2 * Math.PI);
  orbitalCtx.stroke();

  if (isHovered || isOrbitHovered) {
    let endOrbit = satellite.distance - 2;
    orbitalCtx.globalAlpha = 0.5;
    orbitalCtx.beginPath();
    orbitalCtx.fillStyle = accentColor;
    orbitalCtx.arc(planet.x, planet.y, endOrbit, 0, 2 * Math.PI);
    orbitalCtx.fill();
    orbitalCtx.globalAlpha = 1;
  }
}

function updateData() {
  orbitalCanvas.width = orbitalCanvas.clientWidth;
  orbitalCanvas.height = orbitalCanvas.clientHeight;
  planet.x = orbitalCanvas.width/2;
  planet.y = orbitalCanvas.height/2;
  let newRadiusPlanet = orbitalCanvas.width / 10;
  planet.radius = newRadiusPlanet;
  satellite.distance = orbitalCanvas.width / 6;
  accentColor = computedStyle.getPropertyValue("--accent-color");
  fontColor = computedStyle.getPropertyValue("--font-color");
  backgroundColor = computedStyle.getPropertyValue("--background-color");
}
function animate() {
  orbitalCtx.clearRect(0, 0, orbitalCanvas.width, orbitalCanvas.height);
  updateData();
  drawOrbit();
  drawPlanet();
  drawSatellite();
  angle += 0.01;
  requestAnimationFrame(animate);
}

orbitalCanvas.addEventListener("mousemove", (event) => {
  const rect = orbitalCanvas.getBoundingClientRect();
  const mouseX = event.clientX - rect.left;
  const mouseY = event.clientY - rect.top;

  const satX = planet.x + satellite.distance * Math.cos(angle);
  const satY = planet.y + satellite.distance * Math.sin(angle);

  // Verifica si el mouse está sobre el satélite
  isHovered = Math.hypot(mouseX - satX, mouseY - satY) < satellite.radius;

  // Verifica si el mouse está sobre la órbita
  const distToOrbit = Math.abs(
    Math.hypot(mouseX - planet.x, mouseY - planet.y) - satellite.distance
  );
  isOrbitHovered = distToOrbit < orbitWidth;
});

// En caso de sacar el mouse antes de que se actualice el canvas
orbitalCanvas.addEventListener("mouseout", (event) => {
  isOrbitHovered = false;
})

CanvasRenderingContext2D.prototype.roundRect = function (
  x,
  y,
  width,
  height,
  radius
) {
  this.beginPath();
  this.moveTo(x + radius, y);
  this.lineTo(x + width - radius, y);
  this.quadraticCurveTo(x + width, y, x + width, y + radius);
  this.lineTo(x + width, y + height - radius);
  this.quadraticCurveTo(x + width, y + height, x + width - radius, y + height);
  this.lineTo(x + radius, y + height);
  this.quadraticCurveTo(x, y + height, x, y + height - radius);
  this.lineTo(x, y + radius);
  this.quadraticCurveTo(x, y, x + radius, y);
  this.closePath();
  this.fill();
};

planetImg.onload = satelliteImg.onload = animate;
