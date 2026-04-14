<x-laptop-layout>
    <x-slot name="title">Chi tiết: {{ $data->ten }}</x-slot>

    <div class="container mt-4">
        <div class="laptop-info">
            <div>
                <img src="{{ asset('storage/image/'.$data->hinh_anh) }}" class="img-fluid border" alt="{{ $data->ten }}">
            </div>

            <div>
                <h3 class="font-weight-bold">{{ $data->tieu_de }}</h3>
                <ul class="list-unstyled mt-3">
                    <li><strong>CPU:</strong> {{ $data->cpu }}</li>
                    <li><strong>RAM:</strong> {{ $data->ram }}</li>
                    <li><strong>Ổ cứng:</strong> {{ $data->luu_tru }}</li>
                    <li><strong>Chip đồ họa:</strong> {{ $data->chip_do_hoa }}</li>
                    <li><strong>Màn hình:</strong> {{ $data->man_hinh }}</li>
                    <li><strong>Hệ điều hành:</strong> {{ $data->he_dieu_hanh }}</li>
                    <li><strong>Nhu cầu:</strong> {{ $data->nhu_cau }}</li>
                    <li><strong>Giá:</strong> <span class="text-danger font-weight-bold h4">{{ number_format($data->gia, 0, ',', '.') }} VNĐ</span></li>
                </ul>

                <form action="{{ url('/cart/add') }}" method="POST" class="mt-4">
                    @csrf
                    <input type="hidden" name="id" value="{{ $data->id }}">
                    <div class="d-flex align-items-center">
                        <span class="mr-2">Số lượng mua:</span>
                        <input type="number" name="num" value="1" min="1" class="form-control mb-2 mr-sm-2" style="width: 80px;">
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
                    <tr><td width="200"><strong>Khối lượng:</strong></td><td>{{ $data->khoi_luong }}</td></tr>
                    <tr><td><strong>Webcam:</strong></td><td>{{ $data->webcam }}</td></tr>
                    <tr><td><strong>Pin:</strong></td><td>{{ $data->pin }}</td></tr>
                    <tr><td><strong>Kết nối không dây:</strong></td><td>{{ $data->ket_noi_khong_day }}</td></tr>
                    <tr><td><strong>Bàn phím:</strong></td><td>{{ $data->ban_phim }}</td></tr>
                    <tr><td><strong>Cổng kết nối:</strong></td><td>{!! $data->cong_ket_noi !!}</td></tr>
                </table>
            </div>
        </div>
    </div>
</x-laptop-layout>