<!DOCTYPE html>
<html>
<head>
  <title>Contoh Tampilan Data</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 800px;
      margin: 0 auto;
      padding: 20px;
    }

    h1 {
      margin-top: 0;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th, td {
      padding: 8px;
      border: 1px solid #ccc;
    }

    th {
      background-color: #f2f2f2;
      font-weight: bold;
    }

    form {
      margin-top: 20px;
    }

    label {
      display: block;
      margin-bottom: 5px;
    }

    input[type="text"], input[type="number"], input[type="submit"] {
      padding: 5px;
      width: 100%;
    }

    input[type="submit"] {
      margin-top: 10px;
      background-color: #4caf50;
      color: white;
      border: none;
      cursor: pointer;
    }

    button {
      padding: 5px 10px;
      background-color: #f44336;
      color: white;
      border: none;
      cursor: pointer;
    }

    button:hover {
      background-color: #d32f2f;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Data Elektronik</h1>
    <div id="data-container"></div>

    <h2>Tambah Data Elektronik</h2>
    <form id="add-form">
      <label for="nama-barang">Nama Barang:</label>
      <input type="text" id="nama-barang" name="nama_barang">

      <label for="harga">Harga:</label>
      <input type="text" id="harga" name="Harga">

      <input type="submit" value="Tambah">
    </form>
  </div>

  <script>
    // Membuat AJAX request untuk mendapatkan data dari API
    function getData() {
      var xhr = new XMLHttpRequest();
      xhr.open('GET', 'http://localhost/Asesment_3_PABW/koneksi.php', true); // Ganti URL API sesuai dengan kebutuhan Anda

      xhr.onload = function() {
        if (xhr.status === 200) {
          var data = JSON.parse(xhr.responseText);

          // Menampilkan data dalam bentuk tabel
          var table = document.createElement('table');
          table.innerHTML = `
            <tr>
              <th>ID Barang</th>
              <th>Nama Barang</th>
              <th>Harga</th>
              <th>Aksi</th>
            </tr>
          `;

          for (var i = 0; i < data.length; i++) {
            var row = document.createElement('tr');
            row.innerHTML = `
              <td>${data[i].id_barang}</td>
              <td>${data[i].nama_barang}</td>
              <td>${data[i].Harga}</td>
            `;

            // Menambahkan button Hapus untuk setiap data
            var deleteButton = document.createElement('button');
            deleteButton.innerText = 'Hapus';
            deleteButton.setAttribute('data-id', data[i].id_barang);
            deleteButton.addEventListener('click', deleteData);
            var deleteCell = document.createElement('td');
            deleteCell.appendChild(deleteButton);
            row.appendChild(deleteCell);

            table.appendChild(row);
          }

          var dataContainer = document.getElementById('data-container');
          dataContainer.innerHTML = ''; // Menghapus konten sebelumnya
          dataContainer.appendChild(table);
        }
      };

      xhr.send();
    }

    // Menambahkan data melalui API
    function addData(event) {
      event.preventDefault();

      var formData = new FormData(event.target);
      var xhr = new XMLHttpRequest();
      xhr.open('POST', 'http://localhost/Asesment_3_PABW/koneksi.php', true); // Ganti URL API sesuai dengan kebutuhan Anda

      xhr.onload = function() {
        if (xhr.status === 200) {
          alert(xhr.responseText);
          getData(); // Memperbarui tampilan data setelah penambahan
        }
      };

      xhr.send(formData);
    }

    // Menghapus data melalui API
    function deleteData(event) {
      var id = event.target.getAttribute('data-id'); // Mendapatkan ID dari atribut data-id button
      var xhr = new XMLHttpRequest();
      xhr.open('DELETE', 'http://localhost/Asesment_3_PABW/koneksi.php' + id, true); // Ganti URL API sesuai dengan kebutuhan Anda

      xhr.onload = function() {
        if (xhr.status === 200) {
          alert(xhr.responseText);
          getData(); // Memperbarui tampilan data setelah penghapusan
        }
      };

      xhr.send();
    }

    // Memanggil fungsi untuk mendapatkan data saat halaman dimuat
    window.onload = function() {
      getData();
      document.getElementById('add-form').addEventListener('submit', addData);
    };
  </script>
</body>
</html>
