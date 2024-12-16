
// let currentStep = 1;

// function navigateSteps(step) {
//     if (step === 1 && !$("#propertyForm").valid()) return;

//     $(".form-section").removeClass("active");
//     currentStep += step;
//     $(`.form-section[data-step="${currentStep}"]`).addClass("active");

//     updateStepIndicator();

//     $("#prevBtn").prop("disabled", currentStep === 1);
//     $("#nextBtn").toggle(currentStep < $(".form-section").length);
//     $("#submitBtn").toggle(currentStep === $(".form-section").length);
// }


// function updateStepIndicator() {
//     $(".step").removeClass("active");
//     $(`.step[data-step="${currentStep}"]`).addClass("active");
// }



let currentStep = 1;

function navigateSteps(step) {
    // Validate the form before moving forward
    if (step === 1 && !$("#propertyForm").valid()) return;

    $(".form-section").removeClass("active");
    currentStep += step;
    $(`.form-section[data-step="${currentStep}"]`).addClass("active");

    updateStepIndicator();

    $("#prevBtn").prop("disabled", currentStep === 1);
    $("#nextBtn").toggle(currentStep < $(".form-section").length);
    $("#submitBtn").toggle(currentStep === $(".form-section").length);
}

function updateStepIndicator() {
    $(".step").removeClass("active");
    $(`.step[data-step="${currentStep}"]`).addClass("active");
}

$(document).ready(function () {
    // Prevent form submission on "Enter" and navigate to the next step instead
    $("#propertyForm").on("keydown", function (event) {
        if (event.key === "Enter") {
            event.preventDefault();
            if (currentStep < $(".form-section").length) {
                navigateSteps(1); // Move to the next step
            }
        }
    });

    // File upload validation
    $('#file_upload').on('change', function () {
        const files = $(this)[0].files;
        const count = files.length;
        $('#file_count').text(count + ' files selected');

        let validFiles = true;
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const fileType = file.type;
            if (!fileType.match('image/png') && !fileType.match('image/jpg') && !fileType.match('image/jpeg') && !fileType.match('image/webp')) {
                validFiles = false;
                break;
            }
        }

        if (!validFiles) {
            alert('Please select only PNG, JPG, JPEG, or WEBP images.');
            $('#file_upload').val('');
            $('#file_count').text('No files selected');
        }
    });

});



// ----------------image uploads----------

$(document).ready(function () {
    // Display file count for multiple uploads
    $('#file_upload').on('change', function () {
        const files = $(this)[0].files;
        const count = files.length;
        $('#file_count').text(count + ' files selected');

        // Check file types to ensure only allowed formats are selected
        let validFiles = true;
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const fileType = file.type;
            if (!fileType.match('image/png') && !fileType.match('image/jpg') && !fileType.match('image/jpeg') && !fileType.match('image/webp')) {
                validFiles = false;
                break;
            }
        }

        // Show an alert or handle invalid file type
        if (!validFiles) {
            alert('Please select only PNG, JPG, JPEG, or WEBP images.');
            $('#file_upload').val(''); // Clear file input
            $('#file_count').text('No files selected'); // Reset the count
        }
    });
});





           // Availability button selection
           document.querySelectorAll('.availability-btn').forEach(function (button) {
            button.addEventListener('click', function () {
                document.getElementById('availability').value = this.getAttribute('data-value');
                document.querySelectorAll('.availability-btn').forEach(function (btn) {
                    btn.classList.remove('selected');
                });
                this.classList.add('selected');
            });
        });




// -----------------------------Initialize form validation

$("#propertyForm").validate({
    errorClass: "error",
    rules: {
        propertyType: "required",
        build_up_area: {
            required: true,
            number: true
        },
        city: "required",
        rent: {
            required: true,
            number: true
        },
        owner_name: "required",
        contact_number: {
            required: true,
            minlength: 10
        },
        // property_image: "required",
        ownership_proof: "required",
        availability: "required", 
        start_time: {
            required: function () {
                return $('#available_all').prop('checked') === false;
                 // Only require start time if 'Available All Day' is not checked
            }
        },
        end_time: {
            required: function () {
                return $('#available_all').prop('checked') === false; 
                // Only require end time if 'Available All Day' is not checked
            }
        },
        'available_for[]': {
            required: true,
            minlength: 1 // At least one checkbox must be selected
        },
        // Maintenance checkbox validation
        'maintenance': {
            required: true
        },
        available_from:
        {
            required: true
        },
  
        'preferred_tenants[]': {
            required: true,
            minlength: 1 // At least one checkbox must be selected
        },
        // Furnishing dropdown validation
        furnishing: {
            required: true
        },
        // Parking dropdown validation
        parking: {
            required: true
        },
        // Property description textarea validation
        description: {
            required: true,
            minlength: 10 // Ensure some description is provided
        },
        'amenities[]': {
            required: true,
            minlength: 1 // At least one checkbox must be selected
        },
        water_supply: {
            required: true
        }
    },
    messages: {
        contact_number: {
            minlength: "Contact number must be at least 10 digits."
        },
        availability: {
            required: "Please select your availability."
        },
        start_time: {
            required: "Please select a start time."
        },
        end_time: {
            required: "Please select an end time."
        },
        'available_for[]': {
            required: "Please select at least one availability option."
        },
        // Maintenance checkbox error message
        'maintenance': {
            required: "Please select the maintenance option."
        },
        available_from:
        {
            required: "Please select available."
        },
            'preferred_tenants[]':
            {
                required: "Please select at least one preferred tenants.",
                minlength: "Please select at least one preferred tenants."
            },
        // Furnishing error message
        furnishing: {
            required: "Please select the furnishing option."
        },
        // Parking error message
        parking: {
            required: "Please select the parking option."
        },
        // Property description error message
        description: {
            required: "Please provide a description for the property.",
            minlength: "Description must be at least 10 characters long."
        },
        'amenities[]': {
            required: "Please select at least one amenity.",
            minlength: "Please select at least one amenity."
        },
        water_supply: {
            required: "Please select a water supply option."
        }
    }
});


// <!-- ----------------------OWNER ND BALCONYS------------ -->



// <!-- balcony and bathroom -->

document.querySelectorAll('.quantity__plus, .quantity__minus').forEach(button => {
    button.addEventListener('click', (event) => {
        const input = event.target.parentNode.querySelector('.quantity__input');
        let currentValue = parseInt(input.value) || 0;
        input.value = button.classList.contains('quantity__plus') ? currentValue + 1 : Math.max(1, currentValue - 1);
    });
});




// <!-- ---------------for owner or agent-------- -->

function toggleBhkOptions() {
    const ownerAgentSelect = document.getElementById('owner-agent-select');
    const ownerOptions = document.getElementById('owner-options');
    const agentOptions = document.getElementById('agent-options');

    if (ownerAgentSelect.value === 'Owner') {
        ownerOptions.style.display = 'block';
        agentOptions.style.display = 'none';
    } else if (ownerAgentSelect.value === 'Agent') {
        ownerOptions.style.display = 'none';
        agentOptions.style.display = 'block';
    } else {
        ownerOptions.style.display = 'none';
        agentOptions.style.display = 'none';
    }
}

// JavaScript function for form validation
function validateForm() {
    const ownerAgentSelect = document.getElementById('owner-agent-select');
    const propertyTypeSelect = document.getElementById('propertyType');
    const ownerAgentError = document.getElementById('owner-agent-error');
    const propertyTypeError = document.getElementById('property-type-error');

    let isValid = true;

    // Validate Owner or Agent selection
    if (ownerAgentSelect.value === '') {
        ownerAgentError.style.display = 'block';
        isValid = false;
    } else {
        ownerAgentError.style.display = 'none';
    }

}



// ----------------------balocy-------


// bathrooms increment and derement
document.addEventListener('DOMContentLoaded', function () {
const minus = document.querySelector('.quantity__minus');
const plus = document.querySelector('.quantity__plus');
const input = document.querySelector('.quantity__input');

minus.addEventListener('click', function (e) {
 e.preventDefault();
 let value = parseInt(input.value);
 if (value > 1) {
     value--;
     input.value = value;
 }
});

plus.addEventListener('click', function (e) {
 e.preventDefault();
 let value = parseInt(input.value);
 value++;
 input.value = value;
});
});


// balcony increment and decrement
document.addEventListener('DOMContentLoaded', function () {
const minus = document.querySelector('.quantity__minus2');
const plus = document.querySelector('.quantity__plus2');
const input = document.querySelector('.quantity__input2');

minus.addEventListener('click', function (e) {
 e.preventDefault();
 let value = parseInt(input.value);
 if (value > 1) {
     value--;
     input.value = value;
 }
});

plus.addEventListener('click', function (e) {
 e.preventDefault();
 let value = parseInt(input.value);
 value++;
 input.value = value;
});
});

