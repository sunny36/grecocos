$(document).ready(function(){
  var lastsel2;
  jQuery("#list4").jqGrid({
    url: '/grecocos/supplier/orders/index',
  	datatype: "xml",
     	colNames:['Order Id','Delivery Date', 'Customer', 'Packed', 'Amount', 'Actions'],
     	colModel:[
        
     		{name:'id',index:'id', width:100, sorttype:"int", editable: false},
     		{name:'delivery_date',index:'delivery_date', editable: false},
     		{name:'customer',index:'customer', editable: false},
     		{name:'status',index:'status', width:50, editable: true, edittype:"checkbox",editoptions: {value:"Yes:No"}},
     		{name:'amount',index:'amount', width:80, editable: false},
     		{name:'act',index:'act', width:140,sortable:false}
     		
     	],
     	rowNum:10,
     	rowList:[10,20,30],
     	pager: jQuery('#pager1'),
     	sortname: 'id',
    sortorder: "desc",
    gridComplete: function(){
     var ids = jQuery("#list4").jqGrid('getDataIDs');
     for(var i=0;i < ids.length;i++){
       var cl = ids[i];
       be = "<input class='ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all' type='button' value='Edit'  />"; 
       jQuery("#list4").jqGrid('setRowData',ids[i],{act:be});
     } 
    },       
    editurl: '/grecocos/supplier/orders/edit',
    caption:"Orders",
    onSelectRow: function(ids) {
      if(ids == null) {
        ids = 0; 
        if(jQuery("#list4_d").jqGrid('getGridParam','records') > 0) {
          jQuery("#list4_d").jqGrid('setGridParam',{
            url:"/grecocos/supplier/orders/view/"+ids,
            editurl:"/grecocos/supplier/orders/edit/"+ids,
            page:1});
          jQuery("#list4_d").jqGrid('setCaption',"Order Detail: "+ids)
          .trigger('reloadGrid');
        }
      } else {
        jQuery("#list4_d").jqGrid('setGridParam',{
          url:"/grecocos/supplier/orders/view/"+ids,
          editurl:"/grecocos/supplier/orders/edit/"+ids,
          page:1});
        jQuery("#list4_d").jqGrid('setCaption',"Order Detail: "+ids)
        .trigger('reloadGrid');	
      }
    }
  }).navGrid('#pager1',{edit:false,add:false,del:false});	
  
  jQuery('#list4_d').jqGrid({
    height: 100, 
    url: '/grecocos/supplier/orders/view/0', 
    colNames: ['No','Qty','Product', 'Action'], 
    colModel:[
       		{name:'num',index:'num', width:55},
       		{name:'qty',index:'qty', width:80, align:"right", editable: true},
       		{name:'product',index:'product', width:200},
       		{name:'act',index:'act', width:140,sortable:false}
       	],
    gridComplete: function(){
     var ids = jQuery("#list4_d").jqGrid('getDataIDs');
     for(var i=0;i < ids.length;i++){
       var cl = ids[i];
       be = "<input class='ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all' type='button' value='Edit'  />"; 
       jQuery("#list4_d").jqGrid('setRowData',ids[i],{act:be});
     } 
    },       
    editurl: '/grecocos/supplier/orders/edit',
    rowNum: 5,
    rowList:[5,10,20],
    pager: '#pager10_d',
    sortname: 'product',
    viewrecords: true,
    sortorder: "asc",
    caption:"Order Details"
  }).navGrid('#pager1_d',{add:false,edit:false,del:false});
  
  $('.ui-button').live('click', function() {
    var $button = $(this);
    console.log($button);
    if($button.attr("value") == "Edit") {
      $button.hide();
      $("#" + getTableId($button)).editRow($button.parent().parent().attr('id'));
      s = "<input class='ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all' type='button' value='Save' />";
      c = "<input class='ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all' type='button' value='Cancel' />";
      $button.after(c).after(s);
    }
    if($button.attr("value") == "Save") {
      $button.hide(); 
      $button.next().hide();
      $("#" + getTableId($button)).saveRow($button.parent().parent().attr('id'));
      $button.prev().show();
      $button.next().remove(); 
      $button.remove();
    }
    if($button.attr("value") == "Cancel") {
      $button.hide();
      $button.prev().hide();
      $("#" + getTableId($button)).restoreRow($button.parent().parent().attr('id'));
      $button.prev().prev().show();
      $button.prev().remove();
      $button.remove();
    }
    
  });
  
  function getTableId($button) {
    return $button.closest('table').attr('id');
  }
});

