function custom_confirm_yes_no(prompt, action_yes, action_no) {
  var $dialog = $('<div></div>')
  		.html(prompt)
  		.dialog({
  			autoOpen: false,
  			title: 'Grecocos',
  			modal: true,
  			resizable: false,
  			closeOnEscape: false,
        open: function(event, ui) { $(".ui-dialog-titlebar-close").hide(); },
        width: 'auto',
        buttons: {
          'Yes': function() {
            $(this).dialog('close');
            action_yes();
            },
          No: function() {
            $(this).dialog('close');
            action_no();
            }
          }
  		});
  $dialog.dialog('open');
}   

function custom_confirm_ok(prompt, action) {
  var $dialog = $('<div></div>')
  		.html(prompt)
  		.dialog({
  			autoOpen: false,
  			title: 'Grecocos',
  			modal: true,
  			resizable: false,
  			closeOnEscape: false,
        open: function(event, ui) { $(".ui-dialog-titlebar-close").hide(); },
        width: 'auto',
        buttons: {
          'OK': function() {
            $(this).dialog('close');
            action();
            }
          }
  		});
  $dialog.dialog('open');
}   
