$(document).ready(function(){
  jQuery.fn.exists = function(){return jQuery(this).length>0;}
  if ($('#authMessage').exists()) { 
    var message = $('#authMessage').html(); 
    $('#authMessage').remove();
    $('#content-main').before('<p class="errornote">' + message + '</p>'); 
  } else { 
    
  }  
});