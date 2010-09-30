<?php if($next_delivery_in_future == true): ?>
  alert("Hello World!!");
<?php endif; ?>
<?php if($next_delivery_in_future == false): ?>
  $('form').before("<p class='errornote'>There is no delivery date set, please update next delivery date</p>");
<?php endif; ?>