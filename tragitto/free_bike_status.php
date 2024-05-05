<?php

// URL del JSON da cui ottenere i dati
$json_url = 'https://gbfs.api.ridedott.com/public/v2/padua/free_bike_status.json';

// Ottieni il contenuto JSON dall'URL
$json_data = file_get_contents($json_url);

// Decodifica il JSON
$data = json_decode($json_data, true);

// Estrai le informazioni necessarie
$bikes = $data['data']['bikes'];

// Inizializza un array per le features GeoJSON
$features = array();

// Itera attraverso le biciclette e crea le features GeoJSON
foreach ($bikes as $bike) {
    $feature = array(
        'type' => 'Feature',
        'geometry' => array(
            'type' => 'Point',
            'coordinates' => array($bike['lon'], $bike['lat'])
        ),
        'properties' => array(
            'bike_id' => $bike['bike_id'],
            'current_range_meters' => $bike['current_range_meters'],
            'is_disabled' => $bike['is_disabled'],
            'is_reserved' => $bike['is_reserved'],
            'last_reported' => $bike['last_reported'],
            'pricing_plan_id' => $bike['pricing_plan_id'],
            'rental_uris' => $bike['rental_uris'],
            'vehicle_type_id' => $bike['vehicle_type_id']
        )
    );

    // Aggiungi la feature all'array delle features
    $features[] = $feature;
}

// Crea l'array GeoJSON
$geojson = array(
    'type' => 'FeatureCollection',
    'features' => $features
);

// Converti l'array GeoJSON in formato JSON
$geojson_string = json_encode($geojson, JSON_PRETTY_PRINT);

// Salva il JSON in un file chiamato "free_bike_status.json"
file_put_contents('free_bike_status.geojson', $geojson_string);

echo 'File GeoJSON creato con successo.';
