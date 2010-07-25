<?php 
class AppengineEmail extends AppModel {
  var $useTable = false; 

  function sendEmail($to, $subject, $body, $attachment = NULL) {
    $request_url = 'http://grecocos.appspot.com/sendemail';
    $post_params['to'] = $to;
    $post_params['subject'] = $subject; 
    $post_params['body'] = $body;
    if ($attachment != NULL) {
      $post_params['file_name'] = '@' . $attachment;
    } else {
      $post_params['file_name'] = NULL;
    }
    $post_params['submit'] = urlencode('Send');
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $request_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_params);
    $result = curl_exec($ch);
    curl_close($ch);
  }
}

?>


