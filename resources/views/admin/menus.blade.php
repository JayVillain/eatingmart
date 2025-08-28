<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Menu - Admin Panel</title>
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
            --delete-color: #e74c3c;
            --edit-color: #f1c40f;
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

        .btn-group {
            display: flex;
            gap: 8px;
        }

        .btn-icon {
            padding: 8px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.9rem;
            transition: background-color 0.3s, transform 0.2s;
            color: var(--button-text-color);
        }

        .btn-edit {
            background-color: #007bff;
        }

        .btn-delete {
            background-color: var(--delete-color);
        }
        
        .btn-icon:hover {
            transform: translateY(-2px);
        }

        /* Modal Styling */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(5px);
            justify-content: center;
            align-items: center;
            z-index: 1000;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }
        
        .modal.is-active {
            display: flex;
            opacity: 1;
        }

        .modal-content {
            background-color: var(--card-bg);
            padding: 30px;
            border-radius: 12px;
            box-shadow: var(--shadow-medium);
            width: 90%;
            max-width: 550px;
            transform: translateY(-50px);
            transition: transform 0.3s ease-in-out;
        }
        
        .modal.is-active .modal-content {
            transform: translateY(0);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 15px;
        }
        
        .modal-header h2 {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-color);
        }
        
        .close-modal {
            background: none;
            border: none;
            font-size: 1.8rem;
            color: var(--text-color);
            cursor: pointer;
            transition: color 0.3s;
        }
        
        .close-modal:hover {
            color: var(--delete-color);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 1rem;
            color: var(--text-color);
            background-color: var(--input-bg);
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
        }
        
        #image-preview {
            max-width: 150px;
            max-height: 150px;
            margin-top: 15px;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            display: none;
        }
        
        #menu-form button {
            width: 100%;
            padding: 12px;
            background-color: var(--accent-color);
            color: var(--button-text-color);
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        #menu-form button:hover {
            background-color: #b02a37;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <aside class="sidebar">
            <div class="logo">Admin Panel</div>
            <ul class="nav-menu">
                <li class="nav-item"><a href="{{ route('admin.dashboard') }}"><i class="fa fa-tachometer"></i> Dashboard</a></li>
                <li class="nav-item"><a href="{{ route('admin.menus.index') }}" class="active"><i class="fa fa-cutlery"></i> Manajemen Menu</a></li>
                <li class="nav-item"><a href="{{ route('admin.orders.index') }}"><i class="fa fa-shopping-cart"></i> Manajemen Pesanan</a></li>
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
                <h1>Manajemen Menu</h1>
                <button id="add-menu-btn" class="action-button">Tambah Menu</button>
            </div>
            
            <div class="data-table-card">
                <table id="menus-table" class="data-table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="menus-table-body">
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="menu-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modal-title">Tambah Menu</h2>
                <button class="close-modal" onclick="closeModal()">&times;</button>
            </div>
            <form id="menu-form" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="menu-id" name="id">
                
                <div class="form-group">
                    <label for="menu-name">Nama Menu:</label>
                    <input type="text" id="menu-name" name="name" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="menu-description">Deskripsi:</label>
                    <textarea id="menu-description" name="description" class="form-control"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="menu-price">Harga:</label>
                    <input type="number" id="menu-price" name="price" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="menu-image">Gambar:</label>
                    <input type="file" id="menu-image" name="image" class="form-control">
                    <img id="image-preview" src="#" alt="Pratinjau Gambar">
                </div>
                
                <button type="submit" class="action-button">Simpan</button>
            </form>
        </div>
    </div>
    
    <script>
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    async function fetchMenus() {
        try {
            const response = await fetch('/admin/menus/list');
            const menus = await response.json();
            const tbody = document.getElementById('menus-table-body');
            tbody.innerHTML = '';

            if (menus && menus.length > 0) {
                menus.forEach(menu => {
                    const row = `<tr>
                        <td>${menu.name}</td>
                        <td>Rp${menu.price.toLocaleString('id-ID')}</td>
                        <td>
                            <div class="btn-group">
                                <button onclick="editMenu(${menu.id})" class="btn-icon btn-edit">Edit</button>
                                <button onclick="deleteMenu(${menu.id})" class="btn-icon btn-delete">Hapus</button>
                            </div>
                        </td>
                    </tr>`;
                    tbody.innerHTML += row;
                });
            } else {
                tbody.innerHTML = '<tr><td colspan="3" style="text-align: center;">Tidak ada data menu.</td></tr>';
            }
        } catch (error) {
            console.error('Error fetching menus:', error);
            alert('Gagal mengambil data menu. Periksa konsol.');
        }
    }

    document.getElementById('add-menu-btn').addEventListener('click', () => {
        document.getElementById('modal-title').textContent = 'Tambah Menu';
        document.getElementById('menu-id').value = '';
        document.getElementById('menu-form').reset();
        document.getElementById('image-preview').style.display = 'none';
        document.getElementById('menu-modal').classList.add('is-active');
    });

    async function editMenu(id) {
        try {
            const response = await fetch(`/admin/menus/${id}`);
            const menu = await response.json();
            
            document.getElementById('modal-title').textContent = 'Edit Menu';
            document.getElementById('menu-id').value = menu.id;
            document.getElementById('menu-name').value = menu.name;
            document.getElementById('menu-description').value = menu.description || '';
            document.getElementById('menu-price').value = menu.price;
            if (menu.image_url) {
                document.getElementById('image-preview').src = menu.image_url;
                document.getElementById('image-preview').style.display = 'block';
            } else {
                document.getElementById('image-preview').style.display = 'none';
            }
            
            document.getElementById('menu-modal').classList.add('is-active');
        } catch (error) {
            console.error('Error fetching menu for edit:', error);
            alert('Gagal mengambil data menu. Periksa konsol.');
        }
    }

    function closeModal() {
        document.getElementById('menu-modal').classList.remove('is-active');
    }

    document.getElementById('menu-form').addEventListener('submit', async (e) => {
        e.preventDefault();
        const id = document.getElementById('menu-id').value;
        const formData = new FormData(e.target);
        
        let url = id ? `/admin/menus/${id}` : '/admin/menus';
        let method = 'POST';

        if (id) {
            formData.append('_method', 'PUT');
        }

        try {
            const response = await fetch(url, {
                method: method,
                headers: {'X-CSRF-TOKEN': token},
                body: formData
            });

            if (response.ok) {
                closeModal();
                fetchMenus();
            } else {
                const error = await response.json();
                alert('Gagal menyimpan. ' + error.message);
            }
        } catch (error) {
            console.error('Error saving menu:', error);
            alert('Terjadi kesalahan saat menyimpan menu.');
        }
    });

    async function deleteMenu(id) {
        if (!confirm('Yakin ingin menghapus?')) return;
        try {
            const response = await fetch(`/admin/menus/${id}`, {
                method: 'DELETE',
                headers: {'X-CSRF-TOKEN': token}
            });
            if (response.ok) {
                fetchMenus();
            } else {
                alert('Gagal menghapus menu.');
            }
        } catch (error) {
            console.error('Error deleting menu:', error);
        }
    }
    
    window.onclick = function(event) {
        const modal = document.getElementById('menu-modal');
        if (event.target == modal) {
            closeModal();
        }
    }

    document.addEventListener('DOMContentLoaded', fetchMenus);
    </script>
</body>
</html>