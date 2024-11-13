// script.js
function initMap() {
    // Configura las opciones del mapa
    var mapOptions = {
        center: {
            lat: 40.7128,
            lng: -74.0060
        }, // Coordenadas para centrar el mapa (ejemplo: Nueva York)
        zoom: 10, // Nivel de zoom
    };

    // Crea el mapa y lo asigna al elemento con id 'map'
    var map = new google.maps.Map(document.getElementById('map'), mapOptions);
}

// Asegúrate de llamar a la función initMap una vez que la página esté completamente cargada
window.onload = initMap;
