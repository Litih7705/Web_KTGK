<x-laptop-layout>
    <x-slot name="title">Chi tiết: {{ $laptop->ten }}</x-slot>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-5">
                <img src="{{ asset('storage/image/'.$laptop->hinh_anh) }}" class="img-fluid border" alt="{{ $laptop->ten }}">
            </div>

            <div class="col-md-7">
                <h3 class="font-weight-bold">{{ $laptop->tieu_de }}</h3>
                <ul class="list-unstyled mt-3">
                    <li><strong>CPU:</strong> {{ $laptop->cpu }}</li>
                    <li><strong>RAM:</strong> {{ $laptop->ram }}</li>
                    <li><strong>Ổ cứng:</strong> {{ $laptop->luu_tru }}</li>
                    <li><strong>Chip đồ họa:</strong> {{ $laptop->chip_do_hoa }}</li>
                    <li><strong>Màn hình:</strong> {{ $laptop->man_hinh }}</li>
                    <li><strong>Nhu cầu:</strong> {{ $laptop->nhu_cau }}</li>
                    <li><strong>Giá:</strong> <span class="text-danger font-weight-bold h4">{{ number_format($laptop->gia, 0, ',', '.') }} VNĐ</span></li>
                </ul>

                <form action="{{ url('/gio-hang/them') }}" method="POST" class="mt-4">
                    @csrf
                    <input type="hidden" name="id" value="{{ $laptop->id }}">
                    <div class="d-flex align-items-center">
                        <span class="mr-2">Số lượng mua:</span>
                        <input type="number" name="quantity" value="1" min="1" class="form-control mb-2 mr-sm-2" style="width: 80px;">
                        <button type="submit" class="btn btn-primary mb-2 ml-2">Thêm vào giỏ hàng</button>
                    </div>
                </form>
            </div>
        </div>

        <hr>

        <div class="row mt-4">
            <div class="col-12">
                <h4 class="text-primary border-bottom pb-2">Thông tin khác</h4>
                <table class="table table-borderless">
                    <tr><td width="200"><strong>Khối lượng:</strong></td><td>{{ $laptop->khoi_luong }}</td></tr>
                    <tr><td><strong>Webcam:</strong></td><td>{{ $laptop->webcam }}</td></tr>
                    <tr><td><strong>Pin:</strong></td><td>{{ $laptop->pin }}</td></tr>
                    <tr><td><strong>Kết nối không dây:</strong></td><td>{{ $laptop->ket_noi_khong_day }}</td></tr>
                    <tr><td><strong>Bàn phím:</strong></td><td>{{ $laptop->ban_phim }}</td></tr>
                    <tr><td><strong>Cổng kết nối:</strong></td><td>{{ $laptop->cong_ket_noi }}</td></tr>
                </table>
            </div>
        </div>
    </div>
</x-laptop-layout>