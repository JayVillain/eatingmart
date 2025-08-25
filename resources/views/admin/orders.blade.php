<!DOCTYPE html>
<html>
<head>
    <title>Manajemen Pesanan</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <h1>Manajemen Pesanan</h1>
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <a href="{{ route('admin.menus.index') }}">Manajemen Menu</a>

    <table id="orders-table">
        <thead>
            <tr><th>ID Pesanan</th><th>Status</th><th>Aksi</th></tr>
        </thead>
        <tbody></tbody>
    </table>

    <script>
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    async function fetchOrders() {
        const response = await fetch('/admin/orders/list');
        const orders = await response.json();
        const tbody = document.querySelector('#orders-table tbody');
        tbody.innerHTML = '';
        orders.forEach(order => {
            const row = `<tr>
                <td>${order.id}</td>
                <td>${order.status}</td>
                <td><button onclick="updateStatus(${order.id}, 'paid')">Sudah Dibayar</button></td>
            </tr>`;
            tbody.innerHTML += row;
        });
    }

    async function updateStatus(id, status) {
        const response = await fetch(`/admin/orders/${id}/status`, {
            method: 'PUT',
            headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': token},
            body: JSON.stringify({ status: status })
        });
        if (response.ok) fetchOrders();
    }
    
    fetchOrders();
    </script>
</body>
</html>