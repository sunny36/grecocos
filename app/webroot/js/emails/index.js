var app = {
  setupTextArea: function () {
    $('#EmailBody').wysiwyg({css: "/css/wysiwyg.css"});
  }
};


$(document).ready(function() {
  app.setupTextArea();
});

