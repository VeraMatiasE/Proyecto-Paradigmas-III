const canvas = document.getElementById("roverCanvas");
const ctx = canvas.getContext("2d");
canvas.width = canvas.clientWidth;
canvas.height = canvas.clientHeight;
const canvasWidth = canvas.width;
const canvasHeight = canvas.height;

let minLat = 0;
let maxLat = 0;
let minLon = 0;
let maxLon = 0;

function scaleCoordinates(lon, lat) {
  const x = ((lon - minLon) / (maxLon - minLon)) * canvasWidth;
  const y = canvasHeight - ((lat - minLat) / (maxLat - minLat)) * canvasHeight;
  return [x, y];
}

async function makeCanvas() {
  const response = await fetch("../../pages/missions/curiosity_waypoints.json");
  const paths = await response.json();

  /* Obtener la latitud y longitud menor y mayor*/
  minLat = paths[0].lat;
  maxLat = paths[0].lat;
  minLon = paths[0].lon;
  maxLon = paths[0].lon;

  paths.forEach((sol) => {
    if (sol.lat < minLat) minLat = sol.lat;
    if (sol.lat > maxLat) maxLat = sol.lat;
    if (sol.lon < minLon) minLon = sol.lon;
    if (sol.lon > maxLon) maxLon = sol.lon;
  });

  ctx.beginPath();
  ctx.strokeStyle = "#ff9a47";
  ctx.lineWidth = 1.5;

  let [startX, startY] = scaleCoordinates(paths[0].lon, paths[0].lat);
  ctx.moveTo(startX, startY);

  paths.forEach((sol) => {
    const [endX, endY] = scaleCoordinates(sol.lon, sol.lat);
    ctx.lineTo(endX, endY);
  });

  ctx.stroke();
}

makeCanvas();
