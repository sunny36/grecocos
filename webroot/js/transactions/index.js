$(document).ready(function(){
  jQuery('#transactions').jqGrid({
    shrinkToFit: false,
    width: "1015",
    height: "auto",
    url: window.location.pathname, 
    colNames: ['From/To', 'Description', 'Date', 'Batch', 'Cash In', 'Cash Out'], 
    colModel:[
        {name:'user_name',index:'user_name', align:"left", search:false, width: 200},
        {name:'type', index:'type', align:"left", search:false},
        {name:'ordered_date', index:'type', align:"left", search:false},
        {name:'delivery_date', index:'delivery_date',  align:"left", stype:'select', 
         searchoptions:{value:"all:All"}, width:"180"},
        {name:'cash_in',index:'cash_in',align:"right", search:false},
        {name:'cash_out',index:'created',  align:"right", search:false}
    ],
    sortname: 'product',
    headerrow: true,
    viewrecords: true,
    sortorder: "asc",
    footerrow: true,
    userDataOnFooter: true,
    rowNum: 20,
   	rowList:[10,20,30],
   	caption: "Transactions",
    pager: jQuery('#transactions_pager'),
  }).navGrid('#transactions_pager',{edit:false,add:false,del:false});	;

  jQuery("#transactions").jqGrid('filterToolbar');
  $.get('/index.php/supplier/deliveries/getalljson', function(data) {
    var delivery_dates = eval('(' + data + ')');
    for(i = 0; i < delivery_dates.length; i++) {
      console.log(delivery_dates[i]["Delivery"]["id"]);
      console.log(delivery_dates[i]["Delivery"]["date"]);
      $('#gs_delivery_date').append($("<option></option>").attr("value",delivery_dates[i]["Delivery"]["id"]).text(delivery_dates[i]["Delivery"]["date"]));
    }
  });
  
});
