<div id="map" class="w-full h-64 rounded-lg"></div>

<script async defer
        src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap">
</script>

<script>
    function initMap() {
        const lat = {{ $coordinates['lat'] ?? 19.432608 }};
        const lng = {{ $coordinates['lng'] ?? -99.133209 }};

        const map = new google.maps.Map(document.getElementById('map'), {
            center: { lat, lng },
            zoom: 10
        });

        new google.maps.Marker({
            position: { lat, lng },
            map: map
        });
    }
</script>
