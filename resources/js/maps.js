// resources/js/maps.js

document.addEventListener('DOMContentLoaded', function () {
    window.initMap = function () {
        // Obtener las coordenadas del centro del mapa
        const centerData = JSON.parse(document.getElementById('map').dataset.center);
        const lat = parseFloat(centerData.lat);
        const lng = parseFloat(centerData.lng);

        if (!isFinite(lat) || !isFinite(lng)) {
            console.error('Coordenadas inválidas para el mapa:', centerData);
            return;
        }

        const center = { lat: lat, lng: lng };

        // Crear el mapa
        const map = new google.maps.Map(document.getElementById('map'), {
            zoom: 12,
            center: center,
            mapTypeControl: false,
            streetViewControl: false
        });

        // Agregar un círculo para indicar un área aproximada (2km de radio)
        new google.maps.Circle({
            strokeColor: '#FF0000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#FF0000',
            fillOpacity: 0.35,
            map: map,
            center: center,
            radius: 2000
        });
    };
});
