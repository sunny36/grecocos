$(document).ready(function(){
  jQuery('#transactions').jqGrid({
    height: "100%", 
    width: 250+80+80+80+100+100,
    url: window.location.pathname, 
    colNames: ['Id','Type', 'By', 'Order Id', 'Time'], 
    colModel:[
      {name:'id', index:'id', width:50, align:"center"},
        {name:'type', index:'type', width:140, align:"left"},
        {name:'user_name',index:'user_name', width:150, align:"left"},
        {name:'order_id',index:'order_id', width:80, align:"left"},
        {name:'created',index:'created', width:150, align:"left"}
    ],
    sortname: 'product',
    headerrow: true,
    viewrecords: true,
    sortorder: "asc",
  });
});
