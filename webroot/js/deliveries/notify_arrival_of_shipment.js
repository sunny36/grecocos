$(document).ready(function() {
    $('.send_email').click(function() {
        var delivery_id = $(this).
            parent().
            parent().
            children().
            first()[0].innerHTML;
        delivery_id = delivery_id.replace(/(&nbsp;)*/g,"");
        $.post('/index.php/coordinator/deliveries/notify_arrival_of_shipment',
               {send_email: "true", id: delivery_id}); 
        return false; 
    });
});
