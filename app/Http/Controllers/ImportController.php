<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    /**
     * Test importation API
     */
    public function testApi(): bool
    {
        $client = new Client();
        try {
            $res = $client->get('https://bebes-lutins.fr/api/categories');
        } catch(\Exception $e) {
            return 0;
        }

        return 1;
    }
}
