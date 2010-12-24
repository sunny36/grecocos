$(document).ready(function(){
  jQuery.fn.exists = function(){return jQuery(this).length>0;}
  if ($('.asc').exists()) { 
    $th = $('.asc').parent(); 
    $th.addClass("sorted ascending");
    $('.asc').removeAttr("class");
  } 
  if ($('.desc').exists()) { 
    $th = $('.desc').parent(); 
    $th.addClass("sorted descending");
    $('.desc').removeAttr("class");
  } 
});