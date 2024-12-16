

// -----------------------------------------LOCATIONS-------------------------- 



// Initialize Google Places Autocomplete
function initAutocomplete() {
  const locationInput = document.getElementById("location-input");
  new google.maps.places.Autocomplete(locationInput);
}
// Load the autocomplete after the page loads
document.addEventListener("DOMContentLoaded", initAutocomplete);



// -----------------------------------------------------DROPDOWNS---------------------------

/* Function to toggle the dropdown menu visibility */

function toggleDropdown() {
  var dropdownMenu = document.getElementById("dropdownMenu");
  if (dropdownMenu.style.display === "block") {
    dropdownMenu.style.display = "none";
  } else {
    dropdownMenu.style.display = "block";
  }
}

/* Close the dropdown if the user clicks outside of it */
window.onclick = function (event) {
  if (!event.target.matches(".explore-dropdown")) {
    var dropdowns = document.getElementsByClassName("dropdown-menu");
    for (var i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.style.display === "block") {
        openDropdown.style.display = "none";
      }
    }
  }
};

// login ffrom

const signUpButton = document.getElementById("signUpButton");
const signInButton = document.getElementById("signInButton");
const signInForm = document.getElementById("signIn");
const signUpForm = document.getElementById("signup");

signUpButton.addEventListener("click", function () {
  signInForm.style.display = "none";
  signUpForm.style.display = "block";
});
signInButton.addEventListener("click", function () {
  signInForm.style.display = "block";
  signUpForm.style.display = "none";
});

// ---------------------------------------------------------------------------------------

function toggleDropdown() {
  document.getElementById("dropdownMenu").classList.toggle("show");
}

function performSearch() {
  const searchInput = document.getElementById("searchInput").value;
  const locationInput = document.getElementById("locationInput").value;
  const bhkType = document.getElementById("bhk-type").value;
  const unfurnished = document.getElementById("unfurnished").checked;
  const semiFurnished = document.getElementById("semi-furnished").checked;
  const fullyFurnished = document.getElementById("fully-furnished").checked;

  // Build the search query
  let query = `search.php?search=${searchInput}&location=${locationInput}&bhk=${bhkType}&unfurnished=${unfurnished}&semiFurnished=${semiFurnished}&fullyFurnished=${fullyFurnished}`;

  // Redirect to the search results page
  window.location.href = query;
}

// -------------------------------------------------------------SEARCH----------------

document.getElementById("search-form").addEventListener("submit", function (e) {
  e.preventDefault(); 

  const location = document.querySelector('input[name="location"]').value;
  const bhkType = document.getElementById("bhk-type").value;

  window.location.href = `search_results.php?location=${location}&bhkType=${bhkType}`;
});

// ----------------------------------------------------------------------------------------

$(document).ready(function () {
  // Send Search Text to the server
  $("#search").keyup(function () {
    let searchText = $(this).val();
    if (searchText != "") {
      $.ajax({
        url: "action.php",
        method: "post",
        data: {
          query: searchText,
        },
        success: function (response) {
          $("#show-list").html(response);
        },
      });
    } else {
      $("#show-list").html("");
    }
  });
  // Set searched text in input field on click of search button
  $(document).on("click", "a", function () {
    $("#search").val($(this).text());
    $("#show-list").html("");
  });
});

//------------------------------------------------------



// ============================================post popup=================



$(function () {
  $(".popup_img img").click(function () {
      let $src = $(this).attr("src");
      $(".show").fadeIn();
      $(".img-show img").attr("src", $src);
  });

  $("span.close").click(function () {
      $(".show").fadeOut();
      $('.img-show img').css({ 'width': '100%', 'height': '100%' });
  });

  $('.plus').on('click', function () {
      let imgWidth = $('.img-show img').width();
      $('.img-show img').width(imgWidth + 100);
      $('.img-show img').height('auto');
  });

  $('.minus').on('click', function () {
      let imgWidth = $('.img-show img').width();
      $('.img-show img').width(Math.max(500, imgWidth - 100));
      $('.img-show img').height('auto');
  });

  $('.reset').on('click', function () {
      $('.img-show img').css({ 'width': '100%', 'height': '100%' });
  });

  $(".img-show img").draggable({
      scroll: true,
      drag: function (e, ui) {
          let newLeft = Math.max(Math.min(ui.position.left, 0), $(".img-show").width() - $(this).width());
          let newTop = Math.max(Math.min(ui.position.top, 0), $(".img-show").height() - $(this).height());
          ui.position.left = newLeft;
          ui.position.top = newTop;
      }
  });
});
