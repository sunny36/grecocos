$(document).ready(function() {
    $("#DeliveryDate").datepicker({ 
        beforeShowDay: enableOnlyTuesAndFri,
        dateFormat: 'yy-mm-dd',
        onSelect: function(dateText, inst) {
            var selectedDate = dateText.split("-"); 
            $('#DeliveryDateYear').val(selectedDate[0]); 
            $('#DeliveryDateMonth').val(selectedDate[1]); 
            $('#DeliveryDateDay').val(selectedDate[2]); 
        }
    });

    function enableOnlyTuesAndFri(date) { 
        var day = date.getDay(); 
        return [day == 2 || day == 5, ""]; 
    }
});
