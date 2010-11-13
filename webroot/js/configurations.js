var pathname = '/index.php/configurations';  
$(document).ready(function(){
  $('input:submit').hide();
  $('#ConfigurationClosedNo').click(function () {
    if ($(this).is(':checked')) {
      console.log("open");
      $('.closed div').append( '<img src="/img/ajax-loader.gif" alt="Loading" id="ajax_loader"/>');
      isNextDeliveryDateInFuture(function (result) {
        if (result == "yes") {
          var msg = "Do you want to inform customers by email?";
          custom_confirm_yes_no(
            msg, 
            function() { sendEmailSiteReOpen(); }, 
            function() { $('form').submit(); });
          
          return false;                        
        }
        if (result == "no") {
          $('form').before("<p class='errornote'>" + 
                           "There is no delivery date set, " + 
                            "please update next delivery date</p>");
          $('#ConfigurationClosedYes').attr('checked', true);
          $('#ajax_loader').remove();
          return false;                    
        }        
      });
    }
  });

  $('#ConfigurationClosedYes').click(function () {
    if ($(this).is(':checked')) {
      $('.closed div').append( '<img src="/img/ajax-loader.gif" alt="Loading" id="ajax_loader"/>');
      $('form').submit();
    }
  });
  
});

function isNextDeliveryDateInFuture(callback) {
  $.get(pathname + "/isnextdeliverydateinfuture", null, function (data) {
    var result = data; //yes or no
    callback(result);
  });
}

function sendEmailSiteReOpen() {
  $('#ConfigurationClosed').after('<img src="/img/ajax-loader.gif" alt="Loading" id="ajax_loader"/>');
  $.post(pathname + "/sendEmailSiteReOpen", 
         null, 
         function (data) {
           $('form').submit();
         });
  return false;
}

