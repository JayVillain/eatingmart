<!DOCTYPE html>
<html>
<head>
    <title>Manajemen Menu</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <h1>Manajemen Menu</h1>
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <a href="{{ route('admin.orders.index') }}">Manajemen Pesanan</a>
    <button id="add-menu-btn">Tambah Menu</button>
    
    <div id="menu-modal" style="display:none;">
        <form id="menu-form" enctype="multipart/form-data">
            <input type="hidden" id="menu-id">
            <input type="text" id="menu-name" placeholder="Nama Menu">
            <textarea id="menu-description" placeholder="Deskripsi"></textarea>
            <input type="number" id="menu-price" placeholder="Harga">
            <input type="file" id="menu-image">
            <button type="submit">Simpan</button>
        </form>
    </div>

    <table id="menus-table">
        <thead>
            <tr><th>Nama</th><th>Harga</th><th>Aksi</th></tr>
        </thead>
        <tbody></tbody>
    </table>
    
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
                <td><button onclick="editMenu(${menu.id})">Edit</button><button onclick="deleteMenu(${menu.id})">Hapus</button></td>
            </tr>`;
            tbody.innerHTML += row;
        });
    }

    document.getElementById('add-menu-btn').addEventListener('click', () => {
        document.getElementById('menu-modal').style.display = 'block';
    });

    document.getElementById('menu-form').addEventListener('submit', async (e) => {
        e.preventDefault();
        const id = document.getElementById('menu-id').value;
        const formData = new FormData(e.target);
        
        let url = id ? `/admin/menus/${id}/update` : '/admin/menus';
        let method = 'POST';

        const response = await fetch(url, {
            method: method,
            headers: {'X-CSRF-TOKEN': token},
            body: formData
        });

        if (response.ok) {
            document.getElementById('menu-modal').style.display = 'none';
            fetchMenus();
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