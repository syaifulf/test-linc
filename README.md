# Test API (Linc Group)

How this code working:

1. Initiate datetime now and milisecond format

          $tz = 'Asia/Jakarta';
          $dt = new \DateTime("now", new \DateTimeZone($tz));
          $date = $dt->format('Y-m-d G:i:s');
          $dt = \DateTime::createFromFormat('U.u', number_format(microtime(true), 6, '.', ''), new \DateTimeZone($tz));
          $time_in_ms = (int)$dt->format('Uv');
          ...
          
2. Initiate all variable to generate the signature 
  
          ...
          $content = 'application/json';
          $api_key = 'ojh545we4t5254sdgfsaefstg65478';
          $signature_key = '879sdg78dsfg56sd4g7987eswg76';
          $body = '{"email":"syaiful.octo@gmail.com"}';
          $body_md5 = md5($body);
          ...
  
3. Encrypt the combination of the Raw Signature and Signature Key using HMAC SHA-256.

          ...
          $raw = "POST".'\n'.$body_md5.'\n'.$content.'\n'.$date.'\n'."/v1/test-new-employee";
          $s = hash_hmac('sha256',$raw, $signature_key, false);
          $signature =  base64_encode($s);
          ...
               
4. Put header informations follow the instruction of test

          ...
          $headers = array(
              "Authorization: Basic ". base64_encode("$username:$password"),
              "Accept: $content",
              "Content-Type: $content",           
              "API-KEY : $api_key",            
              "Signature : $s",
              "Signature-Time : $time_in_ms"
           );
           ...
  
5. Initate the url or end point and returns a Curl instance for us to use the URL to work with. 

          ...
          $url = "https://integrasi.delapancommerce.com/v1/test-new-employee";
          $curl = \curl_init($url);
          ...
          
6. Setting the Curl instance to use with value based on instruction
 
          ...
          curl_setopt($curl, CURLOPT_URL, $url);
          curl_setopt($curl, CURLOPT_POST, true);        
          curl_setopt($curl, CURLOPT_POSTFIELDS, $body );
          curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
          curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1 );
          curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
          curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
          curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
          curl_setopt($curl, CURLOPT_TIMEOUT, 30);
          curl_setopt($curl, CURLOPT_HEADER, false);
          ...
          
7. Execute Curl to get data from end point with information of request
          
          ...
          $resp = curl_exec($curl);
          ...
          
8. Check if there is error when exectue the Curl
  
          ...
          if (curl_errno($curl)) {
              $error_msg = curl_error($curl);
          }
          ...
          
9. Close the Curl session
          ...
          curl_close($curl);
          ..
          
10. Show error message if there is error, and show result if there is no error
          
          ...
          if (isset($error_msg)) {
              echo $error_msg;
          }else{
              echo "====================================================================================<br/>";
              echo "RESPONSE<br/>";
              echo "====================================================================================<br/>";
              $data = json_decode($resp,true);
              echo '<pre>';
              var_dump($data);
              echo '</pre>';            
          }
