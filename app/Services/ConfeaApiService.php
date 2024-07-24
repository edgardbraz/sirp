<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ConfeaApiService
{
    public function getUserData($rnp)
    {
        $response = Http::get("https://hackathon.teste.confea.org.br/Profissionais/{$rnp}");
        
        if($response->successful())
            return $response->json()['entidade'];
        
        throw new \Exception('Failed to fetch data from the API');
    }
}
