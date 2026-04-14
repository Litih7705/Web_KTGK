<div class='mt-1'>
    Số lượng mua:
    <input type='number' id='product-number' size='5' min="1" value="1" class="form-control d-inline-block" style="width: 80px;">
    <button class='btn btn-primary btn-sm mb-1' id='add-to-cart'>
        <i class="fa fa-cart-plus"></i> Thêm vào giỏ hàng
    </button>
</div>

<script>
$(document).ready(function() {
    // Xử lý sự kiện khi nhấn nút Thêm bằng Jquery
    $("#add-to-cart").click(function() {
        
        // Lấy ID laptop và số lượng từ giao diện
        // Lưu ý: Biến $data ở đây giả định là thông tin của 1 chiếc Laptop từ Controller truyền qua
        const id = "{{ $data->id }}"; 
        const num = $("#product-number").val();
        
        // Sử dụng ajax để gửi dữ liệu đến LaptopOrderController
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{ route('cartadd') }}", // Route đã trỏ đến LaptopOrderController@cartadd
            
            // Dữ liệu bao gồm Token bảo mật, ID laptop và số lượng
            data: {
                "_token": "{{ csrf_token() }}",
                "id": id,
                "num": num
            },
            
            beforeSend: function() {
                // Vô hiệu hóa nút để tránh nhấn nhiều lần
                $("#add-to-cart").prop('disabled', true).html('Đang xử lý...');
            },

            success: function(data) {
                // 'data' trả về từ Controller là count($cart)
                // Cập nhật số lượng hiển thị trên icon giỏ hàng ở Header
                $("#cart-number-product").html(data);
                
                // Thông báo nhẹ cho người dùng
                alert("Đã thêm laptop vào giỏ hàng thành công!");
            },

            error: function(xhr, status, error) {
                console.error("Lỗi hệ thống: " + error);
                alert("Có lỗi xảy ra, vui lòng thử lại sau.");
            },

            complete: function(xhr, status) {
                // Khôi phục lại trạng thái nút bấm
                $("#add-to-cart").prop('disabled', false).html('<i class="fa fa-cart-plus"></i> Thêm vào giỏ hàng');
            }
        });
    });
});
</script>