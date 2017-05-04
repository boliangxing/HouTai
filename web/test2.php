<?php
for($i=1;$i<10;$i++){
$ch = curl_init();  
$timeout = 5;  
curl_setopt ($ch, CURLOPT_URL, '192.168.10.103:55555/[123456+'.$i.']');  
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);  
curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);  
$file_contents = curl_exec($ch);  
curl_close($ch); 
echo $i;
}


