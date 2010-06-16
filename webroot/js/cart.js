$(document).ready(function(){
  $('#box').hide();
  $('a[rel*=facybox]').facybox();
  
  $('.short_description').click(function(){
    $product = $(this);
    productId = $product.parent().parent().children().first().children().first().attr("value");
    jQuery.facybox({ajax: '/index.php/products/view/' + productId});
  });
  
  
  $(".category").toggle(    
    function(){
      $categoryButton = $(this);
      $('.' + $categoryButton.attr("id")).hide();
      $(this).removeClass('ui-icon-minus').addClass('ui-icon-plus');
      return false;
    },
    function(){
      $categoryButton = $(this);
      $('.' + $categoryButton.attr("id")).show();
      $(this).removeClass('ui-icon-plus').addClass('ui-icon-minus');
      return false;
    }
  );
  
  $('input[type="text"]').blur(function(){
    var quantity = $(this).val();
    var row = $(this).parent().parent();
    var children = row.children();
    var priceText = children[2].innerHTML;
    var price = (priceText.split(" "))[1];
    var subTotal = quantity * price; 
    children[3].innerHTML = "\u0E3F" + " " + subTotal;
    calculateTotal();        
  });
  
  $('input[type="text"]').bind('textchange', function (event, previousText) {
    var quantity = $(this).val();
    var row = $(this).parent().parent();
    var children = row.children();
    var priceText = children[2].innerHTML;
    var price = (priceText.split(" "))[1];
    var subTotal = quantity * price; 
    children[3].innerHTML = "\u0E3F" + " " + subTotal;
    calculateTotal();        
  });
  
  
  $('#empty_cart').click(function(){
    $("form")[0].reset();
    var products = $('#products tr');
    for(var i = 1; i < products.length - 1; i++) {
      (($(products[i]).children())[3]).innerHTML = "\u0E3F" + " " + "0";
    }
    $(products[products.length - 1]).children()[3].innerHTML = "\u0E3F" + 
                                                               " " + 
                                                               "0";
    return false;
  });
  
  $('#toggle_zero').toggle(
    function (){
      $(this).text("Show all items");
      var products = $('#products tr');
      for(var i = 1; i < products.length - 1; i++) {
        if(parseInt($($(products[i]).children()).children()[1].value) == 0) {
          $(products[i]).hide();
        }
      }
      
    },
    function (){
      $(this).text("Hide zero\'s quantity items");
      var products = $('#products tr');
      for(var i = 1; i < products.length - 1; i++) {
        $(products[i]).show();
      }
    }
  );

  function calculateTotal(){
    var products = $('#products tr');
    // first row is the head of the table
    // last row is the total
    var total = 0;
    for(var i = 1; i < products.length - 1; i++) {
      var str = $(products[i]).children()[3].innerHTML;
      if(str.length > 0){
        str = str.split(" ")[1];
        total = total + parseInt(str);
      }
      
    }
    $(products[products.length - 1]).children()[3].innerHTML = "\u0E3F" + 
                                                               " " + 
                                                               total;
    return;
  }
});
