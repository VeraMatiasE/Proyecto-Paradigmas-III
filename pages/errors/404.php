<?php
$title = "Error 404";

$scripts = [
    "color-switch.js",
    "errors/404-black-hole.js",
];

$styles = "error.css";

$alt_font = "https://fonts.googleapis.com/css2?family=Orbitron:wght@700&display=swap";

include_once "../../include/head.php";
?>

<body>
    <div class="error-container">
        4<span class="black-hole-container">
            <div class="black-hole"></div>
            <div class="accretion-disk" id="accretionDisk"></div>
        </span>4
    </div>
    <div class="message">La página no fue encontrada.</div>
    <a href="/" class="button-background return">Regresar al inicio</a>
</body>

</html>