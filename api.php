<?php

$apiUrl = 'https://api.affectlac.com//api/annonces/annonces_by_categorie';
$categoryId = '1';

$requestData = [
    'categorie' => $categoryId,
    'limit' => 10
];

$jsonData = json_encode($requestData);

$curl = curl_init($apiUrl);

curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);
curl_setopt($curl, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'X-Api-Key: ' . $apiKey
]);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($curl);

if (curl_errno($curl)) {
    echo "Erreur cURL: " . curl_error($curl);
    exit;
}

curl_close($curl);

$responseData = json_decode($response, true);

if ($responseData['success']) {
    echo "Annonces par catégorie récupérées avec succès !\n";
    print_r($responseData['data']);
} else {
    echo "Erreur lors de la récupération des annonces: " . $responseData['error'];
}
