var ajaxImage = '<img src="/img/ajax-loader.gif" alt="Loading" id="ajax_loader"/>';
var pathname = "/index.php/deliveries"

$(document).ready(function(){
  jQuery('#delivery_dates').jqGrid({
    height: "auto",
    url: jQuery.url.attr("path"), 
    colNames: ['Id', 'Date', 'Next Delivery', 'Actions'], 
    colModel:[
      {name: 'id', index:'id', sortable: false, editable: false, hidden: true},
      {
        name: 'date', index:'date', sortable: false, editable: true, 
        editoptions: {
          size: 12, 
          dataInit:function(el) {
            $(el).datepicker({
              dateFormat: 'dd-mm-yy', 
              beforeShowDay: enableOnlyTuesAndFri
            });
          }
        },
        editrules: {required: true, custom: true, custom_func: validateAddNewDate}
      },
      {
        name: 'next_delivery', index: 'next_delivery', sortable:false, 
        formatter:'checkbox', formatoptions:{disabled:false}
      },      
      {name: 'act', index:'act', width:80, sortable:false, search: false} 		 
    ],
    datatype: "local", 
    sortname: 'date',
    viewrecords: true,
    sortorder: "desc",
    rowNum: 'ALL',
    editurl: '/index.php/supplier/deliveries/add',
    toolbar: [true, "top"],
    gridComplete: function(){
      var ids = jQuery("#delivery_dates").jqGrid('getDataIDs');
      for(var i=0;i < ids.length;i++){
        var cl = ids[i];
        bd = "<input class='delivery_dates delete ui-button ui-button-text-only ui-widget ui-state-default " +
        "ui-corner-all' type='button' value='Delete'  />";         
        jQuery("#delivery_dates").jqGrid('setRowData', ids[i], {act: bd});
      }
    },
    caption:"Delivery Dates"
  });

  $(".addlink").click(function (){ 
    var organizationId = $("#organizationsSelect").attr('value');
    if (organizationId.length == 0) {
      custom_confirm_ok("Please select an outlet", function () { return false; });
      return false;
    }
    jQuery("#delivery_dates").jqGrid(
      'editGridRow', 
      "new", 
      {
        height: 100, top: 100, left: 400, reloadAfterSubmit: false, jqModal: true, closeOnEscape:true, 
        closeAfterAdd: true
      }
    ); 
    return false;
  });

  $.getJSON('/index.php/organizations/index.json', function (data) {
    var organizations = data;
    $('#t_delivery_dates').append('<label>Outlet </label>');
    $('#t_delivery_dates').append('<select id="organizationsSelect"></select>');
    $('#organizationsSelect').append('<option value="">Please Select</option>');
    $.each(organizations, function (index, value) {
      $('#organizationsSelect').append(
      '<option value="' + value["Organization"]["id"] + '>' + value['Organization']['delivery_address'] + '</option>');
    });
  });

  $('#organizationsSelect').live('change', function () {
    var organizationId = $(this).attr('value');
    organizationId = (organizationId.length > 0) ? organizationId : 0;
    jQuery("#delivery_dates")
    .jqGrid('setGridParam', {url: "/index.php/supplier/deliveries/index?organization_id=" + organizationId});
      $("#delivery_dates").jqGrid('setGridParam',{datatype:'json'}).trigger('reloadGrid');
  }); 

  function enableOnlyTuesAndFri(date) { 
    var day = date.getDay(); 
    return [day == 2 || day == 5, ""]; 
  }

  function validateAddNewDate(value, colname) {
    validationResult = $.ajax({
      type: "POST",
      url: '/index.php/deliveries/validate_add_delivery_date/',
      data: colname + "=" + value,
      async: false,
      success: function (data) { }
    }).responseText;
    validationResult = JSON.parse(validationResult);
    if (validationResult.length == 0) {
      return [true, ""];
    } else {
      return [false, validationResult["date"]];
    }
  }

  $('input[type=checkbox]').live('click', function () {
    var $next_delivery_checkbox = $(this);
    var id = $next_delivery_checkbox.parents("tr").attr("id");
    if($next_delivery_checkbox.is(':checked')) {
      var msg = "Are you sure you want to change the next delivery date?";
      custom_confirm_yes_no(msg, 
        function() {change_next_delivery($next_delivery_checkbox, id, "1");},
        function() {$next_delivery_checkbox.attr("checked", false);});
    }
    //next_delivery is unchecked
    else {

    }
  });

  function change_next_delivery($checkbox, deliveryId, isNextDelivery) {
    $checkbox.hide();
    $checkbox.after(ajaxImage);
    $.post(
      pathname + '/edit/' + deliveryId, 
      {next_delivery: isNextDelivery}, function() {
        $('input:checkbox:checked').each(function () {
          var id = $(this).parents("tr").attr("id");
          if (id != deliveryId) {
            $(this).attr("checked", false);
          }
        });
        $('#ajax_loader').remove();
        $checkbox.fadeIn();
      });
      return; 
  } 

  $('.delivery_dates.delete.ui-button').live('click', function() {
    var $button = $(this);
    var id = $button.parent().parent().attr('id');
    $("#" + getTableId($button)).jqGrid(
      'delGridRow', 
      id, 
      {
        url: getDeleteUrl(), 
        reloadAfterSubmit:false,       
        beforeSubmit: function (postdata, formid) {
          orders = $.ajax({
            url: '/index.php/deliveries/getOrders/' + postdata,
            async: false,
            success: function (data) { }
          }).responseText;
          orders = JSON.parse(orders);
          if (orders["total_orders"] != 0) {
            return [false, "Delivery date cannote be deleted as it contains orders."];
          } else {
            return [true, "Delivery date has been deleted"];
          }
        }
      } 
    );
  });  

  function getDeleteUrl() {
    return '/index.php/supplier/deliveries/delete';
  }

  function getTableId($button) {
    return $button.closest('table').attr('id');
  }

});

