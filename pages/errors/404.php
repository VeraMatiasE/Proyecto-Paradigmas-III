<?php
// 404.php
http_response_code(404); // Establecer el código de respuesta a 404
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error 404 - No Encontrado</title>
    <link rel="stylesheet" href="styles.css"> <!-- Opcional: hoja de estilos -->
</head>

<body>
    <h1>Error 404</h1>
    <p>Lo sentimos, la página que estás buscando no existe.</p>
    <a href="/">Volver a la página principal</a>
</body>

</html>