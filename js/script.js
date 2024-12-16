



// dropdown-----------
    /* Function to toggle the dropdown menu visibility */


    function toggleDropdown() {
        var dropdownMenu = document.getElementById('dropdownMenu');
        if (dropdownMenu.style.display === 'block') {
            dropdownMenu.style.display = 'none';
        } else {
            dropdownMenu.style.display = 'block';
        }
    }
    
    /* Close the dropdown if the user clicks outside of it */
    window.onclick = function(event) {
        if (!event.target.matches('.explore-dropdown')) {
            var dropdowns = document.getElementsByClassName('dropdown-menu');
            for (var i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.style.display === 'block') {
                    openDropdown.style.display = 'none';
                }
            }
        }
    }
    
    
    
    
    
    
    
    // login ffrom
    
    const signUpButton=document.getElementById('signUpButton');
    const signInButton=document.getElementById('signInButton');
    const signInForm=document.getElementById('signIn');
    const signUpForm=document.getElementById('signup');
    
    signUpButton.addEventListener('click',function(){
        signInForm.style.display="none";
        signUpForm.style.display="block";
    })
    signInButton.addEventListener('click', function(){
        signInForm.style.display="block";
        signUpForm.style.display="none";
    })
    
    
    
    // ---------------------------------------------------------------------------------------
    
    
    function toggleDropdown() {
        document.getElementById('dropdownMenu').classList.toggle('show');
    }
    
    function performSearch() {
        const searchInput = document.getElementById('searchInput').value;
        const locationInput = document.getElementById('locationInput').value;
        const bhkType = document.getElementById('bhk-type').value;
        const unfurnished = document.getElementById('unfurnished').checked;
        const semiFurnished = document.getElementById('semi-furnished').checked;
        const fullyFurnished = document.getElementById('fully-furnished').checked;
    
        // Build the search query
        let query = `search.php?search=${searchInput}&location=${locationInput}&bhk=${bhkType}&unfurnished=${unfurnished}&semiFurnished=${semiFurnished}&fullyFurnished=${fullyFurnished}`;
        
        // Redirect to the search results page
        window.location.href = query;
    }
    
    
    
    // -------------------------------------------------------------SEARCH----------------
    
    document.getElementById('search-form').addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent default form submission
    
        // Get form values
        const location = document.querySelector('input[name="location"]').value;
        const bhkType = document.getElementById('bhk-type').value;
    
        // Redirect to search results page with query parameters
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
    
    