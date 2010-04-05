$(document).ready(function(){
  var msg = "";
  var ajaxImage = '<img src="/grecocos/img/ajax-loader.gif" '+
                  'alt="Loading" id="ajax_loader"/>';
  $('.paid').click(function(){
    var $paidCheckbox = $(this);
    var orderId = $(this).parent().children()[1].value;
    if($paidCheckbox.is(':checked')) {
      msg = "Are you sure you want to mark Order: " + orderId + " as paid.";
      if(!confirm(msg)) {
        $paidCheckbox.attr("checked", false);
        return; 
      }
      else {
        changeStatus($paidCheckbox, orderId, "paid");
        return;
      }
    }
    //paid is uncheck
    else {
      $.get('/grecocos/admin/orders/getstatus', {id: orderId}, 
      function(status){
        if(status == "paid"){
          msg = "Are you sure you want to mark Order: " + orderId + " as unpaid.";
          if(!confirm(msg)) {
            $paidCheckbox.attr("checked", true);
            return; 
          }
          else {
            changeStatus($paidCheckbox, orderId, "entered");
            return;
          }
        }
        else if(status == "delivered"){
          msg = "Order is already delivered, cannot be changed to unpaid";
          alert(msg);
          $paidCheckbox.attr("checked", true);
          return;
        }
      });  
    }
  });
  
  $('.delivered').click(function(){
    var deliveredCheckbox = $(this);
    var orderId = $(this).parent().children()[1].value;
    if(deliveredCheckbox.is(':checked')) {
      $.get('/grecocos/admin/orders/getstatus', {id: orderId}, 
      function(status){
        if(status == "paid") {
          msg = "Are you sure you want to mark Order: " + orderId + 
                " as delivered.";
          if(!confirm(msg)) {
            deliveredCheckbox.attr("checked", false);
            return;
          }
          else {
            changeStatus(deliveredCheckbox, orderId, "delivered");
            return
          }
        }
        // status is not paid
        else {
          msg = "Order cannot be marked as delivered unless it's already marked as paid";
          alert(msg);
          deliveredCheckbox.attr("checked", false);
          return;
        }
      });
    }
    //delivered is uncheck
    else {
      msg = "Are you sure you want to mark Order: " + orderId + 
            " as not delivered.";
      if(!confirm(msg)) {
        deliveredCheckbox.attr("checked", true);
        return;
      }
      else {
        changeStatus(deliveredCheckbox, orderId, "paid");
        return
      }
    }
  });
  
  function changeStatus($checkbox, orderId, orderStatus) {
    $checkbox.hide();
    $checkbox.after(ajaxImage);
    $.post('/grecocos/admin/orders/changeStatus', 
           {id: orderId, status: orderStatus}, function() {
             $('#ajax_loader').remove();
             $checkbox.fadeIn();
           });               
    return; 
  }    
      
});
