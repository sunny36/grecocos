$(document).ready(function(){
  jQuery('#products').jqGrid({
    height: "auto", 
    url: '/index.php/supplier/products/index2', 
    colNames: ['Id', 'Short Description', 'Short Description', 'Selling Price', 
               'Buying Price', 'Quantity', 'Stock', 'Display', 'Actions'], 
    colModel:[
      {id: 'id', index: 'id', width:25},
      {name:'short_description',index:'short_description', width:320, 
       editable: true},
      {name:'short_description_th',index:'short_description_th', width:170, 
       editable: true},      
      {name:'selling_price',index:'selling_price', width:75, align:"right", 
       editable: true},
      {name:'buying_price', index:'buying_price', width:75, align:"right",
      editable: true},
      {name:'quantity', index:'quantity', width:70, align:"right", editable: true},
      {name:'stock', index:'stock', width:35, align:"right", editable: true},
      {name:'display', index:'display', width:50, align:"right",editable: true,
       formatter:'checkbox', edittype:"checkbox", editoptions: {value:"1:0"}},    
      {name:'act',index:'act', width:80,sortable:false, search: false} 		 
    ],
    editurl: '/index.php/supplier/products/edit',
    rowNum: 100000,
    sortname: 'product',
    viewrecords: true,
    sortorder: "asc",
    userDataOnFooter: true,
    gridComplete: function(){
      var ids = jQuery("#products").jqGrid('getDataIDs');
      for(var i=0;i < ids.length;i++){
        var cl = ids[i];
        be = "<input class='products edit ui-button " + 
          "ui-button-text-only ui-widget ui-state-default " +
          "ui-corner-all' type='button' value='Edit'  />"; 
        jQuery("#products").jqGrid('setRowData',ids[i],{act:be});
      }    
    },
    caption:"Products"
  });
  
  $('.products.edit.ui-button').live('click', function() {
    var $button = $(this);
    productId = $button.parent().parent().attr('id'); 
    jQuery("#products").setSelection(productId, true);
    $button.hide();
    $("#" + getTableId($button)).editRow($button.parent().parent()
                                  .attr('id'));
    s = "<input class='products save ui-button ui-button-text-only " + 
        "ui-widget ui-state-default ui-corner-all' type='button' " + 
        "value='Save' />";
    c = "<input class='products cancel ui-button ui-button-text-only " + 
        "ui-widget ui-state-default ui-corner-all' type='button' " + 
        "value='Cancel' />";
    $button.after(c).after(s);
  });
  
  function getTableId($button) {
    return $button.closest('table').attr('id');
  }
  
  $('.products.save.ui-button').live('click', function() {
    var $button = $(this);
    $button.hide(); 
    $button.next().hide();
    $("#" + getTableId($button)).saveRow($button.parent().parent().attr('id'));
    $button.prev().show();
    $button.next().remove(); 
    $button.remove();    
  });

  $('.products.cancel.ui-button').live('click', function() {
    var $button = $(this);
    $button.hide();
    $button.prev().hide();
    $("#" + getTableId($button))
      .restoreRow($button.parent().parent().attr('id'));
    $button.prev().prev().show();
    $button.prev().remove();
    $button.remove();    
  });
  
});