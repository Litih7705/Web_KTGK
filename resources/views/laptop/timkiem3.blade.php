<x-laptop-layout>
    <x-slot name="title">Kết quả tìm kiếm</x-slot>

    <h4 class="mt-4 mb-4">Kết quả tìm kiếm cho: <span class="text-danger">"{{ $keyword }}"</span></h4>

    <div class="list-laptop">
        @if(count($laptops) > 0)
            @foreach($laptops as $row)
                <div class="laptop">
                    <a href="{{ url('laptop/chitiet/' . $row->id) }}">
                        <img src="{{ asset('storage/image/' . $row->hinh_anh) }}" width="100%" class="p-2" alt="{{ $row->tieu_de }}">
                        <div class="p-2">
                            <b style="font-size: 13px; display:block; height: 40px; overflow: hidden;">{{ $row->tieu_de }}</b>
                            <i class="text-danger font-weight-bold d-block mt-2">{{ number_format($row->gia, 0, ',', '.') }}đ</i>
                        </div>
                    </a>
                    <button class="btn btn-success btn-sm mb-2">Thêm vào giỏ hàng</button>
                </div>
            @endforeach
        @else
            <div class="alert alert-warning" style="grid-column: span 5;">
                Không tìm thấy laptop nào khớp với từ khóa của bạn.
            </div>
        @endif
    </div>
</x-laptop-layout>