$(document).ready(function(){
  $('#box').hide();
  
  $('a[rel*=facybox]').facybox();
  
  
  
  if ($('#ProductConfirmForm').length > 0) {
    $('#ProductConfirmForm')[0].reset();
  }  
  
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
    if (validateInteger($(this).val()) == false) {
      custom_confirm_ok("Quantity must be an integer only.", function() {});
      $(this).val("0");
    }
    var quantity = $(this).val();
    var row = $(this).parent().parent();
    var children = row.children();
    var priceText = children[2].innerHTML;
    var price = (priceText.split(" "))[1];
    var subTotal = quantity * price; 
    children[3].innerHTML = "\u0E3F" + " " + subTotal;
    setTotal();        
  });
  
  $('input[type="text"]').bind('textchange', function (event, previousText) {
    var quantity = $(this).val();
    var row = $(this).parent().parent();
    var children = row.children();
    var priceText = children[2].innerHTML;
    var price = (priceText.split(" "))[1];
    var subTotal = quantity * price; 
    children[3].innerHTML = "\u0E3F" + " " + subTotal;
    setTotal();        
  });
  
  
  $('#empty_cart').click(function(){
    $("form")[0].reset();
    var products = $('#products tr');
    for(var i = 1; i < products.length - 1; i++) {
      (($(products[i]).children())[3]).innerHTML = "\u0E3F" + " " + "0";
    }
    $(products[products.length - 1]).children()[3].innerHTML = "\u0E3F" + " " + "0";
    return false;
  });
  
  $('#toggle_zero').toggle(
    function (){
      $(this).text("Show all items");
      var products = $('#products tr');
      for(var i = 1; i < products.length - 1; i++) {
        if(parseInt($($(products[i]).children()).children()[1].value, 10) == 0) {
          $(products[i]).hide();
        }
      }      
    },
    function (){
      $(this).text("View your order");
      var products = $('#products tr');
      for(var i = 1; i < products.length - 1; i++) {
        $(products[i]).show();
      }
    }
  );

  
  $('#update').click(function() {
    var $products =  $('tr.products');
    var cart = []; 
    var quantity, shortDescription, price, subTotal;
    var isCartEmpty = true;
    $products.each(function (index) {
      quantity = parseInt($($(this).children()[0]).children('input:text').val(), 10);
      shortDescription = $($(this).children()[1]).children().text(); 
      price = "\u0E3F" + " " + parseInt($($(this).children()[2]).text().split(" ")[1], 10); 
      subTotal = "\u0E3F" + " " + parseInt($($(this).children()[3]).text().split(" ")[1], 10);
      if (quantity > 0) {
        isCartEmpty = false; 
        cart.push({"quantity": quantity, "shortDescription": shortDescription, "price": price, "subTotal": subTotal});
      }      
    });
    if (isCartEmpty) {
      custom_confirm_ok("Nothing to check out - thank you", function() {});
    } else {
      createJqgrid(cart);
    }
    
    return false; 
  });  
  
  $('#continueShoppingButton').click(function () {
    $('#cartDiv').dialog("destroy");
  });
  
  $('#confirmButton').click(function () {
    $('#ProductConfirmForm').submit();
  });
  
});

function setTotal() {
  $('tr#totalRow').children().last().text("\u0E3F" + " " + calculateTotal());
}

function calculateTotal(){
  var $products = $('tr.products');
  var total = 0;
  var str = "";
  $products.each(function (index) {
    str = $(this).children().last().text(); 
    if(str.length > 0){
      str = str.split(" ")[1];
      total = total + parseInt(str, 10);
    }            
  });
  return total;
}

function validateInteger(strValue) {
  var objRegExp  = /(^\d\d*$)/;
  return objRegExp.test(strValue);
}

function createJqgrid(cart) {
  $('#cartTable').GridUnload();
  jQuery("#cartTable").jqGrid({ 
    datatype: "local", 
    height: "auto", 
    colNames:['Quantity','Item', 'Price', 'Sub-Total'], 
    colModel:[ 
      {name:'quantity',index:'quantity', align:"right", width:70, sortable:false}, 
      {name:'shortDescription',index:'shortDescription', width: 400, sortable:false}, 
      {name:'price',index:'price', align:"right", width: 70, sortable:false}, 
      {name:'subTotal',index:'subTotal', align:"right", width: 80, sortable:false}
    ],
      footerrow : true, 
      userDataOnFooter : true, 
      gridComplete: function () {
        $('#cartTable').jqGrid('footerData', 'set', {price: "Total", subTotal: "\u0E3F" + " " + calculateTotal()});
      },
      caption: "Your Shopping Cart" 
    }); 
    
  for(var i=0;i <=cart.length;i++) {
    jQuery("#cartTable").jqGrid('addRowData',i+1,cart[i]);
  }        
  
  $("#confirmButton, #continueShoppingButton").button();
  $('#cartDiv').dialog({
    resizable: false,
    modal: true,
    width:'auto',
    height: 'auto'
  });
  $(".ui-dialog-titlebar").hide();
}