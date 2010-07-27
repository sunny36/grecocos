var productsNum = 0;
$(document).ready(function(){
    var lastsel2;
    jQuery("#delivery_dates").jqGrid({
        url: '/index.php/supplier/orders/close_batch',
  	datatype: "xml",
     	colNames:['Delivery Date', 'Next Delivery', 'Total Orders', 
                  'Total Packed', 'Closed', 'Actions'],
     	colModel:[
     	    {name:'date',index:'date', editable: false},       		
     	    {name:'next_delivery',index:'next_delivery', 
             editable: false, formatter:'checkbox'},       		
     	    {name:'ordered',index:'ordered', editable: false, sortable: false},   
     	    {name:'packed',index:'packed', editable: false, sortable: false},     
     	    {name:'closed',index:'closed', editable: true,
             formatter:'checkbox', editable: true, edittype:"checkbox"}, 
     	    {name:'act',index:'act', width:140,sortable: false}      		
     	],
     	rowNum:10,
     	rowList:[10,20,30],
     	pager: jQuery('#delivery_dates_pager'),
     	sortname: 'next_delivery',
        rownumbers: true, 
        sortorder: "desc",
        editurl: '/index.php/supplier/deliveries/edit',
        caption: "Delivery Dates",
        gridComplete: function(){
            var ids = jQuery("#delivery_dates").jqGrid('getDataIDs');
            for(var i=0;i < ids.length;i++){
                var cl = ids[i];
                be = "<input class='delivery_dates edit ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all' type='button' value='Edit'  />"; 
                jQuery("#delivery_dates").jqGrid('setRowData',ids[i],{act:be});
            } 
        },       
        
    }).navGrid('#delivery_dates_pager',{edit:false,add:false,del:false});	
    
    //confirm if total orders != packed orders
    $('input').live('click', function() {
      if(this.id.match(/\d_closed/)){
        $closed_checkbox = $(this);
        total_orders = parseInt($(this).parent().parent().children()[3].innerHTML, 10)
        total_packed = parseInt($(this).parent().parent().children()[4].innerHTML, 10)
         if($closed_checkbox.is(':checked')) {
           if (total_orders != total_packed) {
               msg = 'All orders have not been packed. ' +
                     'Batch cannot be closed.'
               custom_confirm_ok(msg, function() {
                 $closed_checkbox.attr("checked", false);
                });
           }
         }
        }        
    });
    
    $('.delivery_dates.edit.ui-button').live('click', function() {
        var $button = $(this);
        $button.hide();
        $("#" + getTableId($button)).editRow($button.parent().parent().attr('id'));
        s = "<input class='delivery_dates save ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all' type='button' value='Save' />";
        c = "<input class='delivery_dates cancel ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all' type='button' value='Cancel' />";
        $button.after(c).after(s);
        
    });
    $('.delivery_dates.save.ui-button').live('click', function() {
      $.blockUI();
        var $button = $(this);
        $button.hide(); 
        $button.next().hide();
        $("#" + getTableId($button)).saveRow($button.parent().parent().attr('id'), '', '', '', unblock, '');
        $button.prev().show();
        $button.next().remove(); 
        $button.remove();    
    });
    
     function unblock(rowid, result) {
       $.unblockUI();    
    }
    

    $('.delivery_dates.cancel.ui-button').live('click', function() {
        var $button = $(this);
        $button.hide();
        $button.prev().hide();
        $("#" + getTableId($button)).restoreRow($button.parent().parent().attr('id'));
        $button.prev().prev().show();
        $button.prev().remove();
        $button.remove();    
    });
    
    function getTableId($button) {
        return $button.closest('table').attr('id');
    }    
});

