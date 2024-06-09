@extends('frontend.layout.layout')

@section('content')
<section class="ps-lg-4 pe-lg-3 pt-4">
    <div class="row pt-5 pb-5">
        <div class="col-md-12">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <div class="card border-0 shadow">
                <div class="card-body">
                    <h2 class="h4 mb-4">Geçmiş Siparişlerim</h2>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Sipariş ID</th>
                                    <th scope="col">Tarih</th>
                                    <th scope="col">Ürün Adı</th>
                                    <th scope="col">Fiyat</th>
                                    <th scope="col">Durum</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d-m-Y') }}</td>
                                        <td>
                                            <ul style="list-style-type:none; padding: 0; margin: 0;">
                                                @php
                                                    $products = json_decode($order->products, true);
                                                @endphp
                                                @if(is_array($products))
                                                    @foreach($products as $productName => $productData)
                                                        @if(is_string($productName) && isset($productData['quantity']))
                                                            <li>{{ $productName }} - <span class="badge bg-primary">Miktar: {{ $productData['quantity'] }}</span></li>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    <li>No products found</li>
                                                @endif
                                            </ul>
                                        </td>
                                        <td>{{ $order->total_amount }}</td>
                                        <td>
                                            @if($order->status == 'Tamamlandı')
                                                <!-- İade Et butonu -->
                                                @php
                                                    $orderDate = \Carbon\Carbon::parse($order->order_date);
                                                    $currentDate = \Carbon\Carbon::now();
                                                    $daysPassed = $currentDate->diffInDays($orderDate);
                                                @endphp
                                                @if($daysPassed <= 14)
                                                    <span class="badge bg-success">Teslim Edildi</span>
                                                    <div class="float-end">
                                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#returnModal">
                                                            İade Et
                                                        </button>
                                                    </div>
                                                @else
                                                    <span class="badge bg-success">Teslim Edildi</span>
                                                @endif
                                                <!-- İade Nedenini Girmek İçin Modal -->
                                                <div class="modal fade" id="returnModal" tabindex="-1" aria-labelledby="returnModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="returnModalLabel">İade Nedeni</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form id="returnForm" action="{{ route('order.return', ['orderId' => $order->id]) }}" method="POST">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="mb-3">
                                                                        <label for="reason" class="form-label">İade Nedeni</label>
                                                                        <textarea class="form-control" id="reason" name="reason" rows="3" required></textarea>
                                                                    </div>
                                                                    <button type="submit" class="btn btn-danger">Gönder</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @elseif($order->status == 'Hazırlanıyor')
                                                <span class="badge bg-warning">{{ $order->status }}</span>
                                                <!-- İptal Et butonu -->
                                                <div class="float-end">
                                                    <form action="{{ route('order.cancel', ['orderId' => $order->id]) }}" method="POST">
                                                        @csrf <!-- CSRF koruması için gerekli alan -->
                                                        @method('PUT') <!-- HTTP PUT isteği göndermek için -->
                                                        <button type="submit" class="btn btn-sm btn-danger">İptal Et</button>
                                                    </form>
                                                </div>
                                            @else
                                                <span class="badge bg-info">{{ $order->status }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
@endsection