<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pesanan - Admin Panel</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        :root {
            --bg-color: #f5f7f9;
            --card-bg: #ffffff;
            --text-color: #333333;
            --primary-color: #5a5f7d;
            --accent-color: #dc3545;
            --hover-color: #e9ecef;
            --border-color: #e0e0e0;
            --shadow-light: 0 4px 6px rgba(0, 0, 0, 0.05);
            --shadow-medium: 0 10px 15px rgba(0, 0, 0, 0.1);
            --button-text-color: #ffffff;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            line-height: 1.6;
        }

        .main-container {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: var(--card-bg);
            box-shadow: var(--shadow-light);
            padding: 20px;
            display: flex;
            flex-direction: column;
        }

        .logo {
            text-align: center;
            margin-bottom: 40px;
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-color);
        }

        .nav-menu {
            list-style: none;
        }

        .nav-item a, .nav-item button {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            margin-bottom: 10px;
            text-decoration: none;
            color: var(--text-color);
            font-weight: 500;
            border-radius: 8px;
            transition: background-color 0.3s, color 0.3s;
            background: none;
            border: none;
            width: 100%;
            cursor: pointer;
            text-align: left;
        }

        .nav-item a:hover,
        .nav-item button:hover,
        .nav-item a.active {
            background-color: var(--accent-color);
            color: var(--button-text-color);
        }
        
        .nav-item i {
            margin-right: 10px;
        }

        .content-area {
            flex-grow: 1;
            padding: 40px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .page-header h1 {
            font-size: 2rem;
            color: var(--primary-color);
            font-weight: 600;
        }

        .action-button {
            background-color: var(--accent-color);
            color: var(--button-text-color);
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 500;
            transition: background-color 0.3s;
        }

        .action-button:hover {
            background-color: #b02a37;
        }

        .data-table-card {
            background-color: var(--card-bg);
            border-radius: 12px;
            box-shadow: var(--shadow-medium);
            overflow: hidden;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th, .data-table td {
            padding: 15px 20px;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }

        .data-table th {
            background-color: var(--hover-color);
            color: var(--primary-color);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.9rem;
        }

        .data-table tbody tr:last-child td {
            border-bottom: none;
        }

        .data-table tbody tr:hover {
            background-color: var(--hover-color);
        }

        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.8rem;
            text-transform: uppercase;
        }
        
        .status-badge.pending_payment {
            background-color: #ffc107;
            color: #212529;
        }
        
        .status-badge.paid {
            background-color: #28a745;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <aside class="sidebar">
            <div class="logo">Admin Panel</div>
            <ul class="nav-menu">
                <li class="nav-item"><a href="{{ route('admin.dashboard') }}"><i class="fa fa-tachometer"></i> Dashboard</a></li>
                <li class="nav-item"><a href="{{ route('admin.menus.index') }}"><i class="fa fa-cutlery"></i> Manajemen Menu</a></li>
                <li class="nav-item"><a href="{{ route('admin.orders.index') }}" class="active"><i class="fa fa-shopping-cart"></i> Manajemen Pesanan</a></li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="action-button" style="width: 100%; text-align: left; background: none; color: var(--text-color); padding: 12px 15px; font-weight: 500;">
                            <i class="fa fa-sign-out"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </aside>
        
        <div class="content-area">
            <div class="page-header">
                <h1>Manajemen Pesanan</h1>
            </div>
            
            <div class="data-table-card">
                <table id="orders-table" class="data-table">
                    <thead>
                        <tr>
                            <th>ID Pesanan</th>
                            <th>Nama Pelanggan</th>
                            <th>VA Number</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="orders-table-body">
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    async function fetchOrders() {
        try {
            const response = await fetch('/admin/orders/list');
            const result = await response.json();
            const orders = result.data;
            const tableBody = document.getElementById('orders-table-body');
            tableBody.innerHTML = '';
            orders.forEach(order => {
                const statusClass = order.status;
                const row = `<tr>
                    <td>${order.id}</td>
                    <td>${order.user.name}</td>
                    <td>${order.virtual_account_number}</td>
                    <td>Rp${order.total_price.toLocaleString('id-ID')}</td>
                    <td><span class="status-badge ${statusClass}">${order.status.replace('_', ' ').toUpperCase()}</span></td>
                    <td>
                        ${order.status === 'pending_payment' ? `<button onclick="updateStatus(${order.id}, 'paid')" class="btn-action btn-pay">Tandai Sudah Dibayar</button>` : ''}
                    </td>
                </tr>`;
                tableBody.innerHTML += row;
            });
        } catch (error) {
            console.error('Error fetching orders:', error);
            alert('Gagal memuat daftar pesanan. Periksa konsol browser Anda.');
        }
    }

    async function updateStatus(id, status) {
        if (!confirm('Yakin ingin menandai pesanan ini sudah dibayar?')) return;
        const response = await fetch(`/admin/orders/${id}/status`, {
            method: 'PUT',
            headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': token},
            body: JSON.stringify({ status: status })
        });
        if (response.ok) {
            fetchOrders();
        } else {
            alert('Gagal memperbarui status pesanan.');
        }
    }
    
    document.addEventListener('DOMContentLoaded', fetchOrders);
    </script>
</body>
</html>