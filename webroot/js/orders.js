$(document).ready(function(){
  $('.paid').change(function(){
    if($(this).is(":checked")){
      var msg = "Are you sure you want to mark Order: " + 
            $(this).parent().children()[1].value + 
            " as paid.";
      if (!confirm(msg)){
        $(this).attr("checked", false)
        return;
      } else {
        $.post('/grecocos/admin/orders/changeStatus', 
               {id: $(this).parent().children()[1].value,
                status: "paid"});
        
      }
      
    } else {
      var msg = "Are you sure you want to mark Order: " + 
            $(this).parent().children()[1].value + 
            " as unpaid.";
      if (!confirm(msg)){
        $(this).attr("checked", true)
        return;
      } else {
        $.post('/grecocos/admin/orders/changeStatus', 
               {id: $(this).parent().children()[1].value,
                status: "entered"});
        
      }
      
    }
    
  }); 
});