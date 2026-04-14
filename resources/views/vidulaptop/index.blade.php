<x-laptop-layout>
    <x-slot name='title'>
        Giỏ hàng - Đặt hàng Laptop
    </x-slot>

    <div class="container py-4">
        <div style='color:#15c; font-weight:bold; font-size:18px; text-align:center; margin-bottom: 20px;'>
            DANH SÁCH LAPTOP TRONG GIỎ HÀNG
        </div>

        <div class="table-responsive">
            <table class='table table-bordered' style='margin:0 auto; width:85%'>
                <thead class="bg-light text-center">
                    <tr>
                        <th style="width: 50px;">STT</th>
                        <th>Tên Laptop</th>
                        <th style="width: 100px;">Số lượng</th>
                        <th style="width: 150px;">Đơn giá</th>
                        <th style="width: 100px;">Xóa</th>
                    </tr>
                </thead>
                <tbody>
                    @php $tongTien = 0; @endphp
                    
                    @if(isset($data_cart) && count($data_cart) > 0)
                        @foreach($data_cart as $key => $row)
                            <tr>
                                <td align='center'>{{ $key + 1 }}</td>
                                <td class="pl-3"><strong>{{ $row->tieu_de }}</strong></td>
                                <td align='center'>{{ $quantity[$row->id] ?? 1 }}</td>
                                <td align='center'>{{ number_format($row->gia_ban, 0, ',', '.') }}đ</td>
                                <td align='center'>
                                    <form method='post' action="{{ route('cartdelete') }}">
                                        @csrf
                                        <input type='hidden' value='{{ $row->id }}' name='id'>
                                        <button type='submit' class='btn btn-sm btn-outline-danger'>
                                            <i class="fa fa-trash"></i> Xóa
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @php
                                $qty = $quantity[$row->id] ?? 1;
                                $tongTien += $qty * $row->gia_ban;
                            @endphp
                        @endforeach
                        
                        <tr class="bg-light">
                            <td colspan='3' align='right' class="font-weight-bold">TỔNG CỘNG:</td>
                            <td align='center' class="text-danger font-weight-bold">{{ number_format($tongTien, 0, ',', '.') }}đ</td>
                            <td></td>
                        </tr>
                    @else
                        <tr>
                            <td colspan="5" class="text-center py-4">Giỏ hàng của bạn đang trống!</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        @auth
            @if(isset($data_cart) && count($data_cart) > 0)
                <div class="mt-4 card p-4 shadow-sm border-0 bg-light" style="width:85%; margin: 0 auto; text-align:center;">
                    <form method='post' action="{{ route('ordercreate') }}">
                        @csrf
                        <div class="form-group">
                            <label class="font-weight-bold">Chọn hình thức thanh toán</label>
                            <div class="d-flex justify-content-center">
                                <select name='hinh_thuc_thanh_toan' class='form-control' style="max-width: 300px;">
                                    <option value='1'>Tiền mặt (COD)</option>
                                    <option value='2'>Chuyển khoản</option>
                                    <option value='3'>Ví điện tử / VNPay</option>
                                </select>
                            </div>
                        </div>
                        <button type='submit' class='btn btn-primary px-5 py-2 font-weight-bold'>XÁC NHẬN ĐẶT HÀNG</button>
                    </form>
                </div>
            @endif
        @else
            <div class="alert alert-info py-3 mt-3 text-center" style="width:85%; margin: 0 auto;">
                Vui lòng <a href="{{ route('login') }}" class="font-weight-bold">đăng nhập</a> để đặt hàng.
            </div>
        @endauth

        <hr class="my-5">

        <div style='color:#15c; font-weight:bold; font-size:18px; text-align:center; margin-bottom: 20px;'>
            KHÁM PHÁ CÁC DÒNG LAPTOP KHÁC
        </div>

        <div id='laptop-view-div'>
            <div class='row list-laptop'>
                @foreach($data as $row)
                    <div class='col-md-3 mb-4'>
                        <div class='card h-100 laptop-card shadow-sm text-center border-0'>
                            <a href="{{ url('laptop/chitiet/'.$row->id) }}" class="text-decoration-none text-dark">
                                <div class="p-3">
                                    <img src="{{ asset('storage/laptop_image/'.$row->file_anh) }}" 
                                         class="card-img-top img-fluid" 
                                         style="max-height: 150px; object-fit: contain;">
                                </div>
                                <div class='card-body p-2'>
                                    <h6 class='font-weight-bold mb-1' style="font-size: 14px;">{{ $row->tieu_de }}</h6>
                                    <p class='text-danger font-weight-bold mb-0'>{{ number_format($row->gia_ban, 0, ",", ".") }}đ</p>
                                </div>
                            </a> 
                            <div class='card-footer bg-transparent border-0 pb-3'>
                                <button class='btn btn-success btn-sm btn-block add-product' laptop_id="{{ $row->id }}">
                                    <i class="fa fa-cart-plus"></i> Mua ngay
                                </button> 
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            // 1. Ajax thêm sản phẩm vào giỏ hàng
            $(document).on('click', '.add-product', function(){
                var id = $(this).attr("laptop_id");
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ route('cartadd') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": id,
                        "num": 1
                    },
                    success: function(data){
                        $("#cart-number-product").html(data);
                        alert("Đã thêm Laptop vào giỏ hàng!");
                        location.reload(); // Reload để cập nhật bảng giỏ hàng phía trên
                    }
                });
            });

            // 2. Ajax lọc Laptop theo danh mục (Click vào menu)
            $(".menu-the-loai").click(function(e){
                e.preventDefault();
                var the_loai = $(this).attr("the_loai");
                $.ajax({
                    type: "POST",
                    dataType: "html",
                    url: "{{ route('laptopview') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "the_loai": the_loai
                    },
                    beforeSend: function() {
                        $("#laptop-view-div").css("opacity", "0.5");
                    },
                    success: function(data){
                        $("#laptop-view-div").html(data);
                        $("#laptop-view-div").css("opacity", "1");
                    }
                });
            });
        });
    </script>

    <style>
        .table-bordered th, .table-bordered td { border: 1px solid #dee2e6 !important; vertical-align: middle; }
        .laptop-card { transition: 0.3s; border-radius: 10px; overflow: hidden; }
        .laptop-card:hover { transform: translateY(-5px); box-shadow: 0 5px 15px rgba(0,0,0,0.1) !important; }
        .btn-primary { background-color: #15c; border: none; }
    </style>
</x-laptop-layout>