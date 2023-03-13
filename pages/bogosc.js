// Wait for the page to finish loading
$(document).ready(function() {
    // When any of the form elements change
    $('select, input[type=radio]').on('change', function() {
      // Get the current values of the form elements
      var selectpizza = $('#selectpizza').val();
      var radiosize = $('input[name=options-outlined]:checked').val();
      var selectcrust = $('#selectcrust').val();
      
      console.log(selectpizza);
      // Make a POST request to the PHP script, sending the form data
      $.ajax({
        url: 'select_pizza.php',
        method: 'POST',
        data: {
            selectedpizza: selectpizza,
            radiosize: radiosize,
            selectcrust: selectcrust
        },
        success: function (data, status, xhr) {
					console.log('status: ' + status);
				},
				error: function (jqXhr, textStatus, errorMessage) {
          console.log('Error: ' + errorMessage);
					}
      });
    });
});

  