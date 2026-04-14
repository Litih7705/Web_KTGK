
<x-laptop-layout2>
    <x-slot name="title">
        Danh mục Laptop
    </x-slot>

    <div class="container text-center my-3">
        <span class="font-weight-bold">Sắp xếp theo: </span>
        <a href="{{ request()->fullUrlWithQuery(['sort' => 'asc']) }}" class="btn btn-sm btn-outline-dark">Giá tăng dần</a>
        <a href="{{ request()->fullUrlWithQuery(['sort' => 'desc']) }}" class="btn btn-sm btn-outline-dark">Giá giảm dần</a>
    </div>

    <div class="list-laptop"> 
        @if(isset($laptops) && $laptops->count() > 0)
            @foreach($laptops as $item)
                <div class="laptop"> 
                    <a href="{{ route('laptop.detail2', $item->id) }}">
                        <img src="{{ asset('storage/image/'.$item->hinh_anh) }}" width="100%" alt="{{ $item->ten }}"> [cite: 18]
                        <div class="laptop-info p-2"> 
                            <div class="name-box mb-2" style="height: 3rem; overflow: hidden;">
                                <h6 class="text-dark m-0">{{ $item->tieu_de }}</h6> [cite: 7]
                            </div>
                            <div class="price-box">
                                <p class="text-danger font-weight-bold m-0">
                                    {{ number_format($item->gia, 0, ',', '.') }} VNĐ
                                </p> [cite: 7]
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        @else
            <div class="col-12 text-center mt-5">
                <p>Không có sản phẩm nào thuộc thương hiệu này.</p>
            </div>
        @endif
    </div>
</x-laptop-layout2>