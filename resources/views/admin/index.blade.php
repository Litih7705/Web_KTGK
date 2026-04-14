<x-laptop-layout>
    <x-slot name="title">
        Admin Dashboard
    </x-slot>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <div class="py-4">
        <div class="container mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table id="laptopTable" class="table table-bordered table-hover align-middle">
                        <thead class="table-dark text-center">
                            <tr>
                                <th>STT</th>
                                <th>Tiêu đề</th>
                                <th>CPU</th>
                                <th>RAM</th>
                                <th>Ổ cứng</th>
                                <th>Khối lượng</th>
                                <th>Nhu cầu</th>
                                <th>Giá</th>
                                <th>Ảnh</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($laptops as $key => $item)
                            <tr>
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td class="fw-bold">{{ $item->tieu_de }}</td>
                                <td>{{ $item->cpu }}</td>
                                <td class="text-center">{{ $item->ram }}</td>
                                <td>{{ $item->luu_tru }}</td>
                                <td class="text-center">{{ $item->khoi_luong }}</td>
                                <td>{{ $item->nhu_cau }}</td>
                                <td class="text-danger fw-bold text-center">{{ number_format($item->gia, 0, ',', '.') }}đ</td>
                                <td class="text-center">
                                    @if($item->hinh_anh)
                                        <img src="{{ asset('storage/image/' . $item->hinh_anh) }}" width="70" class="img-thumbnail">
                                    @else
                                        <span class="badge bg-secondary">No Image</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex gap-1 justify-content-center">
                                        <a href="{{ url('/laptop/'.$item->id) }}" class="btn btn-primary btn-sm">Xem</a>
                                        <form action="{{ route('admin.destroy', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Xóa mềm sản phẩm này?')">Xóa</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            if ( ! $.fn.DataTable.isDataTable( '#laptopTable' ) ) {
                $('#laptopTable').DataTable({
                    "pageLength": 10,
                    "language": {
                        "lengthMenu": "Hiển thị _MENU_ dòng",
                        "zeroRecords": "Không tìm thấy dữ liệu",
                        "info": "Trang _PAGE_ / _PAGES_",
                        "search": "Tìm kiếm:",
                        "paginate": {
                            "next": "Sau",
                            "previous": "Trước"
                        }
                    }
                });
            }
        });
    </script>
</x-laptop-layout>