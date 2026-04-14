<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Xac nhan dat hang</title>
</head>
<body style="font-family: Arial, sans-serif; color: #222; line-height: 1.5;">
    <h2 style="margin-bottom: 8px;">Xac nhan dat hang thanh cong</h2>
    <p>Xin chao {{ $customerName }},</p>
    <p>Don hang <strong>#{{ $orderId }}</strong> da duoc tao thanh cong.</p>

    <p><strong>Hinh thuc thanh toan:</strong> {{ $paymentMethod }}</p>

    <table cellpadding="8" cellspacing="0" border="1" style="border-collapse: collapse; width: 100%; max-width: 700px;">
        <thead style="background: #f3f3f3;">
            <tr>
                <th align="left">San pham</th>
                <th align="center">So luong</th>
                <th align="right">Don gia</th>
                <th align="right">Thanh tien</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
                <tr>
                    <td>{{ $item['title'] }}</td>
                    <td align="center">{{ $item['quantity'] }}</td>
                    <td align="right">{{ number_format($item['price'], 0, ',', '.') }}đ</td>
                    <td align="right">{{ number_format($item['line_total'], 0, ',', '.') }}đ</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" align="right"><strong>Tong cong</strong></td>
                <td align="right"><strong>{{ number_format($total, 0, ',', '.') }}đ</strong></td>
            </tr>
        </tfoot>
    </table>

    <p style="margin-top: 16px;">Thong bao nay da duoc gui den: <strong>{{ $recipientEmail }}</strong></p>
    <p>Cam on ban da dat hang.</p>
</body>
</html>
