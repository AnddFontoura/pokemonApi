<?php

namespace Controller;

use PDO;

class PokemonController extends ConnectionClass
{
    public function checkIfPokemonExists($pokemonId)
    {
        $sqlSelect = "
            SELECT 
                * 
            FROM 
                pokemon 
            WHERE 
                pokemon_id = :pokemonId 
        ";

        $query = $this->connection->prepare($sqlSelect);
        $query->bindValue(':pokemonId', $pokemonId, PDO::PARAM_INT);
        $query->execute();
        
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function insertPokemonIntoDatabase($pokemon): void
    {
        $sqlInsert = "INSERT INTO pokemon (pokemon_id, `name`, type_id) VALUES (
            :id,
            :namePokemon,
            1
        )";

        $query = $this->connection->prepare($sqlInsert);
        $query->bindValue(':id', $pokemon->id, PDO::PARAM_INT);
        $query->bindValue(':namePokemon', $pokemon->name, PDO::PARAM_STR);
        $query->execute();
    }
}