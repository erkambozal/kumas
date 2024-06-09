<?php
$AuthenticationResponse=$_POST["AuthenticationResponse"];
$RequestContent = urldecode($AuthenticationResponse);

$xxml=simplexml_load_string($RequestContent) or die("Error: Cannot create object");


?>
<form>
    <div style="margin:0 auto">
           <table>
            <tr>
                <td>
		<input name="ResponseCode" Type="hidden" value= <?php  echo $xxml->ResponseCode ?> />
 
                </td>
            </tr>
            <tr>
                <td>
                    <input name="ResponseMessage" Type="hidden" value=<?php echo $xxml->ResponseMessage ?> />
                </td>
            </tr>
            <tr>
                <td>
                    <input name="MerchantOrderId" Type="hidden" value=<?php echo $xxml->VPosMessage->MerchantOrderId  ?> />
                </td>
            </tr>
            <tr>
                <td>
                    <input name="OrderId" Type="hidden"  value=<?php echo $xxml->VPosMessage->OrderId ?> />
                </td>
            </tr>
            <tr>
                <td>
                    <input name="ProvisionNumber" Type="hidden" value=<?php echo $xxml->VPosMessage->ProvisionNumber ?> /> 
                </td>
            </tr>
            <tr>
                <td>
                     <input name="RRN" Type="hidden" value=<?php echo $xxml->VPosMessage->RRN ?> /> 
                </td>
            </tr>
            <tr>
                <td>
                     <input name="Stan" Type="hidden" value=<?php echo $xxml->VPosMessage->Stan ?> /> 
                </td>
            </tr>
            <tr>
                <td>
                    <input name="MD" Type="hidden" value=<?php echo $xxml->MD ?> /> 
                </td>
            </tr>
            <tr>
                <td>
                     <input name="Amount" Type="hidden" value=<?php echo $xxml->VPosMessage->Amount ?> /> 
                </td>
            </tr>
            <tr>
                <td>
                     <input name="HashData" Type="hidden" value=<?php echo $xxml->VPosMessage->HashData ?>/> 
                </td>
            </tr>
  
        </table>
    </div>
</form>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kart Bilgisi Hatalı</title>
  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      background-color: #f0f0f0;
    }
    
    .error-message {
      text-align: center;
    }
    
    .cross-mark {
      font-size: 100px;
      color: red;
    }
  </style>
</head>
<body>
  <div class="error-message">
    <span class="cross-mark">&#10060;</span>
    <h1><?php echo $xxml->ResponseMessage ?></h1>
  </div>
	<a href="/checkout" id="myLink"></a>

<script>
     window.onload = function() {
        setTimeout(function() {
            document.getElementById('myLink').style.display = 'inline'; // Bağlantıyı görünür yap
            document.getElementById('myLink').click(); // Bağlantıya tıklama işlemi
        }, 3000); // 3 saniye bekleyerek tıklama işlemini gerçekleştir
    }
</script>
<style>
	#myLink {
    display: none;
}
	</style>
	
</body>
</html>