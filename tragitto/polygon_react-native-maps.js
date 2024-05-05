import React from 'react'; // Importa React
import { Polygon } from 'react-native-maps'; // Importa il componente Polygon

// Funzione per rendere i poligoni
const renderPolygons = () => {
    const zone = require("./padova_zone_dott.json")
    return zone.data.geofencing_zones.features.map((zone, index) => {
        let color = "black"; // Colore predefinito

        // Controlla le regole per dott_scooter
        zone.properties.rules.forEach((rule) => {
            if (rule.vehicle_type_id.includes("dott_scooter")) {

                if (!rule.ride_allowed && !rule.station_parking && !rule.ride_through_allowed) {
                    color = "red";
                }
/*
                if (rule.ride_allowed) {
                    color = "green";
                } else if (!rule.ride_allowed) {
                    color = "red";
                }
                
                if (rule.ride_through_allowed) {
                    color = "blue";
                } else if (!rule.ride_through_allowed) {
                    color = "yellow";
                } else if (rule.parking_allowed) {
                    color = "purple";
                } else if (!rule.parking_allowed) {
                    color = "orange";
                }*/
            }
        });

        // Estrai le coordinate per il poligono
        let coordinates = zone.geometry.coordinates[0][0].map((point) => ({
            latitude: point[1],
            longitude: point[0],
        }));

        // Ritorna il componente Polygon
        return (
            <Polygon
                key={index}
                coordinates={coordinates}
                strokeColor="white"
                fillColor={color}
                strokeWidth={1}
            />
        );
    });
};



export default renderPolygons;
