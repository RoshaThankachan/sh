function viewLocation(address) {
    // Use a geocoding API (e.g., Nominatim) to convert the address to latitude and longitude
    fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}`)
        .then(response => response.json())
        .then(data => {
            if (data.length > 0) {
                const lat = data[0].lat;
                const lon = data[0].lon;
                
                // Initialize the map and set the view to the located coordinates
                const map = L.map('map').setView([lat, lon], 13);

                // Add OpenStreetMap tiles
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19
                }).addTo(map);

                // Add a marker at the location and bind a popup with the address
                L.marker([lat, lon]).addTo(map)
                    .bindPopup(address)
                    .openPopup();
            } else {
                alert("Location could not be found.");
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert("An error occurred while finding the location.");
        });
}
