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
    <form action="type.php" method="POST">
        <div class="alert alert-danger mt-auto">
            Pesquise o seu tipo pelo formulário abaixo! (utilize apenas números)

            <div class="w-100 form-group">
                <input type="text" name="pokemonId" class="form-control" value="<?php echo $pokemonValue; ?>"></input>
            </div>
        </div>

        <?php
        if (isset($_POST['pokemonId'])) {
            $pokemonId = $_POST['pokemonId'];

            $apiUrl = "https://pokeapi.co/api/v2/type/";


            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => $apiUrl . $pokemonId . '/',
            ]);

            $response = curl_exec($curl);

            curl_close($curl);

            $response = json_decode($response);

            //echo "<pre>";
            //var_dump($response);
            //echo "</pre>";

            if ($response) {
                
                echo "<div class='alert alert-success mt-3'> Você pesquisou por '{$pokemonId}' </div>";

                echo "
                    <table class='table w-100'>
                        <thead>
                            <tr> 
                                <td> # </td>
                                <td> Nome </td>
                            </tr>
                        </thead>

                        <tbody>
                ";

                echo "
                    <tr>
                        <td> {$response->id} </td>
                        <td> {$response->name} </td>
                    </tr>
                ";

                echo "
                    </tbody>
                </table>
            ";
            } else {
                echo "
                    <div class='alert alert-warning mt-3'> Nenhum resultado encontrado para '{$pokemonId}' </div>
                ";
            }
        }
        ?>
    </form>

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>

</html>