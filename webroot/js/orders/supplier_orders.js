var productsNum = 0;
$(document).ready(function(){
  var lastsel2;
  var mygrid =  jQuery("#orders").jqGrid({    
    defaults : {
      recordtext: "View {0} - {1} of {2}",
      emptyrecords: "No records to view",
      loadtext: "Loading...",
      pgtext : "Page {0} of {1}"
    },
    colNames:['Order Id','Delivery Date', 'Customer', 'Packed', 'Amount', 'Actions', 'Print', 'Order Details'],
    colModel:[
      {name:'id',index:'id', width:55, sorttype:"int", editable: false, search: false},
      {name:'delivery_date',index:'delivery_date', width:110, editable: false, stype:'select', 
       searchoptions:{value:"loading:loading"}},
      {name:'customer',index:'customer', width:240, editable: false, search:false},
      {name:'status',index:'status', width:100, align:'center', formatter:'checkbox', editable: true, 
       edittype:"checkbox", editoptions: {value:"Yes:No"}, stype:'select',
       searchoptions:{value:"all:All;packed:Packed;paid:Not Packed"}},
      {name:'amount',index:'amount', width:80, editable: false, align:"right", search:false},
      {name:'act',index:'act', width:140,sortable:false, search: false},
      {name:'print',index:'print', width:50,sortable:false, align:'center', search: false, formatter:link_formatter},
      {name:'order_details',index:'order_details', width:110,sortable:false, search: false}
    ],
    datatype: 'local',
    gridview : true,
    height: 200,
    viewrecords: true,
    pager: jQuery('#orders_pager'),
    pgbuttons: false,
    pginput: false,
    sortname: 'id',
    sortorder: "desc",
    toolbar: [true, "top"],
    recreateForm : true,
    gridComplete: function(){
      var ids = jQuery("#orders").jqGrid('getDataIDs');
      for(var i=0;i < ids.length;i++){
        var cl = ids[i];
        be = "<input class='orders edit ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all'" +  
          "type='button' value='Edit'  />"; 
        bvd = "<input class='orders view_details ui-button ui-button-text-only ui-widget ui-state-default " +
          "ui-corner-all' type='button' value='View/Edit Details'/>";                      
        jQuery("#orders").jqGrid('setRowData',ids[i],{act:be});
        jQuery("#orders").jqGrid('setRowData',ids[i], {order_details:bvd});
      } 
      
    },
    editurl: '/index.php/supplier/orders/edit',
    caption:"Orders"
  });


  
  $('.orders.view_details.ui-button').live('click', function() {
    var $button = $(this);
    var orderId = $button.parent().parent().attr('id'); 
    jQuery("#orders").setSelection(orderId, true);
    jQuery("#order_d").jqGrid('setGridParam',{
      url:"/index.php/supplier/orders/view/"+orderId,
      editurl:"/index.php/supplier/orders/edit/"+orderId,
      page:1,
      orderId: orderId}); // set order id for later referal
    jQuery("#order_d").jqGrid('setCaption',"Order Detail: "+orderId)
      .trigger('reloadGrid'); 

  });
  
  jQuery("#orders").jqGrid('navGrid','#orders_pager', {edit:false,add:false,del:false,search:false, refresh:false});

  jQuery("#orders").jqGrid('filterToolbar');
  $('#gs_delivery_date').hide();  
  $('#gs_status').hide();  

  $.getJSON('/index.php/organizations/index.json', function (data) {
      var organizations = data;
      $('#t_orders').append('<select id="organizationsSelect"></select>');
      $('#organizationsSelect').append('<option value="">Please Select</option>');
      $.each(organizations, function (index, value) {
        $('#t_orders select')
          .append('<option value="' + value["Organization"]["id"] + '>' + value['Organization']['delivery_address'] + 
                  '</option>');
      });
  });

  function loadDeliveryDates() {
    $.get('/index.php/supplier/deliveries/getalljson', function(data) {
    var delivery_dates = eval('(' + data + ')');
    $("#gs_delivery_date option[value='loading']").remove();
      for(i = 0; i < delivery_dates.length; i++) {
        $('#gs_delivery_date')
          .append($("<option></option>")
          .attr("value",delivery_dates[i]["Delivery"]["id"])
          .text(delivery_dates[i]["Delivery"]["date"]));
      }
   });
        
  $('#gs_delivery_date').show();  

  }
 
  $('#organizationsSelect').live('change', function () {
    var organizationId = $(this).attr('value');
    if (organizationId > 0) {
     jQuery("#orders")
      .jqGrid('setGridParam', {url: "/index.php/supplier/orders/index?organization_id=" + organizationId});
     $("#orders").jqGrid('setGridParam',{datatype:'xml'}).trigger('reloadGrid');

      loadDeliveryDates();
      $('#gs_status').show();
    }
  }); 
  
  function link_formatter(cellvalue, options, rowObject) {
    link = "\"/index.php/supplier/orders/view/" + options["rowId"] + "\"";
    return "<a href=" + link + ">" + cellvalue + "</a> ";
  }

  jQuery('#order_d').jqGrid({
    height: 'auto', 
    rownumbers: true, 
    url: '/index.php/supplier/orders/view/', 
    colNames: ['Item Description', 'Quantity Ordered', 'Quantity Supplied', 
               'Action'], 
    colModel:[
      {name:'short_description',index:'short_description', width:250},
      {name:'quantity_ordered',index:'quantity_ordered', 
       width:120, align:"center"},
      {name:'quantity_supplied', index:'quantity_supplied', 
       width:120, align:"center", editable: true},     		 
      {name:'act',index:'act', width:140,sortable:false}
    ],
    gridComplete: function(){
      var ids = jQuery("#order_d").jqGrid('getDataIDs');
      var orderId = $('#order_d').jqGrid('getGridParam', 'orderId'); 
      //Do not show edit button if the order has already been packed
      getOrderDeliveryStatus(orderId, function(data) {
        if(data == 0) {
          for(var i=0;i < ids.length;i++){
            var cl = ids[i];
            be = "<input class='order_d edit ui-button ui-button-text-only " + 
                 "ui-widget ui-state-default ui-corner-all' type='button' " + 
                 "value='Edit'  />"; 
            jQuery("#order_d").jqGrid('setRowData',ids[i],{act:be});
          } 
        }
      }); 
    },       
    editurl: '/index.php/supplier/orders/edit',
    sortname: 'product',
    viewrecords: true,
    sortorder: "asc",
    footerrow: true, 
    userDataOnFooter: true,
    caption:"Order Details"
  });
  
  $('.orders.edit.ui-button').live('click', function() {
    var $button = $(this);
    orderId = $button.parent().parent().attr('id'); 
    jQuery("#orders").setSelection(orderId, true);
    
    getOrderDeliveryStatus(orderId, function(data) {
      if(data == 1) {
        custom_confirm_ok("Batch has been closed. Cannot edit.", 
                          function() {return; });
        return;
      } else {
        $button.hide();
        $("#" + getTableId($button)).editRow($button.parent().parent()
                                      .attr('id'));
        s = "<input class='orders save ui-button ui-button-text-only " + 
            "ui-widget ui-state-default ui-corner-all' type='button' " + 
            "value='Save' />";
        c = "<input class='orders cancel ui-button ui-button-text-only " + 
            "ui-widget ui-state-default ui-corner-all' type='button' " + 
            "value='Cancel' />";
        $button.after(c).after(s);
      }
    });
  });

  function getOrderDeliveryStatus(orderId, callback) {
    var url = '/index.php/orders/getdeliverystatus'; 
    $.get(url + '?id=' + orderId, function(data) {
      callback(data); 
    });
  }

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
    $("#" + getTableId($button))
      .restoreRow($button.parent().parent().attr('id'));
    $button.prev().prev().show();
    $button.prev().remove();
    $button.remove();    
  });
  
  $('.order_d.edit.ui-button').live('click', function() {
    var $button = $(this);
    $button.hide();
    $("#" + getTableId($button)).editRow($button.parent().parent().attr('id'));
    s = "<input class='order_d save ui-button ui-button-text-only ui-widget " + 
        "ui-state-default ui-corner-all' type='button' value='Save' />";
    c = "<input class='order_d cancel ui-button ui-button-text-only " + 
        "ui-widget ui-state-default ui-corner-all' type='button' " + 
        "value='Cancel' />";
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
    var rowid = $button.parent().parent().attr('id'); 
    var quantity_ordered = $("#" + getTableId($button)).
      getCell(rowid, "quantity_ordered");
    var quantity_supplied = $("#" + rowid + "_quantity_supplied").val(); 
    if(parseInt(quantity_supplied, 10) > parseInt(quantity_ordered, 10)) { 
      var msg = "Quantity supplied must be LESS THAN or EQUAL to quantity " + 
                "ordered";
      custom_confirm_ok(msg, function() { return; }); 
    } else { 
      $button.hide(); 
      $button.next().hide();
      $("#" + getTableId($button)).saveRow($button.parent().parent().attr('id'), 
                                           '', '', '', reload, '');
      $button.prev().show();
      $button.next().remove(); 
      $button.remove();    
    }
  });
  function reload(rowid, result) {
    $("#order_d").trigger("reloadGrid"); 
    $("#orders").trigger("reloadGrid"); 
  }
  
  
  var productsNum = 0;
  function getProductsNum(orderId, productId, callback) {
    var url = '/index.php/supplier/orders/lineitem';
    $.get(url + '?order_id=' + orderId + '&product_id=' + productId, 
          function(data) {
            callback(data);
          });
  }
  
  function getTableId($button) {
    return $button.closest('table').attr('id');
  }

  function custom_confirm_ok(prompt, action) {
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
          'OK': function() {
            $(this).dialog('close');
            action();
          }
        }
      });
    $dialog.dialog('open');
  }   
});

