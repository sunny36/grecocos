$(document).ready(function(){
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
  // $('#update').click(function(){
  //   console.log("submit");
  //   var products = $('#products tr');
  //   var numberOfProducts = products.length - 2;
  //   console.log(numberOfProducts);
  //   var data = new Array();
  //   for(var i = 1; i <= numberOfProducts; i++) { 
  //     var id = $('#' + i + 'Id');
  //     var quantity = $('#' + i + 'Quantity');
  //     console.log(id[0].value);
  //     console.log(quantity[0].value);
  //     data[parseInt(id[0].value)] = quantity[0].value;
  //   }
  //   console.log(data);
  //   $.post("update", { 'data[]': data });
  //   
  //   
  //   //return false;
  // });
  function calculateTotal(){
    var products = $('#products tr');
    // first row is the head of the table
    // last row is the total
    var total = 0;
    for(var i = 1; i < products.length - 1; i++) {
      total = total + 
              parseInt($(products[i]).children()[3].innerHTML.split(" ")[1]);
    }
    
    //console.log(total);
    $(products[products.length - 1]).children()[3].innerHTML = "\u0E3F" + 
                                                               " " + 
                                                               total;
    return;
  }
});