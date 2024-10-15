import $ from "https://cdn.jsdelivr.net/npm/jquery@3.7.1/+esm";
import "https://cdn.jsdelivr.net/npm/jcanvas@23.0.0/+esm";

$(function () {
  const canvasPath = $("#roverCanvas");

  const canvasPathWidth = canvasPath.width();
  const canvasPathHeight = canvasPath.height();

  let minLat = 0;
  let maxLat = 0;
  let minLon = 0;
  let maxLon = 0;

  function scaleCoordinates(lon, lat) {
    const x = ((lon - minLon) / (maxLon - minLon)) * canvasPathWidth;
    const y =
      canvasPathHeight -
      ((lat - minLat) / (maxLat - minLat)) * canvasPathHeight;
    return [x, y];
  }

  async function makeCanvas() {
    const response = await fetch(
      "../../pages/missions/curiosity_waypoints.json"
    );
    const paths = await response.json();

    /* Obtener la latitud y longitud menor y mayor */
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

    let [startX, startY] = scaleCoordinates(paths[0].lon, paths[0].lat);

    const line = {
      strokeStyle: "#ff9a47",
      strokeWidth: 1.5,
      x1: startX,
      y1: startY,
    };

    paths.forEach((sol, index) => {
      const [endX, endY] = scaleCoordinates(sol.lon, sol.lat);
      line["x" + (index + 2)] = endX;
      line["y" + (index + 2)] = endY;
    });

    canvasPath.drawLine(line);
  }

  makeCanvas();
});
