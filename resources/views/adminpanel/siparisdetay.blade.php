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
    select, button {
      padding: 8px 12px;
      margin-right: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 14px;
    }
    button {
      background-color: #007bff;
      color: #fff;
      cursor: pointer;
      border: none;
    }
    button:hover {
      background-color: #0056b3;
    }
    ul {
      list-style-type: none;
      padding: 0;
      margin: 0;
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
    <a href="/siparistakip" class="back-btn">&lt;&lt; Geri</a>
    @foreach($orders as $order)
    <h1>Sipariş Detayları</h1>
    <form method="POST" action="{{ route('order.updateStatus', ['id' => $order->id]) }}">
      @csrf
      @method('PUT')
    <table>
      <tr>
        <th>Sipariş Numarası</th>
        <td>{{$order->id}}</td>
      </tr>
      <tr>
        <th>Ürünler ve Miktarı</th>
        <td style="border: 1px solid black;" scope="col">
          <ul>
            @php
              $products = json_decode($order->products, true);
            @endphp
            @if(is_array($products))
              @foreach($products as $productName => $productData)
                <li>
                  <a href="{{ route('productdetail', $productData['slug']) }}" target="_blank">{{ $productName }}</a>
                  - Miktar: {{ $productData['quantity'] }}
                </li>
              @endforeach
            @else
              <li>No products found</li>
            @endif
          </ul>
        </td>
      </tr>
      <tr>
        <th>Ad</th>
        <td>{{$order->delivery_name}}</td>
      </tr>
      <tr>
        <th>Soyad</th>
        <td>{{$order->delivery_surname}}</td>
      </tr>
      <tr>
        <th>Telefon</th>
        <td>{{$order->delivery_phone}}</td>
      </tr>
      <tr>
        <th>Adres</th>
        <td>{{$order->delivery_address}}</td>
      </tr>
      <tr>
        <th>E-Mail</th>
        <td>{{$order->delivery_email}}</td>
      </tr>
      <tr>
        <th>Sipariş Notu</th>
        <td>{{$order->delivery_note}}</td>
      </tr>
      <tr>
        <th>Toplam Ücret</th>
        <td>{{$order->total_amount}}</td>
      </tr>
      <tr>
        <th>Durum</th>
        <td>
          <select name="status">
            <option value="Hazırlanıyor" {{ $order->status === 'Hazırlanıyor' ? 'selected' : '' }}>Hazırlanıyor</option>
            <option value="Kargoya verildi" {{ $order->status === 'Kargoya verildi' ? 'selected' : '' }}>Kargoya verildi</option>
            <option value="Tamamlandı" {{ $order->status === 'Tamamlandı' ? 'selected' : '' }}>Tamamlandı</option>
          </select>
          <button type="submit">Durumu Güncelle</button>
        </td>
      </tr>
      <tr>
        <th>Sipariş Tarihi</th>
        <td class="py-1">{{ \Carbon\Carbon::parse($order->created_at)->format('d-m-Y H:i:s') }}</td>
      </tr>
    </table>
    </form>
    @endforeach
  </div>
</body>
</html>
