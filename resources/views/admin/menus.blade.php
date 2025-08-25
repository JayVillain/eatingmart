<!DOCTYPE html>
<html>
<head>
    <title>Manajemen Menu</title>
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
            --btn-delete-bg: #904040;
            --btn-delete-hover: #b05050;
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
        
        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-primary {
            background-color: var(--btn-primary-bg);
            color: var(--btn-primary-text);
        }
        
        .btn-primary:hover {
            background-color: var(--link-hover-color);
        }

        .btn-action {
            font-size: 0.9rem;
            padding: 6px 12px;
            border-radius: 6px;
        }
        
        .btn-edit {
            background-color: #2a6096;
            color: #fff;
        }
        
        .btn-delete {
            background-color: var(--btn-delete-bg);
            color: #fff;
        }
        
        .btn-edit:hover, .btn-delete:hover {
            opacity: 0.8;
        }

        /* Modal Styling */
        .modal {
            display: none;
            position: fixed;
            z-index: 10;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.6);
            backdrop-filter: blur(5px);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: var(--card-bg);
            padding: 30px;
            border-radius: 10px;
            width: 90%;
            max-width: 500px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border-color);
        }

        .modal-content h2 {
            margin-top: 0;
            color: var(--accent-color);
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .modal-content form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            background-color: var(--input-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            color: var(--text-color);
            box-sizing: border-box;
            transition: border-color 0.3s;
        }

        .form-control:focus {
            border-color: var(--accent-color);
            outline: none;
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
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Manajemen Menu</h1>
            <div class="nav-links">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                <a href="{{ route('admin.orders.index') }}">Manajemen Pesanan</a>
            </div>
            <button id="add-menu-btn" class="btn btn-primary">Tambah Menu</button>
        </div>
        
        <table id="menus-table" class="data-table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                </tbody>
        </table>
    </div>

    <div id="menu-modal" class="modal">
        <div class="modal-content">
            <h2>Tambah/Edit Menu</h2>
            <form id="menu-form" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="menu-id">
                <input type="text" id="menu-name" name="name" class="form-control" placeholder="Nama Menu" required>
                <textarea id="menu-description" name="description" class="form-control" placeholder="Deskripsi"></textarea>
                <input type="number" id="menu-price" name="price" class="form-control" placeholder="Harga" required>
                <input type="file" id="menu-image" name="image" class="form-control">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
    
    <script>
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    async function fetchMenus() {
        const response = await fetch('/admin/menus/list');
        const menus = await response.json();
        const tbody = document.querySelector('#menus-table tbody');
        tbody.innerHTML = '';
        menus.forEach(menu => {
            const row = `<tr>
                <td>${menu.name}</td>
                <td>${menu.price}</td>
                <td>
                    <button onclick="editMenu(${menu.id})" class="btn btn-action btn-edit">Edit</button>
                    <button onclick="deleteMenu(${menu.id})" class="btn btn-action btn-delete">Hapus</button>
                </td>
            </tr>`;
            tbody.innerHTML += row;
        });
    }

    document.getElementById('add-menu-btn').addEventListener('click', () => {
        document.getElementById('menu-id').value = '';
        document.getElementById('menu-form').reset();
        document.getElementById('menu-modal').style.display = 'flex';
    });

    // FUNGSI BARU UNTUK EDIT MENU
    async function editMenu(id) {
        try {
            const response = await fetch(`/admin/menus/list/${id}`);
            const menu = await response.json();
            
            document.getElementById('menu-id').value = menu.id;
            document.getElementById('menu-name').value = menu.name;
            document.getElementById('menu-description').value = menu.description;
            document.getElementById('menu-price').value = menu.price;
            document.getElementById('menu-modal').style.display = 'flex';
        } catch (error) {
            console.error('Error fetching menu for edit:', error);
            alert('Gagal mengambil data menu. Periksa konsol.');
        }
    }

    // FUNGSI UNTUK SUBMIT FORM (TAMBAH & EDIT)
    document.getElementById('menu-form').addEventListener('submit', async (e) => {
        e.preventDefault();
        const id = document.getElementById('menu-id').value;
        const formData = new FormData(e.target);
        
        let url = id ? `/admin/menus/${id}` : '/admin/menus';
        let method = id ? 'PUT' : 'POST';

        // Khusus untuk PUT, kita tidak bisa langsung menggunakan FormData dengan fetch.
        // Solusi yang lebih bersih adalah mengirimkan JSON atau menggunakan metode _method
        // Saya akan menggunakan metode _method seperti di form
        
        if (id) {
            formData.append('_method', 'PUT');
        }

        const response = await fetch(url, {
            method: 'POST', // Gunakan POST dan tambahkan _method=PUT
            headers: {'X-CSRF-TOKEN': token},
            body: formData
        });

        if (response.ok) {
            document.getElementById('menu-modal').style.display = 'none';
            fetchMenus();
        } else {
            const error = await response.json();
            alert('Gagal menyimpan. ' + error.message);
        }
    });

    async function deleteMenu(id) {
        if (!confirm('Yakin ingin menghapus?')) return;
        const response = await fetch(`/admin/menus/${id}`, {
            method: 'DELETE',
            headers: {'X-CSRF-TOKEN': token}
        });
        if (response.ok) fetchMenus();
    }

    fetchMenus();
    </script>
</body>
</html>