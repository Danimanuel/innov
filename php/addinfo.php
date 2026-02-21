<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>informações adicionais</title>
    <link rel="stylesheet" href="../estilo/addifo.css">
</head>
<body>
    <div class="layout">
        <div class="inform">
            <h2>additional information</h2>
            <p>Preencha as informações acadêmicas abaixo:</p>

            <?php
            $id_usuario = $_GET['id_usuario'];

            ?>
            <form action="saved_addinfo.php" method="post">
                <fieldset>
                    <legend>informações acádemicas</legend>
                    <input type="hidden" name="id_usuario" value="<?php echo $id_usuario; ?>">
                    <label for="curso">Curso:</label><br>
                    <input type="text" id="curso" name="curso" required> <br>   
                    <label for="camp">Área de estudo:</label><br>
                    <input type="text" id="camp" name="camp" required><br>
                    <label for="want">O que queres ser no futuro:</label><br>
                    <input type="text" id="want" name="want" required placeholder="Que profissional desejas ser"><br>
                    <label for="level">Nível académico:</label><br>
                    <input type="text" name="leve" id="level" required><br>
                   <button type="submit">Enviar</button>
                </fieldset>
            </form>
        </div>
    </div>
</body>
</html>