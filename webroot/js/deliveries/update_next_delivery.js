var msg = "";
var ajaxImage = '<img src="/img/ajax-loader.gif" alt="Loading" id="ajax_loader"/>';

var pathname = "/index.php/deliveries"

$(document).ready(function(){
  $('.next_delivery').click(function(){
    var $next_delivery_checkbox = $(this);
    var id = $next_delivery_checkbox.parent().children()[1].value;
    console.log(id);
    console.log($('input:checkbox:checked'));
    if($next_delivery_checkbox.is(':checked')) {
      msg = "Are you sure you want to change the next delivery date?";
      custom_confirm_yes_no(msg, 
        function() {change_next_delivery($next_delivery_checkbox, id, "1");},
        function() {$next_delivery_checkbox.attr("checked", false);});
    }
    //next_delivery is unchecked
    else {
    }
  });
  
  function change_next_delivery($checkbox, delivery_id, is_next_delivery) {
    $checkbox.hide();
    $checkbox.after(ajaxImage);
    $.post(pathname + '/edit/' + delivery_id, {next_delivery: is_next_delivery}, function() {
      $('input:checkbox:checked').each(function() {
        var id = $(this).parent().children()[1].value; 
        if (id != delivery_id) {
          $(this).attr("checked", false);
        }
      });
      $('#ajax_loader').remove();
      $checkbox.fadeIn();
      
    });
    return; 
  } 
  
}); 