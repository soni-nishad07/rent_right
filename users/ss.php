<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAYZ1bbPsyJVPfvc02P7eVyOymeDJw3Lis&libraries=places"></script>

<!-- Step 2 -->
<div class="form-section" data-step="2">
    <h2>Locality Details</h2>

    <!-- Area -->
    <div class="form-control">
        <label for="area">Area:</label>
        <input type="text" id="area" name="area" placeholder="Enter Area" required>
    </div>

    <!-- City Dropdown -->
    <div class="form-control">
        <label for="city">City:</label>
        <select id="city" name="city" required>
            <option value="" disabled selected>Select City</option>
        </select>
    </div>

    <!-- State Dropdown -->
    <div class="form-control">
        <label for="state">State:</label>
        <select id="state" name="state" required>
            <option value="" disabled selected>Select State</option>
        </select>
    </div>
</div>

<script>
    function initAutocomplete() {
        // Initialize Google Places Autocomplete for Area
        const areaInput = document.getElementById('area');
        const autocomplete = new google.maps.places.Autocomplete(areaInput, {
            types: ['geocode'], // Geographical areas
            componentRestrictions: { country: 'in' } // Restrict to India
        });

        // Add listener to populate dropdowns
        autocomplete.addListener('place_changed', () => {
            const place = autocomplete.getPlace();
            if (place && place.address_components) {
                let city = '';
                let state = '';

                // Extract city and state from address components
                place.address_components.forEach((component) => {
                    const types = component.types;
                    if (types.includes('locality')) {
                        city = component.long_name; // City
                    } else if (types.includes('administrative_area_level_1')) {
                        state = component.long_name; // State
                    }
                });

                // Populate City Dropdown
                const cityDropdown = document.getElementById('city');
                cityDropdown.innerHTML = `<option value="${city}" selected>${city}</option>`;

                // Populate State Dropdown
                const stateDropdown = document.getElementById('state');
                stateDropdown.innerHTML = `<option value="${state}" selected>${state}</option>`;
            }
        });
    }

    // Load Google Places API
    google.maps.event.addDomListener(window, 'load', initAutocomplete);
</script>
