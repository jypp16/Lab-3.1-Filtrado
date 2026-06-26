<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datos en PHP</title>
</head>
<body>
    <h1><?php echo $data["titulo"]; ?></h1>
    <h2><?php echo $data["subtitulo"]; ?></h2>
    <p>Parametros:</p>
    <pre>
        <?php
            print_r($data);
        ?>
    </pre>
</body>
</html>