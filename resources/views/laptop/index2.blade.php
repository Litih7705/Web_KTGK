<x-laptop-layout>
    <x-slot name="title">
        Laptop - Trang chủ
    </x-slot>

    <div class="container text-center my-3">
        <span class="font-weight-bold">Tìm kiếm theo: </span>
        <a href="{{ request()->fullUrlWithQuery(['sort' => 'asc']) }}" class="btn btn-sm btn-outline-dark">Giá tăng dần</a>
        <a href="{{ request()->fullUrlWithQuery(['sort' => 'desc']) }}" class="btn btn-sm btn-outline-dark">Giá giảm dần</a>
    </div>

    <div class="list-laptop"> 
        @if(isset($laptops) && count($laptops) > 0)
            @foreach($laptops as $item)
                <div class="laptop"> 
                    <a href="{{ route('laptop.detail2', $item->id) }}">
                        <img src="{{ asset('storage/image/'.$item->hinh_anh) }}" width="100%" alt="{{ $item->ten }}">
                        
                        <div class="laptop-info p-2" style="display: block !important;"> 
                            
                            <div style="display: block; width: 100%; height: 80px; overflow: hidden; margin-bottom: 5px;">
                                <h6 style="color: black; margin: 0; font-size: 13px; line-height: 20px;">
                                    {{ $item->tieu_de }}
                                </h6>
                            </div>
                            
                            <div style="display: block; width: 100%;">
                                <p style="color: red; font-weight: bold; margin: 0; font-size: 14px;">
                                    {{ number_format($item->gia, 0, ',', '.') }} VNĐ
                                </p>
                            </div>

                        </div>
                    </a>
                </div>
            @endforeach
        @else
            <div class="col-12 text-center mt-5">
                <p>Không tìm thấy sản phẩm nào phù hợp.</p>
            </div>
        @endif
    </div>
</x-laptop-layout>