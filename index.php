<?php

    $host = "localhost";
    $dbName = "pokemon";
    $dbPort = "3306";
    $dbUser = "root";
    $dbPassword = "";

    $strConn = "mysql:host=" . $host 
                . ";dbname=" . $dbName 
                . ";port=" . $dbPort;

    $pdoOptions = [
        PDO::ATTR_PERSISTENT => TRUE,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
    ];
    
    $connection = new PDO($strConn, $dbUser, $dbPassword, $pdoOptions);
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

            $sqlSelect = "SELECT * FROM pokemon WHERE pokemon_id = $pokemonId or `name` = '$pokemonId' ";
            $query = $connection->prepare($sqlSelect);
            $query->execute();
            $resultSelect = $query->fetch(PDO::FETCH_ASSOC);

            if (empty($resultSelect)) {
                $apiUrl = "https://pokeapi.co/api/v2/pokemon/";

                $curl = curl_init();
                curl_setopt_array($curl, [
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_URL => $apiUrl . $pokemonId . '/',
                ]);
    
                $response = curl_exec($curl);
    
                curl_close($curl);
    
                $response = json_decode($response);

                $sqlInsert = "INSERT INTO pokemon (pokemon_id, `name`, type_id) VALUES (
                    " . $response->id .",
                    '". $response->name ."',
                    1
                )";

                $query = $connection->prepare($sqlInsert);
                $query->execute();

                $sqlSelect = "SELECT * FROM pokemon WHERE pokemon_id = $pokemonId or `name` = '$pokemonId' ";
                $query = $connection->prepare($sqlSelect);
                $query->execute();
                $resultSelect = $query->fetch(PDO::FETCH_ASSOC);
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