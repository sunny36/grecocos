$(document).ready(function(){
  $('#box').hide();
  $('a[rel*=facybox]').facybox();
  
  $('.short_description').click(function(){
    $product = $(this);
    productId = $product.parent().parent().children().first().children().first().attr("value");
    //console.log(productId);
    jQuery.facybox({ajax: '/grecocos/products/view/' + productId});
  });
  
  $("button").button({
    icons: {
        primary: 'ui-icon-minusthick'
    },
    text: false
  });
  
  $(".category").toggle(
    
    function(){
      $categoryButton = $(this);
      $('.' + $categoryButton.attr("id")).slideUp();
      $categoryButton.button({
        icons: {
            primary: 'ui-icon-plusthick'
        },
        text: false        
      });
      return false;
    },
    
    function(){
      $categoryButton = $(this);
      $('.' + $categoryButton.attr("id")).slideDown();
      $categoryButton.button({
        icons: {
            primary: 'ui-icon-minusthick'
        },
        text: false        
      });
      return false;
    }
  );
  
  $('input[type="text"]').blur(function(){
    //console.log($(this));
    var quantity = $(this).val();
    //console.log($(this).val());
    var row = $(this).parent().parent();
    //console.log(row);
    var children = row.children();
    //console.log(children);
    var priceText = children[2].innerHTML;
    //console.log(priceText);
    var price = (priceText.split(" "))[1];
    var subTotal = quantity * price; 
    // console.log(price);  
    // console.log(subTotal);  
    children[3].innerHTML = "\u0E3F" + " " + subTotal;
    calculateTotal();
    
    
  });
  
  $('#empty_cart').click(function(){
    //reset all the quantity
    $("form")[0].reset();
    var products = $('#products tr');
    // first row is the head of the table
    // last row is the total
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
    
    //console.log(total);
    $(products[products.length - 1]).children()[3].innerHTML = "\u0E3F" + 
                                                               " " + 
                                                               total;
    return;
  }
});