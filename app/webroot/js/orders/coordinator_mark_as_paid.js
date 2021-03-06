var $dialog;
var pathname = '/index.php/orders'; 
$(document).ready(function(){
  var msg = "";
  var ajaxImage = '<img src="/img/ajax-loader.gif" '+
                  'alt="Loading" id="ajax_loader"/>';

  $('.paid').click(function(){
    var $paidCheckbox = $(this);
    var orderId = $(this).parent().children()[1].value;
    if($paidCheckbox.is(':checked')) {
      msg = "Are you sure you want to mark Order: " + orderId + " as paid.";
      custom_confirm_yes_no(msg, 
        function() {changeStatus($paidCheckbox, orderId, "paid");},
        function() {$paidCheckbox.attr("checked", false);});
    }
    //paid is uncheck
    else {
      $.get(pathname + '/getstatus', {id: orderId}, 
      function(status){
        if(status == "paid"){
          msg = "Are you sure you want to mark Order: " + orderId + " as unpaid.";
          custom_confirm_yes_no(msg, 
            function() {changeStatus($paidCheckbox, orderId, "entered");},
            function() {$paidCheckbox.attr("checked", true);});
        }
        if(status == "delivered"){
          msg = "Order is already delivered, cannot be changed to unpaid";
          custom_confirm_ok(msg,
            function() {$paidCheckbox.attr("checked", true);})
        }
        if(status == "packed"){
          msg = "Supplier has alread packed this order. Cannot be unpaid.";
          custom_confirm_ok(msg,
            function() {$paidCheckbox.attr("checked", true);})
        }        
      });  
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
        $("body").load("mark_as_paid").show("slow");
    });//show callback
  } ,600000);//set interval
});
