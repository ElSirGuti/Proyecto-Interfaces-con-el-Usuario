var map = L.map('map').setView([51.505, -0.09], 13);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a>',
    subdomains: ['a', 'b', 'c']
}).addTo(map);

map.on('click', function(e) {
    var lat = e.latlng.lat;
    var lng = e.latlng.lng;
    var url = 'https://nominatim.openstreetmap.org/reverse?format=json&lat=' + lat + '&lon=' + lng + '&zoom=18&addressdetails=1';
    fetch(url)
        .then(response => response.json())
        .then(data => {
            var city = data.address.city;
            var state = data.address.state;
            var country = data.address.country;
            var postcode = data.address.postcode;
            var latitude = lat;
            var longitude = lng;
            var offset = Intl.DateTimeFormat().resolvedOptions().timeZone;
            var description = data.display_name;

            document.getElementById('city').value = city;
            document.getElementById('state').value = state;
            document.getElementById('country').value = country;
            document.getElementById('postcode').value = postcode;
            document.getElementById('latitude').value = latitude;
            document.getElementById('longitude').value = longitude;
            document.getElementById('offset').value = offset;
            document.getElementById('description').value = description;
        })
        .catch(error => console.error('Error:', error));
});

// Edad
var dob = document.getElementById('dob');
var age = document.getElementById('age');

dob.addEventListener('change', function() {
    var fechaNacimiento = new Date(dob.value);
    var edad = calcularEdad(fecha, Nacimiento);
    age.value = edad;
});

function calcularEdad(fechaNacimiento) {
    var fechaActual = new Date();
    var edad = fechaActual.getFullYear() - fechaNacimiento.getFullYear();
    var mes = fechaActual.getMonth() - fechaNacimiento.getMonth();
    if (mes < 0 || (mes === 0 && fechaActual.getDate() < fechaNacimiento.getDate())) {
        edad--;
    }
    return edad;
}