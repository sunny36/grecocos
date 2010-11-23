$(document).ready(function(){
  
  function getPriorities() {
    var master_categories = $.ajax({
      url: jQuery.url.attr("path"),
      async: false,
      success: function(data) {
      }
    }).responseText;
    master_categories = JSON.parse(master_categories);
    var priorities = ""; 
    for (var i = 1; i <= master_categories["rows"].length; i++) {
      priorities += + i + ":" + i;
      if (i != master_categories["rows"].length) {
        priorities += ";";
      }
    }
    return priorities;
  }
  
  jQuery('#master_categories').jqGrid({
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
    editurl: '/index.php/supplier/master_categories/edit',
    sortname: 'product',
    viewrecords: true,
    sortorder: "asc",
    userDataOnFooter: true,
    gridComplete: function(){
      var ids = jQuery("#master_categories").jqGrid('getDataIDs');
      for(var i=0;i < ids.length;i++){
        var cl = ids[i];
        be = "<input class='master_categories edit ui-button " + 
             "ui-button-text-only ui-widget ui-state-default " +
             "ui-corner-all' type='button' value='Edit'  />"; 
        bd = "<input class='master_categories delete ui-button " + 
             "ui-button-text-only ui-widget ui-state-default " +
             "ui-corner-all' type='button' value='Delete'  />";         
        jQuery("#master_categories").jqGrid('setRowData',ids[i],{act:be+bd});
      }
      $("#master_categories").setColProp('priority', {
        editoptions: { value: getPriorities()} }
      );    
    },
    caption:"Product Categories"
  });
  
  $('.master_categories.edit.ui-button').live('click', function() {
    var $button = $(this);
    categoryId = $button.parent().parent().attr('id'); 
    jQuery("#master_categories").setSelection(categoryId, true);
    $button.hide();
    $("#" + getTableId($button)).editRow($button.parent().parent().attr('id'));
    s = "<input class='master_categories save ui-button ui-button-text-only " + 
        "ui-widget ui-state-default ui-corner-all' type='button' " + 
        "value='Save' />";
    c = "<input class='master_categories cancel ui-button ui-button-text-only " + 
        "ui-widget ui-state-default ui-corner-all' type='button' " + 
        "value='Cancel' />";
    $button.after(c).after(s);
  });
  
  function getTableId($button) {
    return $button.closest('table').attr('id');
  }
  
  $('.master_categories.save.ui-button').live('click', function() {
    var $button = $(this);
    $button.hide(); 
    $button.next().hide();
    $("#" + getTableId($button)).saveRow($button.parent().parent().attr('id'));
    $button.prev().show();
    $button.next().remove(); 
    $button.remove();    
  });

  $('.master_categories.cancel.ui-button').live('click', function() {
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
  
  $('.master_categories.delete.ui-button').live('click', function() {
    var $button = $(this);
    var id = $button.parent().parent().attr('id'); 
    $("#" + getTableId($button))
      .jqGrid('delGridRow', 
              id, 
              {url: jQuery.url.attr("path") + "/delete", reloadAfterSubmit:false}
    );
  });  
  
});