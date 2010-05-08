var productsNum = 0;
$(document).ready(function(){
  var lastsel2;
  jQuery("#delivery_dates").jqGrid({
    url: '/index.php/supplier/orders/close_batch',
  	datatype: "xml",
     	colNames:['Delivery Date', 'Next Delivery', 'Total Orders', 'Total Packed', 'Closed', 'Actions'],
     	colModel:[
     		{name:'delivery_date',index:'delivery_date', editable: false},       		
     		{name:'next_delivery',index:'next_delivery', editable: false, formatter:'checkbox'},       		
     		{name:'ordered',index:'ordered', editable: false},       		
     		{name:'packed',index:'packed', editable: false},       		
     		{name:'closed',index:'closed', editable: true, formatter:'checkbox', editable: true, edittype:"checkbox"}, 
     		{name:'act',index:'act', width:140,sortable:false}      		
     	],
     	rowNum:10,
     	rowList:[10,20,30],
     	pager: jQuery('#delivery_dates_pager'),
     	sortname: 'id',
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
      total_orders = parseInt($(this).parent().parent().children()[3].innerHTML, 10)
      total_packed = parseInt($(this).parent().parent().children()[4].innerHTML, 10)
      if (total_orders != total_packed) {
        msg = 'All orders have not been packed. Are you sure you want to close the orders for this delivery?'
      
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
    var $button = $(this);
    $button.hide(); 
    $button.next().hide();
    $("#" + getTableId($button)).saveRow($button.parent().parent().attr('id'));
    $button.prev().show();
    $button.next().remove(); 
    $button.remove();    
  });

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
  
});

