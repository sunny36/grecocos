$(document).ready(function() {
  $('form')[0].reset();

  hideDeliveryDate();

  $('#OrderOrganizations').change(function() {
    var organizationId = $(this).attr('value');
    if (organizationId > 0) {
      $.blockUI();
      loadDeliveryDates(organizationId);
      $.unblockUI();
    }
  });
  
  $('#download_report').click(function() {
    var result;
    if ($('#delivery_date_span').is(':visible') == false) {
      custom_confirm_ok('Please select an outlet', function() {return false;});      
      result = false;      
    } else if ($('#OrderOrganizations').attr('value').length == 0 || 
               $('#OrderDeliveryDate').attr('value').length == 0) {
      custom_confirm_ok('Please select both an outlet and a delivery date', function() {return false;});      
      result = false;
    } else {
      result = true;
    }
    return result;
  });
});

function hideDeliveryDate () {
  $('#delivery_date_span').hide();
}

function loadDeliveryDates(organizationId) {
  $.getJSON('/index.php/supplier/deliveries/getalljson/' + organizationId, 
    function(json) {
      $('#OrderDeliveryDate').empty();
      $('#OrderDeliveryDate').append($("<option></option>").attr("value", "").text(" "));
      for(i = 0; i < json.length; i++) {
        $('#OrderDeliveryDate')
        .append($("<option></option>").attr("value",json[i]["Delivery"]["id"]).text(json[i]["Delivery"]["date"]));
      }
      $('#delivery_date_span').show();
    }
  );
}

