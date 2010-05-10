$(document).ready(function(){
  jQuery('#order').jqGrid({
    height: "100%", 
    width: 250+80+80+80+100,
    url: window.location.pathname, 
    colNames: ['Product','Quantity Ordered', 'Quantity Supplied', 'Unit Price', 'Amount'], 
    colModel:[
       		{name:'short_description',index:'short_description', width:250, 
       		 align:"left"},
       		{name:'quantity_ordered',index:'quantity_ordered', width:140, align:"center"},
       		{name:'quantity_supplied',index:'quantity_supplied', width:150, align:"center"},
       		{name:'price',index:'price', width:120, align:"right"},
       		{name:'sub_total',index:'sub_total', width:150, align:"right"}
       	],
    sortname: 'product',
    rownumbers: true, 
    headerrow: true,
    footerrow : true, 
    userDataOnFooter : true, 
    viewrecords: true,
    sortorder: "asc",
    caption:"Order Details"
  });
});
