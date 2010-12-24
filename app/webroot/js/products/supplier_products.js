$(document).ready(function(){
  function getCategories() {
    var categories = $.ajax({
      url: '/index.php/supplier/categories',
      async: false,
      success: function(data) {
      }
    }).responseText;
    categories = JSON.parse(categories);
    categories = categories["rows"];
    var result = ""; 
    for (var i = 0; i < categories.length; i++) {
      result += categories[i]["id"] + ":" + categories[i]["cell"][1];
      if (i != (categories.length - 1)) {
        result += ";";
      }
    }
    return result;
  }

  function getMasterCategories() {
    var masterCategories = $.ajax({
      url: '/index.php/supplier/master_categories',
      async: false,
      success: function(data) {
      }
    }).responseText;
    masterCategories = JSON.parse(masterCategories);
    masterCategories = masterCategories["rows"];
    var result = ""; 
    for (var i = 0; i < masterCategories.length; i++) {
      result += masterCategories[i]["id"] + ":" + masterCategories[i]["cell"][1];
      if (i != (masterCategories.length - 1)) {
        result += ";";
      }
    }
    return result;
  }
  
  
  jQuery('#products').jqGrid({
    height: "auto", 
    url: '/index.php/supplier/products/index2', 
    colNames: ['Id', 'Short Description', 'Short Description', 
               'Selling Price', 'Buying Price', 'Quantity', 'Stock', 'Display', 
               'Category', 'Master Category', 'Actions'], 
    colModel:[
      {id: 'id', index: 'id', width:25},
      {name:'short_description',index:'short_description', width:310, 
       editable: true},
      {name:'short_description_th',index:'short_description_th', width:165, 
       editable: true},      
      {name:'selling_price',index:'selling_price', width:78, align:"right", 
       editable: true},
      {name:'buying_price', index:'buying_price', width:78, align:"right",
      editable: true},
      {name:'quantity', index:'quantity', width:70, align:"right", editable: true},
      {name:'stock', index:'stock', width:38, align:"right", editable: true},
      {name:'display', index:'display', width:50, align:"right",editable: true,
       formatter:'checkbox', edittype:"checkbox", editoptions: {value:"1:0"}},
      {name:'category_id',index:'category_id', width:100, editable: true, 
       edittype:"select"},
      {name:'master_category_id',index:'master_category_id', width:100, 
       editable: true, edittype:"select"},       
      {name:'act',index:'act', width:80,sortable:false, search: false} 		 
    ],
    editurl: '/index.php/supplier/products/edit',
    rowNum: 100000,
    sortname: 'product',
    viewrecords: true,
    sortorder: "asc",
    userDataOnFooter: true,
    caption:"Products",
    gridComplete: function(){
      var ids = jQuery("#products").jqGrid('getDataIDs');
      for(var i=0;i < ids.length;i++){
        var cl = ids[i];
        be = "<input class='products edit ui-button " + 
          "ui-button-text-only ui-widget ui-state-default " +
          "ui-corner-all' type='button' value='Edit'  />"; 
        jQuery("#products").jqGrid('setRowData',ids[i],{act:be});
      }
      $("#products").setColProp('category_id', {
        editoptions: { value: getCategories()} }
      );         
      $("#products").setColProp('master_category_id', {
        editoptions: { value: getMasterCategories()} }
      );               
    }    
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