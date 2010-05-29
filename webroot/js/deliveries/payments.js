$(document).ready(function(){
  jQuery('#deliveries').jqGrid({
    height: "100%", 
    width: 100+100+100+100+100+100,
    url: window.location.pathname, 
    colNames: ['Date', 'Received', 'Refund', 'Due'], 
    colModel:[
      {name:'date', index:'date', width:100, align:"left"},
      {name:'total_received', index:'total_received', width:100, align:"right"},
      {name:'total_refund', index:'total_refund', width:100, align:"right"},
      {name:'total_due', index:'total_due', width:100, align:"right"},
    ],
    headerrow: true,
    viewrecords: true,
    sortorder: "asc",
  });
});
