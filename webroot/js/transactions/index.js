Number.prototype.formatMoney = function(c, d, t){
  var n = this, c = isNaN(c = Math.abs(c)) ? 2 : c, d = d == undefined ? "," : d, t = t == undefined ? "." : t, s = n < 0 ? "-" : "", i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
   return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};
 
$(document).ready(function(){
  jQuery('#transactions').jqGrid({
    shrinkToFit: false,
    width: "661",
    height: "auto",
    url: window.location.pathname, 
    colNames: ['From/To', 'Description', 'Date', 'Batch', 'Cash In', 'Cash Out'], 
    colModel:[
      {name:'user_name',index:'user_name', align:"left", search:false, width: 150},
      {name:'type', index:'type', align:"left", search:false, width:110},
      {name:'ordered_date', index:'type', align:"left", search:false, width:90},
      {name:'delivery_date', index:'delivery_date',  align:"left", stype:'select', 
        searchoptions:{value:"all:All"}, width:100},
        {name:'cash_in',index:'cash_in',align:"right", search:false, width:90},
        {name:'cash_out',index:'created',  align:"right", search:false, width:90}
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
    gridComplete: function() {
      $('.ui-jqgrid-sdiv').clone().appendTo('.ui-jqgrid-sdiv'); 
      $($('table.ui-jqgrid-ftable')[1]).children().children().children()[1].innerHTML = "Net cash in for this batch"; 
      var cashIn = parseInt($($('table.ui-jqgrid-ftable')[1]).children().children().children()[4].innerHTML, 10);
      var cashOut = parseInt($($('table.ui-jqgrid-ftable')[1]).children().children().children()[5].innerHTML, 10);
      var netCash = (cashIn - cashOut).formatMoney(2, '.', ','); 
      $($('table.ui-jqgrid-ftable')[1]).children().children().children()[4].innerHTML = netCash; 
      $($('table.ui-jqgrid-ftable')[1]).children().children().children()[5].innerHTML = ""; 
    }, 
    beforeRequest: function() {
      $($('.ui-jqgrid-sdiv')[1]).remove(); 
    }
  }).navGrid('#transactions_pager',{edit:false,add:false,del:false});	;

  jQuery("#transactions").jqGrid('filterToolbar');
  $.get('/index.php/supplier/deliveries/getalljson', function(data) {
    var delivery_dates = eval('(' + data + ')');
    $("#gs_delivery_date option[value='all']").remove();
    for(i = 0; i < delivery_dates.length; i++) {
      $('#gs_delivery_date').
        append($("<option></option>").
               attr("value",delivery_dates[i]["Delivery"]["id"]).
                 text(delivery_dates[i]["Delivery"]["date"]));
    }
  });

});
