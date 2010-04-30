$(document).ready(function(){
  jQuery('#order').jqGrid({
    height: "100%", 
    width: 250+80+80+80+100,
    url: window.location.pathname, 
    colNames: ['Product','Quantity', 'Price', 'Sub-Total'], 
    colModel:[
       		{name:'short_description',index:'short_description', width:250, 
       		 align:"left"},
       		{name:'qty',index:'qty', width:80, align:"center"},
       		{name:'price',index:'price', width:80, align:"right"},
       		{name:'sub_total',index:'sub_total', width:80, align:"right"}
       	],
    sortname: 'product',
    rownumbers: true, 
    footerrow : true, userDataOnFooter : true, 
    viewrecords: true,
    sortorder: "asc",
    caption:"Order Details"
  });
});
