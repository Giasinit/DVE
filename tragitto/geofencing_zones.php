<?php

// URL del JSON da cui ottenere i dati del poligono
$json_url = 'https://gbfs.api.ridedott.com/public/v2/padua/geofencing_zones.json';

// Ottieni il contenuto JSON dall'URL
$json_data = file_get_contents($json_url);

// Decodifica il JSON
$data = json_decode($json_data, true);

// Estrai le features
$features = $data['data']['geofencing_zones']['features'];

// Inizializza un array per le features GeoJSON
$geojson_features = array();

// Colori per le zone
$colors = array('#FF5733', '#33FF57', '#5733FF', '#FF33E6', '#33E6FF');

// Contatore per assegnare un colore a ciascuna zona
$color_index = 0;

// Itera attraverso le features e crea le features GeoJSON
foreach ($features as $key => $feature) {
    // Aggiungi un identificatore unico a ciascuna zona
    $feature_id = 'zone_' . $key;

    // Assegna un colore a ciascuna zona
    $color = $colors[$color_index % count($colors)];
    $color_index++;

    // Aggiungi il colore alla proprietà della feature
    $feature['properties']['color'] = $color;

    // Aggiungi l'identificatore unico come proprietà
    $feature['properties']['id'] = $feature_id;

    // Aggiungi la feature all'array delle features GeoJSON
    $geojson_features[] = $feature;
}

// Crea l'array GeoJSON con le features aggiornate
$geojson = array(
    'type' => 'FeatureCollection',
    'features' => $geojson_features
);

// Converti l'array GeoJSON in formato JSON
$geojson_string = json_encode($geojson, JSON_PRETTY_PRINT);

// Salva il GeoJSON in un file locale chiamato "geofencing_zones.geojson"
file_put_contents('geofencing_zones.geojson', $geojson_string);

echo 'File GeoJSON creato con successo.';
