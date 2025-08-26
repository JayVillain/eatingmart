<!DOCTYPE html>
<html>
<head>
    <title>Manajemen Pesanan</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');

        :root {
            --bg-color: #0c0d10;
            --card-bg: #1a1c20;
            --text-color: #e0e0e0;
            --accent-color: #B29B7F;
            --border-color: rgba(255, 255, 255, 0.05);
            --input-bg: #2b2e33;
            --hover-color: #444;
            --btn-primary-bg: #B29B7F;
            --btn-primary-text: #1a1c20;
            --btn-status-bg-pending: #a08c6f;
            --btn-status-hover: #b29b7f;
            --font-family: 'Roboto', sans-serif;
            --shadow: 0 8px 24px rgba(0, 0, 0, 0.5);
        }

        body {
            font-family: var(--font-family);
            background-color: var(--bg-color);
            color: var(--text-color);
            margin: 0;
            padding: 40px;
            box-sizing: border-box;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            background-color: var(--card-bg);
            padding: 40px;
            border-radius: 12px;
            box-shadow: var(--shadow);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 20px;
        }

        .header h1 {
            font-size: 2.5rem;
            color: var(--accent-color);
            margin: 0;
        }

        .header .nav-links {
            display: flex;
            gap: 20px;
        }

        .header .nav-links a {
            text-decoration: none;
            color: var(--text-color);
            font-weight: 500;
            transition: color 0.3s;
        }

        .header .nav-links a:hover {
            color: var(--accent-color);
        }

        /* Table Styling */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .data-table th, .data-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }

        .data-table th {
            color: var(--accent-color);
            font-weight: 500;
            text-transform: uppercase;
            font-size: 0.9rem;
        }
        
        .data-table tbody tr:hover {
            background-color: var(--input-bg);
        }
        
        /* Status Badges */
        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.8rem;
            text-transform: uppercase;
        }
        
        .status-badge.pending_payment {
            background-color: #b29b7f;
            color: #1a1c20;
        }
        
        .status-badge.paid {
            background-color: #4CAF50;
            color: #fff;
        }

        /* Action Button */
        .btn-action {
            font-size: 0.9rem;
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .btn-pay {
            background-color: #4CAF50;
            color: #fff;
        }
        
        .btn-pay:hover {
            background-color: #66bb6a;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Manajemen Pesanan</h1>
            <div class="nav-links">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                <a href="{{ route('admin.menus.index') }}">Manajemen Menu</a>
            </div>
        </div>

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
            alert('Gagal memuat daftar pesanan. Cek konsol browser Anda.');
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