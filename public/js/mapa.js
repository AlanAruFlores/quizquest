var map = L.map('map').setView([-34.652271747172335, -58.48186301635414], 10);
var circle = L.circle([-34.652271747172335, -58.48186301635414], {
    color: 'red',
    fillColor: '#f03',
    fillOpacity: 0.5,
    radius: 5000
}).addTo(map);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  attribution: '© OpenStreetMap contributors'
}).addTo(map);


// Función para obtener ciudad y país
function getCityAndCountry(lat, lon) {
  var url = `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lon}`;
    
  if(circle)
    map.removeLayer(circle);

  circle = L.circle([lat,lon], {
    color: '#00c6fb',
    fillColor: '#00c6fb',
    fillOpacity: 0.5,
    radius: 5000
    }).addTo(map);

  fetch(url)
    .then(response => response.json())
    .then(data => {
      var city = data.address.city || data.address.town || data.address.village;
      var country = data.address.country;

      document.getElementById("pais").value= (country==undefined) ? "" : country;
      document.getElementById("ciudad").value= (city==undefined) ? "" :city;

    })
    .catch(error => console.error('Error:', error));
}

// Ejemplo de uso con coordenadas
var lat = -34.652271747172335;
var lon = -58.48186301635414;
getCityAndCountry(lat, lon);

// Evento de clic en el mapa para obtener ciudad y país
map.on('click', function(e) {
  var lat = e.latlng.lat;
  var lon = e.latlng.lng;
  getCityAndCountry(lat, lon);
});
