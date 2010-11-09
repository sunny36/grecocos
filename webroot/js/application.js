$(document).ready(function() {
  setTimeout(updateSiteStatus, 30000);
});

function updateSiteStatus () {
  var url = "/index.php/configurations/get_site_status";
  $.get(url, function (data) {
    var configuration = JSON.parse(data);
    if (configuration["closed"] == "yes") { 
      $('h2#site-name').html("SITE STATUS: CLOSED");
    }
    if (configuration["closed"] == "no") { 
      $('h2#site-name').html("SITE STATUS: OPEN");
    }
    setTimeout(updateSiteStatus, 30000);
  });
}
