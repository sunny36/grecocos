var productsNum = 0;
$(document).ready(function(){
  var lastsel2;
  jQuery("#orders").jqGrid({
    url: '/grecocos/supplier/orders/index',
  	datatype: "xml",
     	colNames:['Order Id','Delivery Date', 'Customer', 'Packed', 'Amount', 'Actions'],
     	colModel:[
        
     		{name:'id',index:'id', width:100, sorttype:"int", editable: false},
     		{name:'delivery_date',index:'delivery_date', editable: false},
     		{name:'customer',index:'customer', editable: false},
     		{name:'status',index:'status', width:50, align:'center', formatter:'checkbox', editable: true, edittype:"checkbox",editoptions: {value:"Yes:No"}},
     		{name:'amount',index:'amount', width:80, editable: false},
     		{name:'act',index:'act', width:140,sortable:false}
     		
     	],
     	rowNum:10,
     	rowList:[10,20,30],
     	pager: jQuery('#orders_pager'),
     	sortname: 'id',
    sortorder: "desc",
    gridComplete: function(){
     var ids = jQuery("#orders").jqGrid('getDataIDs');
     for(var i=0;i < ids.length;i++){
       var cl = ids[i];
       be = "<input class='orders edit ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all' type='button' value='Edit'  />"; 
       jQuery("#orders").jqGrid('setRowData',ids[i],{act:be});
     } 
    },       
    editurl: '/grecocos/supplier/orders/edit',
    caption:"Orders",
    onSelectRow: function(ids) {
      if(ids == null) {
        ids = 0; 
        if(jQuery("#order_d").jqGrid('getGridParam','records') > 0) {
          jQuery("#order_d").jqGrid('setGridParam',{
            url:"/grecocos/supplier/orders/view/"+ids,
            editurl:"/grecocos/supplier/orders/edit/"+ids,
            page:1});
          jQuery("#order_d").jqGrid('setCaption',"Order Detail: "+ids)
          .trigger('reloadGrid');
        }
      } else {
        jQuery("#order_d").jqGrid('setGridParam',{
          url:"/grecocos/supplier/orders/view/"+ids,
          editurl:"/grecocos/supplier/orders/edit/"+ids,
          page:1});
        jQuery("#order_d").jqGrid('setCaption',"Order Detail: "+ids)
        .trigger('reloadGrid');	
      }
    }
  }).navGrid('#order_pager',{edit:false,add:false,del:false});	
  
  jQuery('#order_d').jqGrid({
    height: 100, 
    url: '/grecocos/supplier/orders/view/0', 
    colNames: ['No','Qty','Product', 'Action'], 
    colModel:[
       		{name:'num',index:'num', width:55},
       		{name:'qty',index:'qty', width:80, align:"right", 
       		 editable: true, edittype:"select", 
       		 editoptions: {value: "0:0"}
       		 },
       		{name:'product',index:'product', width:200},
       		{name:'act',index:'act', width:140,sortable:false}
       	],
    gridComplete: function(){
     var ids = jQuery("#order_d").jqGrid('getDataIDs');
     for(var i=0;i < ids.length;i++){
       var cl = ids[i];
       be = "<input class='order_d edit ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all' type='button' value='Edit'  />"; 
       jQuery("#order_d").jqGrid('setRowData',ids[i],{act:be});
     } 
    },       
    editurl: '/grecocos/supplier/orders/edit',
    rowNum: 5,
    rowList:[5,10,20],
    pager: '#order_d_pager',
    sortname: 'product',
    viewrecords: true,
    sortorder: "asc",
    caption:"Order Details"
  }).navGrid('#order_d_pager',{add:false,edit:false,del:false});
  
  $('.orders.edit.ui-button').live('click', function() {
    var $button = $(this);
    $button.hide();
    $("#" + getTableId($button)).editRow($button.parent().parent().attr('id'));
    s = "<input class='orders save ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all' type='button' value='Save' />";
    c = "<input class='orders cancel ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all' type='button' value='Cancel' />";
    $button.after(c).after(s);
    
  });

  $('.orders.save.ui-button').live('click', function() {
    var $button = $(this);
    $button.hide(); 
    $button.next().hide();
    $("#" + getTableId($button)).saveRow($button.parent().parent().attr('id'));
    $button.prev().show();
    $button.next().remove(); 
    $button.remove();    
  });

  $('.orders.cancel.ui-button').live('click', function() {
    var $button = $(this);
    $button.hide();
    $button.prev().hide();
    $("#" + getTableId($button)).restoreRow($button.parent().parent().attr('id'));
    $button.prev().prev().show();
    $button.prev().remove();
    $button.remove();    
  });
  
  $('.order_d.edit.ui-button').live('click', function() {
    var $button = $(this);
    $button.hide();
    var editurl = jQuery("#order_d").jqGrid('getGridParam','editurl');
    var orderId = editurl.match(/\d+$/);
    var productId = $button.parent().parent().attr('id'); 
    var currentQuantity = $button.parent().parent().children()[1].innerHTML
    var products = getProductsNum(orderId, productId, function(result) {
      var lineItem = eval('(' + result + ')');
      console.log(lineItem["LineItem"]);
      var quantity = parseInt(lineItem["LineItem"]["quantity"], 10);
      for (var i = 1; i <= quantity; i++ ) {
        $('#' + productId + '_qty').prepend($("<option></option>").attr("value",i).text(i));
      }
      $('#' + productId + '_qty').val(currentQuantity);
    });
    
    $("#" + getTableId($button)).editRow($button.parent().parent().attr('id'));
    s = "<input class='order_d save ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all' type='button' value='Save' />";
    c = "<input class='order_d cancel ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all' type='button' value='Cancel' />";
    $button.after(c).after(s);
    
  });
  
  $('.order_d.cancel.ui-button').live('click', function() {
    var $button = $(this);
    $button.hide();
    $button.prev().hide();
    $("#" + getTableId($button)).restoreRow($button.parent().parent().attr('id'));
    $button.prev().prev().show();
    $button.prev().remove();
    $button.remove();    
  });
  
  $('.order_d.save.ui-button').live('click', function() {
    var $button = $(this);
    $button.hide(); 
    $button.next().hide();
    $("#" + getTableId($button)).saveRow($button.parent().parent().attr('id'));
    $button.prev().show();
    $button.next().remove(); 
    $button.remove();    
  });
  
  
  var productsNum = 0;
  function getProductsNum(orderId, productId, callback) {
    var url = '/grecocos/supplier/orders/lineitem';
    $.get(url + '?order_id=' + orderId + '&product_id=' + productId, function(data) {
      callback(data);
    });

  }
  function getTableId($button) {
    return $button.closest('table').attr('id');
  }
});

