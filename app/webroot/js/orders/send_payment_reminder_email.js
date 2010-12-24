$(document).ready(function() {
    $('#send').click(function() {
        $.blockUI();
        $.post('/index.php/coordinator/orders/send_payment_reminder_emails', function(data) {
          $.unblockUI();
          $('#content-main').before("<div class=\"system-message\"><p class=\"description\">Emails has been sent.</p></div>");
          
        }); 
        return false; 
    });
});
