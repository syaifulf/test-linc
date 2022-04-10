<?php
          $tz = 'Asia/Jakarta';
          $dt = new \DateTime("now", new \DateTimeZone($tz));
          $date = $dt->format('Y-m-d G:i:s');
          $dt = \DateTime::createFromFormat('U.u', number_format(microtime(true), 6, '.', ''), new \DateTimeZone($tz));
          $time_in_ms = (int)$dt->format('Uv');
  
          $username = 'linc-test';
          $password = '123456';
          $content = 'application/json';
          $api_key = 'ojh545we4t5254sdgfsaefstg65478';
          $signature_key = '879sdg78dsfg56sd4g7987eswg76';
          $body = '{"email":"syaiful.octo@gmail.com"}';
          $body_md5 = md5($body);
          $method = "POST";
          $req_url = "/v1/test-new-employee";
          $endpoint = "https://integrasi.delapancommerce.com";
          $url = $endpoint.$req_url;
  
          $raw = $method.'\n'.$body_md5.'\n'.$content.'\n'.$date.'\n'. $req_url;
          $s = hash_hmac('sha256',$raw, $signature_key, false);
          $signature =  base64_encode($s);
  
          echo "====================================================================================<br/>";
          echo "INFORMATION<br/>";
          echo "====================================================================================<br/>";
          echo "body : $body <br/>"; 
          echo "body_md5 : $body_md5 <br/>";
          echo "date : $date <br/>";
          echo "time_in_ms : $time_in_ms <br/>";
          echo "raw : $raw <br/>";
          echo "signature : $s <br/><br/>";         
  
          $headers = array(
              "Authorization: Basic ". base64_encode("$username:$password"),
              "Accept: $content",
              "Content-Type: $content",           
              "API-KEY : $api_key",            
              "Signature : $s",
              "Signature-Time : $time_in_ms"
           );
  
          echo "====================================================================================<br/>";
          echo "REQUEST HEADER<br/>";
          echo "====================================================================================<br/>";
          
          echo '<pre>';
          var_dump($headers);
          echo '</pre>';
  
          $curl = \curl_init($url);
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
          
          $resp = curl_exec($curl);
  
          if (curl_errno($curl)) {
              $error_msg = curl_error($curl);
          }
  
          curl_close($curl);
  
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
?>
