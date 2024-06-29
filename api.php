<?php

$apiUrl = 'https://api.affectlac.com/api/annonces/annonces_by_categorie';
$apiKey = 'your_api_key_here'; // Replace with your actual API key
$categoryId = '1';

$requestData = [
    'categorie_id' => $categoryId,
    'limit' => 10
];

$jsonData = json_encode($requestData);

$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => $apiUrl,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => $jsonData,
    CURLOPT_HTTPHEADER => [
        'Content-Type: application/json',
    ],
]);

$response = curl_exec($curl);

if (curl_errno($curl)) {
    echo "Erreur cURL: " . curl_error($curl);
    exit;
}

curl_close($curl);

$responseData = json_decode($response, true);
var_dump($responseData);


if ($responseData && isset($responseData['success'])) {
    if ($responseData['success']) {
        echo "Annonces par catégorie récupérées avec succès !\n";
        print_r($responseData['data']);
    } else {
        echo "Erreur lors de la récupération des annonces: " ;
    }
} else {
    echo "Réponse invalide de l'API";
}
