<?php
// WordPress sitesinin adresi
$wordpress_url = 'https://kuponkumas.com';

// API endpoint'i
$api_endpoint = '/wp-json/wp/v2/products';

// Tam istek URL'sini oluştur
$request_url = $wordpress_url . $api_endpoint;

// GET isteği gönder ve sonucu al
$response = file_get_contents($request_url);

// Yanıtı JSON formatından diziye dönüştür
$data = json_decode($response, true);

// Dönen verileri kontrol et
if (!empty($data)) {
    // JSON verilerini burada kullanabilirsiniz
    foreach ($data as $product) {
        echo "Ürün Adı: " . $product['title']['rendered'] . "\n";
        echo "Ürün Fiyatı: " . $product['price'] . "\n";
        echo "Açıklama: " . $product['description']['rendered'] . "\n\n";
    }
} else {
    echo "Ürün verisi alınamadı.";
}
?>
