<x-laptop-layout>
    <x-slot name="title">
        Chi tiết laptop
    </x-slot>

    <div class="py-4">
        <div style="max-width: 900px; margin: 0 auto;">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="mb-0">Chi tiết sản phẩm</h3>
                    <a href="{{ route('admin.index') }}" class="btn btn-secondary btn-sm">Quay lại danh sách</a>
                </div>

                <div class="row g-4 align-items-start">
                    <div class="col-md-5 text-center">
                        @if($laptop->hinh_anh)
                            <img src="{{ asset('storage/image/' . $laptop->hinh_anh) }}" class="img-fluid rounded border" alt="{{ $laptop->tieu_de }}">
                        @else
                            <div class="border rounded p-5 text-muted">Không có hình ảnh</div>
                        @endif
                    </div>

                    <div class="col-md-7">
                        <table class="table table-bordered align-middle mb-0">
                            <tr>
                                <th style="width: 180px;">Tiêu đề</th>
                                <td>{{ $laptop->tieu_de }}</td>
                            </tr>
                            <tr>
                                <th>CPU</th>
                                <td>{{ $laptop->cpu }}</td>
                            </tr>
                            <tr>
                                <th>RAM</th>
                                <td>{{ $laptop->ram }}</td>
                            </tr>
                            <tr>
                                <th>Ổ cứng</th>
                                <td>{{ $laptop->luu_tru }}</td>
                            </tr>
                            <tr>
                                <th>Khối lượng</th>
                                <td>{{ $laptop->khoi_luong }}</td>
                            </tr>
                            <tr>
                                <th>Nhu cầu</th>
                                <td>{{ $laptop->nhu_cau }}</td>
                            </tr>
                            <tr>
                                <th>Giá</th>
                                <td class="text-danger fw-bold">{{ number_format($laptop->gia, 0, ',', '.') }}đ</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-laptop-layout>