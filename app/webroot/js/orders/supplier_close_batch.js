var productsNum = 0;
$(document).ready(function(){
  var lastsel2;
  jQuery("#delivery_dates").jqGrid({
    datatype: "local",
    colNames:['Delivery Date', 'Next Delivery', 'Total Orders', 'Total Packed', 'Closed', 'Actions'],
    colModel:[
      {name:'date',index:'date', editable: false, width:90},       		
      {name:'next_delivery',index:'next_delivery', editable: false, formatter:'checkbox', width:105},       		
      {name:'ordered',index:'ordered', editable: false, sortable: false,width:75},   
      {name:'packed',index:'packed', editable: false, sortable: false,width:75},     
      {
        name:'closed',index:'closed', editable: true, formatter:'checkbox', editable: true, edittype:"checkbox", 
        width:45
      }, 
      {name:'act',index:'act', width:85,sortable: false}      		
    ],
    pager: jQuery('#delivery_dates_pager'),
    pgbuttons: false,
    pginput: false,
    height: "auto",
    rowNum: 100000,
    sortname: 'next_delivery',
    rownumbers: true, 
    sortorder: "desc",
    editurl: '/index.php/supplier/deliveries/edit',
    caption: "Delivery Dates",
    toolbar: [true, "top"],
    gridComplete: function(){
      var ids = jQuery("#delivery_dates").jqGrid('getDataIDs');
      for(var i=0;i < ids.length;i++){
        var cl = ids[i];
        be = "<input class='delivery_dates edit ui-button ui-button-text-only ui-widget ui-state-default " +  
        "ui-corner-all' type='button' value='Edit'  />"; 
        jQuery("#delivery_dates").jqGrid('setRowData',ids[i],{act:be});
      } 
    }               
  });	

  $.getJSON('/index.php/organizations/index.json', function (data) {
    var organizations = data;
    $('#t_delivery_dates').append('<label>Outlet </label>');
    $('#t_delivery_dates').append('<select id="organizationsSelect"></select>');
    $('#organizationsSelect').append('<option value="">Please Select</option>');
    $.each(organizations, function (index, value) {
      $('#t_delivery_dates select')
      .append('<option value="' + value["Organization"]["id"] + '>' + value['Organization']['delivery_address'] + 
      '</option>');
    });
  });


  $('#organizationsSelect').live('change', function () {
    var organizationId = $(this).attr('value');
    if (organizationId > 0) {
      jQuery("#delivery_dates")
      .jqGrid('setGridParam', {url: "/index.php/supplier/orders/close_batch?organization_id=" + organizationId});
      $("#delivery_dates").jqGrid('setGridParam',{datatype:'xml'}).trigger('reloadGrid');
    }
  }); 

  //confirm if total orders != packed orders
  $('input').live('click', function() {
    if(this.id.match(/\d_closed/)){
      $closed_checkbox = $(this);
      total_orders = parseInt($(this).parent().parent().children()[3].innerHTML, 10);
      total_packed = parseInt($(this).parent().parent().children()[4].innerHTML, 10);
      if($closed_checkbox.is(':checked')) {
        if (total_orders != total_packed) {
          msg = 'All orders have not been packed. ' +
          'Batch cannot be closed.';
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

