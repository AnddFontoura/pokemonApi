<?php

use Controller\PokemonApiClass;
use Controller\PokemonController;

include_once ('vendor/autoload.php');

$pokemonClass = new PokemonController();
$pokemonApiClass = new PokemonApiClass();

?>
<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <title> Controle de Funcionários </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
</head>

<body class="container">
    <?php
    
        $pokemonValue = "";

        if (isset($_POST['pokemonId'])) {
            $pokemonValue = $_POST['pokemonId'];
        }
    ?>
    <form action="index.php" method="POST">
        <div class="alert alert-danger mt-auto">
            Pesquise o seu pokemon pelo formulário abaixo! (utilize apenas números)

            <div class="w-100 form-group">
                <input type="text" name="pokemonId" class="form-control" value="<?php echo $pokemonValue; ?>"></input>
                <input type="submit" class="btn btn-success mt-3" value="Pesquisar">
            </div>
        </div>
    </form>

        <?php
        if (isset($_POST['pokemonId'])) {
            $pokemonId = $_POST['pokemonId'];

            $resultSelect = $pokemonClass->checkIfPokemonExists($pokemonId);

            if (empty($resultSelect)) {
                $response = $pokemonApiClass->checkPokemon($pokemonId);

                $pokemonClass->insertPokemonIntoDatabase($response);
                
                $resultSelect = $pokemonClass->checkIfPokemonExists($pokemonId);
            }
            
            if ($resultSelect) {
                echo "<div class='alert alert-success mt-3'> Você pesquisou por '{$pokemonId}' </div>";

                echo "
                    <table class='table w-100'>
                        <thead>
                            <tr> 
                                <td> # </td>
                                <td> Nome </td>
                                <td> Type </td>
                            </tr>
                        </thead>

                        <tbody>
                ";

                echo "
                    <tr>
                        <td> {$resultSelect['pokemon_id']} </td>
                        <td> {$resultSelect['name']} </td>
                        <td> {$resultSelect['type_id']} </td>
                    </tr>
                ";

                echo "
                    </tbody>
                </table>
            ";
            
            //echo "<pre>";
            //var_dump($response);
            //echo "</pre>";
            } else {
                echo "
                    <div class='alert alert-warning mt-3'> Nenhum resultado encontrado para '{$pokemonId}' </div>
                ";
            }
        }
        ?>

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>

</html>