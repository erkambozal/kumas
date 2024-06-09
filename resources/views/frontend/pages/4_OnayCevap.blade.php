
<?php

 // Ödemenin alındığı sayfa, 3_OdemeOnay sayfasında kart doğrulama başarılı ve MD değeri alınmışsa 
 
	    $MerchantOrderId = "20201221";
	    $Amount = $_POST["Amount"]; //Islem Tutari
	    $MD = $_POST["MD"]; //Islem Tutari
        $CustomerId = "97228291";// Bankadaki müsteri numarası
        $MerchantId = "57902"; //Sanal pos mağaza numarası, başvuru onayıyla işyerine gönderilir. 
        $UserName="TEPKVT2021"; // https://kurumsal.kuveytturk.com.tr adresinde Kullanıcı İşlemleri - Kullanıcı Ekle alanında işyeri tarafından olusturulan api rolünde kullanici adı
		$Password="api123";// api rolünde kullanici adının sifresi
		$HashedPassword = base64_encode(sha1($Password,"ISO-8859-9")); //md5($Password);
	    $HashData = base64_encode(sha1($MerchantId.$MerchantOrderId.$Amount.$UserName.$HashedPassword , "ISO-8859-9"));

				$xml='<KuveytTurkVPosMessage xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
				<APIVersion>1.0.0</APIVersion>
				<HashData>'.$HashData.'</HashData>
				<MerchantId>'.$MerchantId.'</MerchantId>
				<CustomerId>'.$CustomerId.'</CustomerId>
				<UserName>'.$UserName.'</UserName>
				<TransactionType>Sale</TransactionType>
				<InstallmentCount>0</InstallmentCount>
				<CurrencyCode>0949</CurrencyCode>
				<Amount>'.$Amount.'</Amount>
				<MerchantOrderId>'.$MerchantOrderId.'</MerchantOrderId>
				<TransactionSecurity>3</TransactionSecurity>
				<KuveytTurkVPosAdditionalData>
				<AdditionalData>
					<Key>MD</Key>
					<Data>'.$MD.'</Data>
				</AdditionalData>
			</KuveytTurkVPosAdditionalData>
			</KuveytTurkVPosMessage>';
			
		
	 try {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_SSLVERSION, 6);
			//curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_MAX_TLSv1_2); // alternatif
			//curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_0 | CURL_SSLVERSION_TLSv1_1 | CURL_SSLVERSION_TLSv1_2); // php 5.5.19+ destekler
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/xml', 'Content-length: '. strlen($xml)) );
			curl_setopt($ch, CURLOPT_POST, true); //POST Metodu kullanarak verileri g nder  
			curl_setopt($ch, CURLOPT_HEADER, false); //Serverdan gelen Header bilgilerini  nemseme.  
			curl_setopt($ch, CURLOPT_URL,'https://boatest.kuveytturk.com.tr/boa.virtualpos.services/Home/ThreeDModelProvisionGate'); 
			curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
	
		 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //Transfer sonu larini al.
			$data = curl_exec($ch);  
			curl_close($ch);
		 }
		 catch (Exception $e) {
		 echo 'Caught exception: ',  $e->getMessage(), "\n";
		}


		 $xml = simplexml_load_string($data);

			if ($xml !== false && isset($xml->ResponseCode)) {
				$responseCode = (string)$xml->ResponseCode;
				// Do something with $responseCode if needed
			} else {
				// Handle the case where ResponseCode is not found or in the correct format
			}

				// Setting error reporting and display_errors directives
				error_reporting(E_ALL);
				ini_set("display_errors", 1);
		 
?>
<script>
    window.onload = function() {
        document.getElementById('myForm').submit(); // Formu otomatik olarak gönder
    }
</script>
 <form id="myForm" action="{{ route('siparisikaydet') }}" method='post'>
    <div style="margin:0 auto">
        <table>
            <tr>
                <td>
		<input name="ResponseCode" Type="hidden" value= <?php  echo $xml->ResponseCode ?> />
 
                </td>
            </tr>
            
            
        </table>
    </div>
</form>

