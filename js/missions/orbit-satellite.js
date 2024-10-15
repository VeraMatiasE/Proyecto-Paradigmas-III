import $ from "https://cdn.jsdelivr.net/npm/jquery@3.7.1/+esm";
import "https://cdn.jsdelivr.net/npm/jcanvas@23.0.0/+esm";

$(function () {
  const orbitalCanvas = $("#orbitalCanvas");
  const orbitalCanvasWidth = orbitalCanvas.width();
  const orbitalCanvasHeight = orbitalCanvas.height();

  let computedStyle = getComputedStyle(orbitalCanvas[0]);
  let accentColor = computedStyle.getPropertyValue("--accent-color");
  let fontColor = computedStyle.getPropertyValue("--font-color");
  let backgroundColor = computedStyle.getPropertyValue("--background-color");

  const planetImg = new Image();
  planetImg.src = "../../images/Missions/Logos/mars.svg";

  const satelliteImg = new Image();
  satelliteImg.src = "../../images/Missions/Icons/Satellite.svg";

  const planet = {
    x: orbitalCanvasWidth / 2,
    y: orbitalCanvasHeight / 2,
    radius: orbitalCanvasWidth / 10,
  };
  const satellite = { radius: 10, distance: orbitalCanvasWidth / 6 };
  let angle = 0;
  let isHovered = false;
  let isOrbitHovered = false;
  const orbitWidth = 10;

  // Dibujo de planeta
  function drawPlanet() {
    orbitalCanvas.drawImage({
      source: planetImg.src,
      x: planet.x,
      y: planet.y - planet.radius + planet.radius * (3 / 2),
      width: planet.radius * 2,
      height: planet.radius * 3,
    });
  }

  // Dibujo del satélite
  function drawSatellite() {
    const x = planet.x + satellite.distance * Math.cos(angle);
    const y = planet.y + satellite.distance * Math.sin(angle);

    orbitalCanvas.drawImage({
      layer: true,
      source: satelliteImg.src,
      x: x - satellite.radius,
      y: y - satellite.radius,
      width: satellite.radius * 2,
      height: satellite.radius * 2,
    });

    if (isHovered || isOrbitHovered) {
      const text = "Órbita: 100 km";
      const textHeight = 20;
      const textWidth = orbitalCanvas.measureText(text).width;

      orbitalCanvas
        .drawRect({
          layer: true,
          fillStyle: accentColor,
          x: x + 15,
          y: y - textHeight - 25,
          width: textWidth + 10,
          height: textHeight + 10,
          cornerRadius: 5,
          index: 0,
        })
        .drawText({
          layer: true,
          fillStyle: backgroundColor,
          x: x + 15,
          y: y - textHeight - 25,
          fontSize: 16,
          fontFamily: "sans-serif",
          text: text,
          name: text,
        });
    }
  }

  // Dibujo de la órbita
  function drawOrbit() {
    orbitalCanvas.drawArc({
      layer: true,
      strokeStyle: fontColor,
      strokeWidth: 2,
      x: planet.x,
      y: planet.y,
      radius: satellite.distance,
    });

    if (isHovered || isOrbitHovered) {
      let endOrbit = satellite.distance - 2;
      orbitalCanvas.drawArc({
        layer: true,
        fillStyle: accentColor,
        x: planet.x,
        y: planet.y,
        radius: endOrbit,
        opacity: 0.5,
      });
    }
  }

  // Actualizar datos del canvas
  function updateData() {
    orbitalCanvas.attr("width", orbitalCanvas.width());
    orbitalCanvas.attr("height", orbitalCanvas.height());
    planet.x = orbitalCanvas.width() / 2;
    planet.y = orbitalCanvas.height() / 2;
    planet.radius = orbitalCanvas.width() / 10;
    satellite.distance = orbitalCanvas.width() / 6;
    accentColor = computedStyle.getPropertyValue("--accent-color");
    fontColor = computedStyle.getPropertyValue("--font-color");
    backgroundColor = computedStyle.getPropertyValue("--background-color");
  }

  // Animación
  function animate() {
    orbitalCanvas.clearCanvas();
    updateData();
    drawOrbit();
    drawPlanet();
    drawSatellite();
    angle += 0.01;
    requestAnimationFrame(animate);
  }

  orbitalCanvas.mousemove(function (event) {
    const rect = orbitalCanvas[0].getBoundingClientRect();
    const mouseX = event.clientX - rect.left;
    const mouseY = event.clientY - rect.top;

    const satX = planet.x + satellite.distance * Math.cos(angle);
    const satY = planet.y + satellite.distance * Math.sin(angle);

    isHovered = Math.hypot(mouseX - satX, mouseY - satY) < satellite.radius;
    const distToOrbit = Math.abs(
      Math.hypot(mouseX - planet.x, mouseY - planet.y) - satellite.distance
    );
    isOrbitHovered = distToOrbit < orbitWidth;
  });

  orbitalCanvas.mouseout(function () {
    isOrbitHovered = false;
  });

  planetImg.onload = satelliteImg.onload = animate;
});
