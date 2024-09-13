<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>オーダーモニタ</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        @vite(['resources/js/app.js'])
    </head>
    <body>
        <div class="container">
            <h1>オーダーモニタ</h1>
            <table id='order-table' class="table">
                <thead>
                    <tr>
                        <th>オーダーID</th>
                        <th>商品名</th>
                        <th>数量</th>
                        <th>ステータス</th>
                        <th>注文日時</th>
                    </tr>
                </thead>
                <tbody id='order-table-body'>
                    </tbody>
                </table>
            </table>
        </div>
    </body>
    <script>
        const tenantId = "{{ $tenant_id }}";
        const orderTableBody = document.getElementById('order-table-body');
        document.addEventListener('DOMContentLoaded', function () {

            fetch('/api/orders', {
                headers: {
                    Authorization: `Bearer ${sessionStorage.getItem('token')}`
                },
            })
            .then(response => response.json())
            .then(data => {
                for (const order of data) {
                    for (const orderItem of order.order_items) {
                        addOrderItem(orderItem);
                    }
                }
            });

            Echo.private('tenants.' + tenantId)
                .listen('OrderEvent', (e) => {
                    const orderItem = e['orderItem'];
                    addOrderItem(orderItem);
                });
            
            Echo.private('tenants.' + tenantId)
                .listen('OrderStatusChangedEvent', (e) => {
                    const orderItem = e['orderItem'];
                    const tr = document.getElementById(`order-${orderItem["id"]}`);
                    tr.innerHTML = `
                        <td>${orderItem["id"]}</td>
                        <td>${orderItem.item.name}</td>
                        <td>${orderItem.quantity}</td>
                        <td>${orderItem.status}</td>
                        <td>${orderItem.created_at}</td>
                    `;
                });
        });

        function addOrderItem(orderItem) {
            const tr = document.createElement('tr');
            tr.id = `order-${orderItem["id"]}`;
            tr.innerHTML = `
                <td>${orderItem["id"]}</td>
                <td>${orderItem.item.name}</td>
                <td>${orderItem.quantity}</td>
                <td>${orderItem.status}</td>
                <td>${orderItem.created_at}</td>
            `;
            orderTableBody.appendChild(tr);
        }
    </script>
</html>