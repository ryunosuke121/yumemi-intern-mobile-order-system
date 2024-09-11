<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>オーダーモニタ</title>
        @vite(['resources/js/app.js'])
    </head>
    <body>
        <h1>オーダーモニタ</h1>
        <ul id="order-list">
        </ul>
    </body>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tenantId = "{{ $tenant_id }}";
            const orderList = document.getElementById('order-list');

            Echo.private('tenants.' + tenantId)
                .listen('OrderEvent', (e) => {
                    const orderItem = e['orderItem'];
                    const li = document.createElement('li');
                    li.textContent = `オーダーID: ${orderItem["id"]}, 商品名: ${orderItem.item.name}, 個数: ${orderItem.quantity}`;
                    orderList.appendChild(li);
                });
        });
    </script>
</html>