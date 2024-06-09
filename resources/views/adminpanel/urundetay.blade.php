<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kupon Admin</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Roboto', Arial, sans-serif;
      line-height: 1.6;
      margin: 0;
      padding: 20px;
      background-color: #f9f9f9;
    }
    .container {
      max-width: 800px;
      margin: 0 auto;
      background-color: #fff;
      padding: 20px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      border-radius: 8px;
    }
    h1 {
      text-align: center;
      margin-bottom: 20px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }
    th, td {
      border: 1px solid #ddd;
      padding: 12px;
      text-align: left;
      vertical-align: middle;
    }
    th {
      background-color: #f2f2f2;
      font-weight: 500;
    }
    tr:hover {
      background-color: #f1f1f1;
    }
    .back-btn {
      display: block;
      margin-bottom: 20px;
      text-align: center;
      text-decoration: none;
      color: #007bff;
      font-weight: 500;
    }
    .back-btn:hover {
      text-decoration: underline;
    }
    ul {
      list-style-type: none;
      padding: 0;
      margin: 0;
    }
    img {
      max-width: 200px;
      margin-bottom: 10px;
      border: 1px solid #ddd;
      border-radius: 4px;
    }
    a {
      color: #007bff;
      text-decoration: none;
    }
    a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="container">
    <a href="/urunlistele" class="back-btn">&lt;&lt; Geri</a>
    @foreach($products as $product)
      @php
        $productcategories = json_decode($product->categories, true);
        $productimages = json_decode($product->images, true);
        $firstimage = isset($productimages[0]) ? $productimages[0] : null;
        $secondimage = isset($productimages[1]) ? $productimages[1] : null;
        $thirdimage = isset($productimages[2]) ? $productimages[2] : null;
        $fourthimage = isset($productimages[3]) ? $productimages[3] : null;
        $fifthimage = isset($productimages[4]) ? $productimages[4] : null;
      @endphp
      <h1>Ürün Detayları</h1>
      <table>
        <tr>
          <th>Ürün Numarası</th>
          <td>{{$product->id}}</td>
        </tr>
        <tr>
          <th>Kategorileri</th>
          <td>
            <ul>
              @foreach($productcategories as $productcategory)
                <li>{{$productcategory['name'] ?? ''}}</li>
              @endforeach
            </ul>
          </td>
        </tr>
        <tr>
          <th>Fotoğraflar</th>
          <td>
            @if($firstimage)
              <img src="{{ asset('/') }}{{ $firstimage }}" alt="Ürün Resmi">
            @endif
            @if($secondimage)
              <img src="{{ asset('/') }}{{ $secondimage }}" alt="Ürün Resmi">
            @endif
            @if($thirdimage)
              <img src="{{ asset('/') }}{{ $thirdimage }}" alt="Ürün Resmi">
            @endif
            @if($fourthimage)
              <img src="{{ asset('/') }}{{ $fourthimage }}" alt="Ürün Resmi">
            @endif
            @if($fifthimage)
              <img src="{{ asset('/') }}{{ $fifthimage }}" alt="Ürün Resmi">
            @endif
          </td>
        </tr>
        <tr>
          <th>Fiyat</th>
          <td>{{$product->price}}</td>
        </tr>
        <tr>
          <th>Stok</th>
          <td>{{$product->qty}}</td>
        </tr>
        <tr>
          <th>Ürün İçeriği</th>
          <td>{!! html_entity_decode($product->content) !!}</td>
        </tr>
      </table>
    @endforeach
  </div>
</body>
</html>
