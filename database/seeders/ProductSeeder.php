<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        function get_products_with_stock($url, $consumer_key, $consumer_secret) {
            $base_url = $url . "/wp-json/wc/v3/products";
            $params = array(
                "consumer_key" => $consumer_key,
                "consumer_secret" => $consumer_secret,
                "per_page" => 100,  // Kaç ürünün çekileceğini belirleyebilirsiniz
                "page" => 1, // Sayfa numarası, ilk sayfa
                "stock_status" => "instock", // Stokta olan ürünleri alır
                "attributes" => "true", // Ürüne ait özellikleri alır
                "fields" => "id,name,price,stock_quantity,description,categories,images", // İstenen alanları belirler
            );

            $output = array();

            do {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $base_url . '?' . http_build_query($params));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $response = curl_exec($ch);

                if (!$response) {
                    die("Curl Error: " . curl_error($ch));
                }

                $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);

                if ($status_code == 200) {
                    $products = json_decode($response, true);

                    foreach ($products as $product) {
                        $product_id = $product['id'];
                        $product_name = $product['name'];
                        $product_price = isset($product['price']) ? $product['price'] : 0;
                        $stock_quantity = isset($product['stock_quantity']) ? $product['stock_quantity'] : 0;
                        $description = isset($product['description']) ? $product['description'] : '';
                        $categories = isset($product['categories']) ? $product['categories'] : array();
                        $images = isset($product['images']) ? $product['images'] : array();

                        // Açıklama kısmındaki HTML içeriği temizle (htmlspecialchars)
                        $cleaned_description = htmlspecialchars($description, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

                        // Ürün bilgilerini diziye ekle (stok miktarı 0 olmayanları al)
                        if ($stock_quantity > 0) {
                            // Resimleri çekmek için images array'ini dönerek image_url'leri alıyoruz
                            $image_urls = array();
                            foreach ($images as $image) {
                                $image_urls[] = $image['src'];
                            }

                            $output[] = array(
                                'Ürün ID' => $product_id,
                                'Ürün Adı' => $product_name,
                                'Ürün Fiyatı' => $product_price,
                                'Stok Miktarı' => $stock_quantity,
                                'Açıklama' => $cleaned_description,
                                'Kategoriler' => $categories,
                                'Resimler' => $image_urls, // Birden fazla resim varsa tüm image_url'leri ekliyoruz
                            );
                        }
                    }

                    // Sonraki sayfa için page parametresini artır
                    $params['page']++;
                } else {
                    echo "Hata kodu: $status_code, Hata mesajı: $response\n";
                    break;
                }
            } while (!empty($products)); // Son sayfaya ulaşana kadar döngüyü devam ettir

            // Sonuçları JSON formatında döndür ve ekrana yazdır (Türkçe karakterler için JSON_UNESCAPED_UNICODE kullan)
            $json_output = json_encode($output, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            return json_decode($json_output, true);
        }

        $url = "https://kuponkumas.com";
        $consumer_key = "ck_6e64df5ff00e5b70af2b9a2e5783b64f0276ad18";
        $consumer_secret = "cs_3047c52c74075f151e25e26d0326f462f3db1192";




        // get_products_with_stock fonksiyonunu çağırarak JSON verilerini al
        $products = get_products_with_stock($url,  $consumer_key,  $consumer_secret);

        //$categories = Category::All();


        foreach ($products as $product) {

                $images = $product['Resimler'];
                Product::create([
                    'name'=>$product['Ürün Adı'],
                    'categories'=>json_encode($product['Kategoriler'],JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT),
                    'images'=>json_encode($images),
                    'content'=>$product['Açıklama'],
                    'price'=>$product['Ürün Fiyatı'],
                    'qty'=>$product['Stok Miktarı'],
                    'status'=>'1'
                ]);

                // foreach ($product['Kategoriler'] as $categoryName) {
                //     // Kategoriyi oluşturun veya varolanı alın
                //     $category = Category::firstOrCreate(['name' => $categoryName['name']]);

                //     // Ürünü kategoriye bağlayın
                //     $product->categories()->attach($category->id);
                // }
        }
    }
}
