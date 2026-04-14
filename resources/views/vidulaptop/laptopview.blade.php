<div class="row" id="laptop-list">
    @foreach($data as $row)
    <div class="col-md-3 mb-4">
        <div class="card h-100 laptop-item shadow-sm">
            <a href="{{ url('laptop/chitiet/'.$row->id) }}">
                <img src="{{ asset('storage/laptop_images/'.$row->file_anh) }}" class="card-img-top" alt="{{ $row->tieu_de }}" style="height: 200px; object-fit: cover;">
            </a>
            
            <div class="card-body text-center d-flex flex-column">
                <h6 class="card-title font-weight-bold">{{ $row->tieu_de }}</h6>
                <p class="card-text text-danger mt-auto">{{ number_format($row->gia_ban, 0, ",", ".") }}đ</p>
                
                <div class="btn-add-product mt-2">
                    <button class="btn btn-success btn-sm btn-block add-product" laptop_id="{{ $row->id }}">
                        <i class="fa fa-cart-plus"></i> Thêm vào giỏ hàng
                    </button> 
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>