var productsNum = 0;
$(document).ready(function(){
    var lastsel2;
var mygrid =  jQuery("#orders").jqGrid({
        url: '/index.php/supplier/orders/index',
  	datatype: "xml",
     	colNames:['Order Id','Delivery Date', 'Customer', 'Packed', 'Amount', 
     	          'Actions', 'Print'],
     	colModel:[
     	    {name:'id',index:'id', width:80, sorttype:"int", editable: false, 
     	     search: false},
     	    {name:'delivery_date',index:'delivery_date', width:180,
      	   editable: false, stype:'select', 
     	     searchoptions:{value:"all:All;current_delivery_date:Current Delivery Date"}},
     	    {name:'customer',index:'customer', editable: false, search:false},
     	    {name:'status',index:'status', width:100, align:'center', 
     	     formatter:'checkbox', editable: true, edittype:"checkbox",
     	     editoptions: {value:"Yes:No"}, stype:'select',
     	     searchoptions:{value:"all:All;packed:Packed;not_packed:Not Packed"}},
     	    {name:'amount',index:'amount', width:80, editable: false, align:"right", search:false},
     	    {name:'act',index:'act', width:140,sortable:false, search: false},
     	    {name:'print',index:'print', width:140,sortable:false,
     	     search: false, formatter:link_formatter},
     	],
     	gridview : true,
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
        editurl: '/index.php/supplier/orders/edit',
        caption:"Orders",
        onSelectRow: function(ids) {
            if(ids == null) {
                ids = 0; 
                if(jQuery("#order_d").jqGrid('getGridParam','records') > 0) {
                    jQuery("#order_d").jqGrid('setGridParam',{
                        url:"/index.php/supplier/orders/view/"+ids,
                        editurl:"/index.php/supplier/orders/edit/"+ids,
                        page:1});
                    jQuery("#order_d").jqGrid('setCaption',"Order Detail: "+ids)
                        .trigger('reloadGrid');
                }
            } else {
                jQuery("#order_d").jqGrid('setGridParam',{
                    url:"/index.php/supplier/orders/view/"+ids,
                    editurl:"/index.php/supplier/orders/edit/"+ids,
                    page:1,
                    orderId: ids}); // set order id for later referal
                jQuery("#order_d").jqGrid('setCaption',"Order Detail: "+ids)
                    .trigger('reloadGrid');	
            }
        }
    });	

    jQuery("#orders").jqGrid('navGrid','#orders_pager',{edit:false,add:false,del:false,search:false,refresh:false});
    // jQuery("#orders").jqGrid('navButtonAdd',"#orders_pager",{caption:"Toggle",title:"Toggle Search Toolbar", buttonicon :'ui-icon-pin-s',
    //  onClickButton:function(){
    //    mygrid[0].toggleToolbar();
    //  } 
    // });
    // jQuery("#orders").jqGrid('navButtonAdd',"#orders_pager",{caption:"Clear",title:"Clear Search",buttonicon :'ui-icon-refresh',
    //  onClickButton:function(){
    //    mygrid[0].clearToolbar();
    //  } 
    // });
    jQuery("#orders").jqGrid('filterToolbar');
    $.get('/index.php/supplier/deliveries/getalljson', function(data) {
      var delivery_dates = eval('(' + data + ')');
      for(i = 0; i < delivery_dates.length; i++) {
        $('#gs_delivery_date').append($("<option></option>").attr("value",delivery_dates[i]["Delivery"]["id"]).text(delivery_dates[i]["Delivery"]["date"]));
      }
    });
	  
                  
    
    function link_formatter(cellvalue, options, rowObject) {
        link = "\"/index.php/supplier/orders/view/" + options["rowId"] + "\"";
        return "<a href=" + link + ">" + cellvalue + "</a> ";
    }
    
    jQuery('#order_d').jqGrid({
        height: 'auto', 
        rownumbers: true, 
        url: '/index.php/supplier/orders/view/0', 
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
                        be = "<input class='order_d edit ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all' type='button' value='Edit'  />"; 
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
        getOrderDeliveryStatus(orderId, function(data) {
            if(data == 1) {
                custom_confirm_ok("Batch has been closed. Cannot edit.", function() {return; })
                return;
            } else {
                $button.hide();
                $("#" + getTableId($button)).editRow($button.parent().parent().attr('id'));
                s = "<input class='orders save ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all' type='button' value='Save' />";
                c = "<input class='orders cancel ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all' type='button' value='Cancel' />";
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
        $("#" + getTableId($button)).restoreRow($button.parent().parent().attr('id'));
        $button.prev().prev().show();
        $button.prev().remove();
        $button.remove();    
    });
    
    $('.order_d.edit.ui-button').live('click', function() {
        var $button = $(this);
        $button.hide();
        $("#" + getTableId($button)).editRow($button.parent().parent().attr('id'));
        s = "<input class='order_d save ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all' type='button' value='Save' />";
        c = "<input class='order_d cancel ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all' type='button' value='Cancel' />";
        $button.after(c).after(s);
    });

    function reload(rowid, result) {
      //$("#order_d").trigger("reloadGrid"); 
    }
    
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
            custom_confirm_ok("Quantity supplied must be LESS THAN or EQUAL to quantity ordered", function() { return }); 
        } else { 
            $button.hide(); 
            $button.next().hide();
            $("#" + getTableId($button)).saveRow($button.parent().parent().attr('id'), '', '', '', reload, '');
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
        $.get(url + '?order_id=' + orderId + '&product_id=' + productId, function(data) {
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

