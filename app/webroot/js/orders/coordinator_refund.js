var $dialog;
var pathname = '/index.php/orders'; 
$(document).ready(function(){
  var msg = "";
  var ajaxImage = '<img src="/img/ajax-loader.gif" '+
                  'alt="Loading" id="ajax_loader"/>';

  $('.refund').click(function(){
    var $refundCheckbox = $(this);
    var orderId = $(this).parent().children()[1].value;
    if($refundCheckbox.is(':checked')) {
      msg = "Confirm to refund Order: " + orderId;
      custom_confirm_yes_no(msg, 
        function() {changeStatus($refundCheckbox, orderId, "yes");},
        function() {$paidCheckbox.attr("checked", false);});
    }
    else {
      $.get(pathname + '/getstatus', {id: orderId}, 
      function(status){
          msg = "Confirm to undo refund for Order: " + orderId;
          custom_confirm_yes_no(msg, 
            function() {changeStatus($refundCheckbox, orderId, "no");},
            function() {$refundCheckbox.attr("checked", true);});
      });  
    }
  });
  
  
  function changeStatus($checkbox, orderId, refundValue) {
    $checkbox.hide();
    $checkbox.after(ajaxImage);
    $.post(pathname + '/changeStatus', 
           {id: orderId, refund: refundValue}, function() {
             $('#ajax_loader').remove();
             $checkbox.fadeIn();
           });               
    return; 
  } 

  function custom_confirm_yes_no(prompt, action_yes, action_no) {
    var $dialog = $('<div></div>')
    		.html(prompt)
    		.dialog({
    			autoOpen: false,
    			title: 'Grecocos',
    			modal: true,
    			resizable: false,
    			closeOnEscape: false,
          open: function(event, ui) { $(".ui-dialog-titlebar-close").hide(); },
          width: 'auto',
          buttons: {
            'Yes': function() {
              $(this).dialog('close');
              action_yes();
              },
            No: function() {
              $(this).dialog('close');
              action_no();
              }
            }
    		});
    $dialog.dialog('open');
  }   

  function custom_confirm_ok(prompt, action) {
    var $dialog = $('<div></div>')
    		.html(prompt)
    		.dialog({
    			autoOpen: false,
    			title: 'Grecocos',
    			modal: true,
    			resizable: false,
    			closeOnEscape: false,
          open: function(event, ui) { $(".ui-dialog-titlebar-close").hide(); },
          width: 'auto',
          buttons: {
            'OK': function() {
              $(this).dialog('close');
              action();
              }
            }
    		});
    $dialog.dialog('open');
  }   
  
});
