<div class='mt-1'>
Số lượng mua:
<input type='number' id='product-number' size='5' min="1" value="1">
<button class='btn btn-success btn-sm mb-1' id='add-to-cart'>Thêm vào giỏ hàng</button>
</div>
<script>
$(document).ready(function() {
    /**
     * Xử lý sự kiện khi nhấn nút "Thêm vào giỏ hàng"
     */
    $("#add-to-cart").click(function(e) {
        e.preventDefault(); // Ngăn chặn hành động mặc định nếu có

        // Lấy thông tin sản phẩm
        const id = "{{ $data->id }}";
        const num = $("#product-number").val();

        // Kiểm tra số lượng hợp lệ trước khi gửi
        if (num < 1) {
            alert("Số lượng mua tối thiểu là 1");
            return;
        }

        // Sử dụng AJAX để gửi dữ liệu đến server
        $.ajax({
            type: "POST",
            url: "{{ route('cartadd') }}", // Đường dẫn xử lý thêm vào giỏ hàng
            dataType: "json",
            data: {
                "_token": "{{ csrf_token() }}", // Token bảo mật của Laravel
                "id": id,
                "num": num
            },
            beforeSend: function() {
                // Hiệu ứng nút bấm khi đang gửi dữ liệu
                $("#add-to-cart").prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Đang xử lý...');
            },
            success: function(data) {
                // Cập nhật số lượng sản phẩm trên icon giỏ hàng ở Header
                $("#cart-number-product").html(data);
                
                // Thông báo cho người dùng
                alert("Đã thêm laptop vào giỏ hàng thành công!");
            },
            error: function(xhr, status, error) {
                console.error("Lỗi giỏ hàng:", xhr.responseText);
                alert("Có lỗi xảy ra, vui lòng thử lại sau!");
            },
            complete: function() {
                // Khôi phục trạng thái nút bấm sau khi xử lý xong
                $("#add-to-cart").prop('disabled', false).html('Thêm vào giỏ hàng');
            }
        });
    });
});
</script>