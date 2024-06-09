<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
/*
        function get_categories_with_attributes($url, $consumer_key, $consumer_secret)
        {
            $base_url = $url . "/wp-json/wc/v3/products/categories";
            $params = array(
                "consumer_key" => $consumer_key,
                "consumer_secret" => $consumer_secret,
                "per_page" => 100,  // Kaç kategorinin çekileceğini belirleyebilirsiniz
                "page" => 1, // Sayfa numarası, ilk sayfa
                "hide_empty" => true, // Boş kategorileri gizler
            );

            $categories = array();

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
                    $category_data = json_decode($response, true);

                    foreach ($category_data as $category) {
                        $category_id = $category['id'];
                        $category_name = $category['name'];


                        // Alt kategorileri çekmek için kategoriye ait alt kategori endpoint'ini kullanın
                        $subcategory_data = get_subcategories_for_category($url, $consumer_key, $consumer_secret, $category_id);
                        $subcategories = array();
                        foreach ($subcategory_data as $subcategory) {
                            $subcategories[] = array(
                                'Alt Kategori ID' => $subcategory['id'],
                                'Alt Kategori Adı' => $subcategory['name'],
                            );
                        }


                        $categories[] = array(
                            'Kategori ID' => $category_id,
                            'Kategori Adı' => $category_name,
                            'Alt Kategoriler' => $subcategories,
                        );
                    }

                    // Sonraki sayfa için page parametresini artır
                    $params['page']++;
                } else {
                    echo "Hata kodu: $status_code, Hata mesajı: $response\n";
                    break;
                }
            } while (!empty($category_data)); // Son sayfaya ulaşana kadar döngüyü devam ettir

            // Sonuçları JSON formatında döndür ve ekrana yazdır (Türkçe karakterler için JSON_UNESCAPED_UNICODE kullan)
            $json_output = json_encode($categories, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            return json_decode($json_output, true);
        }

        function get_subcategories_for_category($url, $consumer_key, $consumer_secret, $category_id)
        {
            // Kategoriye ait alt kategorileri çeken API endpoint'ini kullanın
            $base_url = $url . "/wp-json/wc/v3/products/categories";
            $params = array(
                "consumer_key" => $consumer_key,
                "consumer_secret" => $consumer_secret,
                "per_page" => 100,
                "parent" => $category_id, // Sadece belirtilen kategoriye ait alt kategorileri alır
            );

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
                return json_decode($response, true);
            } else {
                echo "Hata kodu: $status_code, Hata mesajı: $response\n";
                return array();
            }
        }



        // get_products_with_stock fonksiyonunu çağırarak JSON verilerini al
        $categories = get_categories_with_attributes("https://kuponkumas.com", "ck_6e64df5ff00e5b70af2b9a2e5783b64f0276ad18", "cs_3047c52c74075f151e25e26d0326f462f3db1192");

        // Her ürün için veritabanına ekleme işlemini gerçekleştir
        foreach ($categories as $category) {

            if($category['Alt Kategoriler']!=null){
                $ct=Category::create([
                    'name' => $category['Kategori Adı'],
                    'image' => null,
                    'thumbnail' => null,
                    'content' => null,
                    'cat_ust' => null,
                    'status'=>'1'
                ]);

                foreach ($category['Alt Kategoriler'] as $subCategory) {
                    Category::create([
                        'name' => $subCategory['Alt Kategori Adı'],
                        'image' => null,
                        'thumbnail' => null,
                        'content' => null,
                        'cat_ust' => $ct->id,
                        'status'=>'1'
                    ]);
                }
            }
        }
        */
    }

}
