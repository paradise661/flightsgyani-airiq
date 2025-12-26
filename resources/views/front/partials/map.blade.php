<script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
<script>
    // var map;
    // function initMap() {
    //     map = new google.maps.Marker(document.getElementById('map'), {
    //         position: {lat: 27.710313, lng: 85.313031},
    //         map: map
    //     });
    //
    // }

    function initMap() {
        var myLatLng = {lat: 27.7110613, lng: 85.3150899};

        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 16,
            center: myLatLng
        });

        var marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            title: 'Flights Gyani Pvt. Ltd.'
        });
    }
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAhvyGCRCkTlvboC92nONMJ0dS38tevYUc&callback=initMap" async
        defer></script>
