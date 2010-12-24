var $dialog;
var pathname = '/index.php/orders';  
$(document).ready(function(){
  var msg = "";
  var ajaxImage = '<img src="/img/ajax-loader.gif" '+
                  'alt="Loading" id="ajax_loader"/>';

  $('.delivered').click(function(){
    var deliveredCheckbox = $(this);
    var orderId = $(this).parent().children()[1].value;
    if(deliveredCheckbox.is(':checked')) {
      $.get(pathname + '/getstatus', {id: orderId}, 
      function(status){
        if(status == "packed") {
          msg = "Are you sure you want to mark Order: " + orderId + 
                " as delivered.";
          custom_confirm_yes_no(msg, 
            function() {changeStatus(deliveredCheckbox, orderId, "delivered");},
            function() {deliveredCheckbox.attr("checked", false);});                
        }
        // status is not packed
        else {
          msg = "Supplier has not marked this order as packed";
          custom_confirm_ok(msg, 
            function() {deliveredCheckbox.attr("checked", false);})
        }
      });
    }
    //delivered is uncheck
    else {
      msg = "Are you sure you want to mark Order: " + orderId + 
            " as not delivered.";
      custom_confirm_yes_no(msg, 
        function() {changeStatus(deliveredCheckbox, orderId, "packed");},
        function() {deliveredCheckbox.attr("checked", true);});                
    }
  });
  
  function changeStatus($checkbox, orderId, orderStatus) {
    $checkbox.hide();
    $checkbox.after(ajaxImage);
    $.post(pathname + '/changeStatus', 
           {id: orderId, status: orderStatus}, function() {
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
  
  setInterval(function(){
    $("body:not(:animated)").hide("fast", function(){
        $("body").load("mark_as_delivered").show("slow");
    });//show callback
  } ,600000);//set interval
     
  
});
