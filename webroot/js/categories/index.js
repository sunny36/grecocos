$(document).ready(function(){
  
  function getPriorities() {
    var categories = $.ajax({
      url: jQuery.url.attr("path"),
      async: false,
      success: function(data) {
      }
    }).responseText;
    categories = JSON.parse(categories);
    var priorities = ""; 
    for (var i = 1; i <= categories["rows"].length; i++) {
      priorities += + i + ":" + i;
      if (i != categories["rows"].length) {
        priorities += ";";
      }
    }
    return priorities;
  }
  
  jQuery('#categories').jqGrid({
    height: "auto", 
    url: jQuery.url.attr("path"), 
    colNames: ['Id', 'Name', 'Priority', 'Actions'], 
    colModel:[
      {id: 'id', index: 'id', sortable:false, width:20},
      {name:'name',index:'name', sortable:false, editable: true},
      {name:'priority', index:'priority', sortable:false, editable: true, 
       edittype:"select"},      
      {name:'act',index:'act', width:80,sortable:false, search: false} 		 
    ],
    datatype: "json", 
    editurl: '/index.php/supplier/categories/edit',
    sortname: 'product',
    viewrecords: true,
    sortorder: "asc",
    userDataOnFooter: true,
    gridComplete: function(){
      var ids = jQuery("#categories").jqGrid('getDataIDs');
      for(var i=0;i < ids.length;i++){
        var cl = ids[i];
        be = "<input class='categories edit ui-button " + 
             "ui-button-text-only ui-widget ui-state-default " +
             "ui-corner-all' type='button' value='Edit'  />"; 
        bd = "<input class='categories delete ui-button " + 
             "ui-button-text-only ui-widget ui-state-default " +
             "ui-corner-all' type='button' value='Delete'  />";         
        jQuery("#categories").jqGrid('setRowData',ids[i],{act:be+bd});
      }
      $("#categories").setColProp('priority', {
        editoptions: { value: getPriorities()} }
      );    
    },
    caption:"Product Categories"
  });
  
  $('.categories.edit.ui-button').live('click', function() {
    var $button = $(this);
    categoryId = $button.parent().parent().attr('id'); 
    jQuery("#categories").setSelection(categoryId, true);
    $button.hide();
    $("#" + getTableId($button)).editRow($button.parent().parent().attr('id'));
    s = "<input class='categories save ui-button ui-button-text-only " + 
        "ui-widget ui-state-default ui-corner-all' type='button' " + 
        "value='Save' />";
    c = "<input class='categories cancel ui-button ui-button-text-only " + 
        "ui-widget ui-state-default ui-corner-all' type='button' " + 
        "value='Cancel' />";
    $button.after(c).after(s);
  });
  
  function getTableId($button) {
    return $button.closest('table').attr('id');
  }
  
  $('.categories.save.ui-button').live('click', function() {
    var $button = $(this);
    $button.hide(); 
    $button.next().hide();
    $("#" + getTableId($button)).saveRow($button.parent().parent().attr('id'));
    $button.prev().show();
    $button.next().remove(); 
    $button.remove();    
  });

  $('.categories.cancel.ui-button').live('click', function() {
    var $button = $(this);
    $button.hide();
    $button.prev().hide();
    $("#" + getTableId($button))
      .restoreRow($button.parent()
      .parent()
      .attr('id'));
    $button.prev().prev().show();
    $button.prev().remove();
    $button.remove();    
  });  
  
  $('.categories.delete.ui-button').live('click', function() {
    var $button = $(this);
    var id = $button.parent().parent().attr('id'); 
    $("#" + getTableId($button))
      .jqGrid('delGridRow', 
              id, 
              {url: jQuery.url.attr("path") + "/delete", reloadAfterSubmit:false}
    );
  });  
  
});