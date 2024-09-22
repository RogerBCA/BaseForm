<?php

namespace RogerBCA\CoreForm;

use RogerBCA\CoreForm\DotEnv;
use RogerBCA\CoreForm\Database;

class Core
{
    public $cnx;

    public function loadFileEnv($path)
    {
        (new DotEnv($path))->load();
    }

    public function connectMySQL($DATABASE_NAME, $DATABASE_USER, $DATABASE_PASSWORD, $DATABASE_HOST)
    {
        new Database($DATABASE_NAME, $DATABASE_USER, $DATABASE_PASSWORD, $DATABASE_HOST);
        $this->cnx = Database::instance();
    }

    public function sendData($url, $data)
    {
        $jsonEncodedData = json_encode($data);

        $curl = curl_init();

        $opts = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $jsonEncodedData,
            CURLOPT_HTTPHEADER => ['Content-Type: application/json', 'Content-Length: ' . strlen($jsonEncodedData)],
        ];

        // Set curl options
        curl_setopt_array($curl, $opts);

        // Get the results
        curl_exec($curl);

        // Close resource
        curl_close($curl);
    }
}
