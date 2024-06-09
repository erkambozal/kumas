<?php
// Formdan gelen verileri al
$Name = $_POST["CardHolderName"];
$CardNumber = $_POST["CardNumber"];
$CardExpireDateMonth = $_POST["CardExpireDateMonth"];
$CardExpireDateYear = $_POST["CardExpireDateYear"];
$CardCVV2 = $_POST["CardCVV2"];

// Kart türünü belirleyen fonksiyon
function getCardType($cardNumber) {
    $cardNumber = preg_replace('/\D/', '', $cardNumber); // Remove any non-digits

    if (preg_match('/^4[0-9]{12}(?:[0-9]{3})?$/', $cardNumber)) {
        return 'Visa';
    } elseif (preg_match('/^5[1-5][0-9]{14}$/', $cardNumber) || preg_match('/^2(22[1-9]|2[3-9][0-9]|[3-6][0-9]{2}|7([01][0-9]|20))[0-9]{12}$/', $cardNumber)) {
        return 'MasterCard';
    } elseif (preg_match('/^3[47][0-9]{13}$/', $cardNumber)) {
        return 'Amex';
    } elseif (preg_match('/^6(?:011|5[0-9]{2}|4[4-9][0-9])[0-9]{12}$/', $cardNumber)) {
        return 'Discover';
    } elseif (preg_match('/^(5[06-8][0-9]{4}|6[39][0-9]{4})[0-9]{10,17}$/', $cardNumber)) {
        return 'Maestro';
    } elseif (preg_match('/^9792[0-9]{12}$/', $cardNumber)) {
        return 'Troy';
    } else {
        return 'Unknown';
    }
}

// Kart türünü belirle
$CardType = getCardType($CardNumber);

// Diğer sabit veriler
$MerchantOrderId = "20201221"; // Siparis Numarasi
$Amount = $_POST["Amount"]; // $_POST ile formdan gelen "Amount" değerini alıyoruz
$Amount = $Amount * 100; // Alınan değeri 100 ile çarpıyoruz
$CustomerId = "97228291";
$MerchantId = "57902";
$OkUrl = "http://127.0.0.1:8000/3_OdemeOnay";
$FailUrl = "http://127.0.0.1:8000/HataSayfasi";
$UserName = "TEPKVT2021";
$Password = "api123";
$HashedPassword = base64_encode(sha1($Password, "ISO-8859-9")); //md5($Password);
$HashData = base64_encode(sha1($MerchantId.$MerchantOrderId.$Amount.$OkUrl.$FailUrl.$UserName.$HashedPassword, "ISO-8859-9"));

// XML mesajı oluştur
$xml = '<KuveytTurkVPosMessage xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">'
    .'<APIVersion>1.0.0</APIVersion>'
    .'<OkUrl>'.$OkUrl.'</OkUrl>'
    .'<FailUrl>'.$FailUrl.'</FailUrl>'
    .'<SubMerchantId>0</SubMerchantId>'
    .'<HashData>'.$HashData.'</HashData>'
    .'<MerchantId>'.$MerchantId.'</MerchantId>'
    .'<CustomerId>'.$CustomerId.'</CustomerId>'
    .'<UserName>'.$UserName.'</UserName>'
    .'<CardNumber>'.$CardNumber.'</CardNumber>'
    .'<CardExpireDateYear>'.$CardExpireDateYear.'</CardExpireDateYear>'
    .'<CardExpireDateMonth>'.$CardExpireDateMonth.'</CardExpireDateMonth>'
    .'<CardCVV2>'.$CardCVV2.'</CardCVV2>'
    .'<CardHolderName>'.$Name.'</CardHolderName>'
    .'<InstallmentCount>0</InstallmentCount>'
    .'<CardType>'.$CardType.'</CardType>' // Dinamik olarak belirlenen kart türü
    .'<BatchID>0</BatchID>'
    .'<TransactionType>Sale</TransactionType>'
    .'<Amount>'.$Amount.'</Amount>'
    .'<DisplayAmount>'.$Amount.'</DisplayAmount>'
    .'<CurrencyCode>0949</CurrencyCode>'
    .'<MerchantOrderId>'.$MerchantOrderId.'</MerchantOrderId>'
    .'<TransactionSecurity>3</TransactionSecurity>'
    .'<TransactionSide>Sale</TransactionSide>'
    .'</KuveytTurkVPosMessage>';

try {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSLVERSION, 6);
    curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_MAX_TLSv1_2); // alternatif
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/xml', 'Content-length: '.strlen($xml)) );
    curl_setopt($ch, CURLOPT_POST, true); //POST Metodu kullanarak verileri gönder
    curl_setopt($ch, CURLOPT_HEADER, false); //Serverdan gelen Header bilgilerini önemseme.
    curl_setopt($ch, CURLOPT_URL, 'https://boatest.kuveytturk.com.tr/boa.virtualpos.services/Home/ThreeDModelPayGate');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //Transfer sonuçlarini al.
    $data = curl_exec($ch);
    curl_close($ch);
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";
}

echo($data);

error_reporting(E_ALL);
ini_set("display_errors", 1);
?>








