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

