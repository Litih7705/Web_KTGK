<x-laptop-layout>
    <x-slot name='title'>
        Thanh toán đơn hàng
    </x-slot>

    <div class="container py-4">
        <div style='color:#15c; font-weight:bold; font-size:18px; text-align:center; margin-bottom: 20px;'>
            DANH SÁCH LAPTOP ĐANG ĐẶT MUA
        </div>
        
        <table class='table table-bordered shadow-sm' style='margin:0 auto; width:80%'>
            <thead class="bg-dark text-white text-center">
                <tr>
                    <th style="width: 50px;">STT</th>
                    <th>Tên sản phẩm</th>
                    <th style="width: 100px;">Số lượng</th>
                    <th style="width: 150px;">Đơn giá</th>
                    <th style="width: 100px;">Xóa</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $tongTien = 0;
                @endphp
                
                @forelse($data as $key => $row)
                    <tr>
                        <td align='center'>{{ $key + 1 }}</td>
                        <td class="pl-3">{{ $row->tieu_de }}</td>
                        <td align='center'>{{ $quantity[$row->id] }}</td>
                        <td align='center'>{{ number_format($row->gia, 0, ',', '.') }}đ</td>
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
                        $tongTien += $quantity[$row->id] * $row->gia;
                    @endphp
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">Giỏ hàng của bạn đang trống!</td>
                    </tr>
                @endforelse

                @if(count($data) > 0)
                <tr class="bg-light">
                    <td colspan='3' align='right'><strong>Tổng cộng tiền máy:</strong></td>
                    <td align='center' class="text-danger"><strong>{{ number_format($tongTien, 0, ',', '.') }}đ</strong></td>
                    <td></td>
                </tr>
                @endif
            </tbody>
        </table>
           
        <div class="mt-4 p-4 border rounded bg-light" style='width:80%; margin:0 auto; text-align:center;'>
            @auth
                @if(count($data) > 0)
                    <form method='post' action="{{ route('ordercreate') }}">
                        @csrf
                        <div class="form-group">
                            <label class="font-weight-bold">Hình thức thanh toán</label><br>
                            <div class="d-flex justify-content-center">
                                <select name='hinh_thuc_thanh_toan' class='form-control' style="max-width: 300px;">
                                    <option value='1'>Thanh toán khi nhận hàng (COD)</option>
                                    <option value='2'>Chuyển khoản qua ngân hàng</option>
                                    <option value='3'>Thanh toán qua ví điện tử VNPay</option>
                                </select>
                            </div>
                        </div>
                        <button type='submit' class='btn btn-primary px-5 font-weight-bold'>
                            XÁC NHẬN ĐẶT HÀNG
                        </button>
                    </form>
                @else
                    <div class="alert alert-warning">
                        Giỏ hàng trống, vui lòng quay lại trang sản phẩm để chọn laptop.
                    </div>
                @endif
            @else
                <div class="alert alert-info">
                    <i class="fa fa-info-circle"></i> Vui lòng <a href="{{ route('login') }}" class="font-weight-bold">đăng nhập</a> để tiến hành đặt hàng.
                </div>
            @endauth
        </div>
    </div>

    <style>
        .table thead th {
            vertical-align: middle;
            border-bottom: 2px solid #dee2e6;
        }
        .table td {
            vertical-align: middle;
        }
    </style>
</x-laptop-layout>