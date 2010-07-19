$(document).ready(function(){
  jQuery('#deliveries').jqGrid({
    url: window.location.pathname, 
    height: "auto",
    width: 896,
    shrinkToFit: false,
    colNames: ['Date', 'Received', 'Refund', 'Due', 'Paid', 'Action'], 
    colModel:[
      {name:'date', index:'date', width:150, align:"left"},
      {name:'total_received', index:'total_received', width:150, align:"right"},
      {name:'total_refund', index:'total_refund', width:150, align:"right"},
      {name:'total_due', index:'total_due', width:150, align:"right"},
      {name:'paid',index:'paid', width:100, align:'center', 
 	     formatter:'checkbox', editable: true, edittype:"checkbox"},
      {name:'act',index:'act', width:140,sortable:false, search: false} 
    ],
    sortname: 'date',
   	toolbar: [true,"top"],
    headerrow: true,
    viewrecords: true,
    sortorder: "asc",
    rowNum:10,
   	rowList:[10,20,30],
   	pager: jQuery('#deliveries_pager'),
   	multiselect: true,
   	gridComplete: function(){
        var ids = jQuery("#deliveries").jqGrid('getDataIDs');
        for(var i=0;i < ids.length;i++){
            var cl = ids[i];
            be = "<input class='deliveries edit ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all' type='button' value='Edit'  />"; 
            jQuery("#deliveries").jqGrid('setRowData',ids[i],{act:be});
        } 
        
    },       
    editurl: '/index.php/coordinator/deliveries/edit',
  }).navGrid('#deliveries_pager',{edit:false,add:false,del:false});
  
  $("#t_deliveries").append("<input id='mark_as_paid' type='button' value='Mark selected rows as paid'  />");
  
  $('#mark_as_paid').live('click', function () {
    $.blockUI();
    var ids;
  	ids = jQuery("#deliveries").jqGrid('getGridParam','selarrrow');
  	if (ids.length == 0) {
  	  //No rows have been selected
  	  custom_confirm_ok("No rows have been selected.", function () { return; });
  	  return;
  	}
  	for (i = 0; i < ids.length; i++) {
  	  var paid = $($('tr#' + ids[i]).children()[5]).children().attr("value");
  	  if (paid == "1") {
  	    custom_confirm_ok("Some rows are already paid. Please change your selection", function () { return; });
  	    $.unblockUI();
  	    return; 
  	  }
  	}
  	$.post('/index.php/deliveries/is_dates_consecutive', {'ids[]': ids}, function(data) {
  	  if (data == "yes") {
        $.post('/index.php/coordinator/deliveries/edit', {'ids[]': ids, 'paid': 'Yes'}, function(data) {
          $("#deliveries").trigger("reloadGrid"); 
          $.unblockUI();
        });
  	  }
  	  if (data == "no") {
  	    $.unblockUI();
  	    custom_confirm_ok("Payments dates must be consecutive. No gaps are allowed", function() { 
  	      return; 
  	    });
  	  }
  	});  	
  });
  
  $('.deliveries.edit.ui-button').live('click', function() {
      var $button = $(this);
      $button.hide();
      $("#" + getTableId($button)).editRow($button.parent().parent().attr('id'));
      s = "<input class='deliveries save ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all' type='button' value='Save' />";
      c = "<input class='deliveries cancel ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all' type='button' value='Cancel' />";
      $button.after(c).after(s);      
  });


  $('.deliveries.save.ui-button').live('click', function() {
      var $button = $(this);
      $button.hide(); 
      $button.next().hide();
      $("#" + getTableId($button)).saveRow($button.parent().parent().attr('id'));
      $button.prev().show();
      $button.next().remove(); 
      $button.remove();    
  });

  $('.deliveries.cancel.ui-button').live('click', function() {
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
  
  jQuery("#m1").click( function() {
  	var s;
  	s = jQuery("#deliveries").jqGrid('getGridParam','selarrrow');
  	alert(s);
  });
});	

