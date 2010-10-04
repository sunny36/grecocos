var pathname = '/index.php/configurations';  
$(document).ready(function(){
  $("input[type='submit']").click(function() {
    if ($('#ConfigurationClosed').val() == "no") {
      $('#ConfigurationClosed').after('<img src="/img/ajax-loader.gif" alt="Loading" id="ajax_loader"/>');
      $.get(pathname + "/isnextdeliverydateinfuture", 
            null, 
            function(data) {
              $('#ajax_loader').remove();
              if (data == "no") {
                $('form').before("<p class='errornote'>" + 
                                 "There is no delivery date set, " + 
                                  "please update next delivery date</p>");
                $('#ConfigurationClosed').val("yes");
                return false;
              }
              if (data == "yes") {
                var msg = "Do you want to inform customers by email?";
                custom_confirm_yes_no(msg, 
                                      function() { sendEmailSiteReOpen();  },
                                      function() { $('form').submit(); });
                return false;              
              }
            });      
      return false;
    } else {
      $('form').submit();
    }
    return false;
  });
});

function sendEmailSiteReOpen() {
  $('#ConfigurationClosed').after('<img src="/img/ajax-loader.gif" alt="Loading" id="ajax_loader"/>');
  $.post(pathname + "/sendEmailSiteReOpen", 
         null, 
         function (data) {
           $('form').submit();
         });
  return false;
}

