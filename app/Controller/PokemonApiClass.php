<?php

namespace Controller;

class PokemonApiClass 
{
    protected $baseUrl = "https://pokeapi.co/api/v2/";
    protected $suffixUrl;

    public function checkType($typeId)
    {
        $this->suffixUrl = "type/";

        return $this->apiAccess($typeId);
    }

    public function checkPokemon($pokemonId)
    {
        $this->suffixUrl = "pokemon/";

        return $this->apiAccess($pokemonId);
    }

    private function apiAccess($id) 
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $this->baseUrl . $this->suffixUrl . $id . '/',
        ]);

        $response = curl_exec($curl);

        curl_close($curl);

        return json_decode($response);
    }
}