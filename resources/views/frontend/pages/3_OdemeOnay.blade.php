<?php
$AuthenticationResponse=$_POST["AuthenticationResponse"];
$RequestContent = urldecode($AuthenticationResponse);

$xxml=simplexml_load_string($RequestContent) or die("Error: Cannot create object");

// ResponseCode "00" ve ResponseMessage "Kart doğrulandı" sonuçları alınırsa dönen MD değeri ile birlikte 4_OnayCevap sayfasında ödeme alınır.

?>
<script>
    window.onload = function() {
        document.getElementById('myForm').submit(); // Formu otomatik olarak gönder
    }
</script>
<form id = "myForm" action='{{ route('onaycevap') }}' method='post'>
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
