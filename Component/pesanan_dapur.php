<?php
include 'Component/konek.php';

$status = $_GET['status'];

$query = $conn->query("SELECT * FROM pesanan WHERE status='$status' ORDER BY tanggal DESC");

$data = [];

while ($row = $query->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
?>

<?php
include 'Component/konek.php';

$id = $_POST['id'];
$newStatus = $_POST['status'];

$get = $conn->query("SELECT status FROM pesanan WHERE id=$id");
$row = $get->fetch_assoc();
$current = $row['status'];

$allowed = false;

if ($current == "diterima" && $newStatus == "diproses") {
    $allowed = true;
}

if ($current == "diproses" && ($newStatus == "diterima" || $newStatus == "selesai")) {
    $allowed = true;
}

if ($current == "selesai" && ($newStatus == "diproses" || $newStatus == "diantar")) {
    $allowed = true;
}

if ($current == "diantar") {
    $allowed = false;
}

if ($allowed) {
    $conn->query("UPDATE pesanan SET status='$newStatus' WHERE id=$id");
    echo "success";
} else {
    echo "invalid";
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body {
            font-family: Arial;
            background: #f5f5f5;
            margin: 0;
            display: flex;
            justify-content: center;
        }

        .container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
        }

        .tabs {
            display: flex;
            justify-content: space-around;
            margin-bottom: 15px;
        }

        .tab {
            cursor: pointer;
            padding-bottom: 5px;
        }

        .tab.active {
            border-bottom: 2px solid black;
        }

        .card {
            background: white;
            border: 1px solid #333;
            border-radius: 10px;
            padding: 10px;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
        }

        .card img {
            width: 60px;
            height: 60px;
            border-radius: 8px;
        }

        .btn {
            background: black;
            color: white;
            border-radius: 15px;
            padding: 5px 10px;
            font-size: 12px;
        }
    </style>
</head>

<body>

    <div class="container">
        <h3>Pesanan</h3>

        <div class="tabs">
            <div class="tab active" onclick="loadData('diterima', this)">Diterima</div>
            <div class="tab" onclick="loadData('diproses', this)">Diproses</div>
            <div class="tab" onclick="loadData('selesai', this)">Selesai</div>
        </div>

        <div id="list"></div>
    </div>

    <script>
        let currentTab = 'diterima';

        function setTab(el) {
            document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
            el.classList.add('active');
        }

        function getOptions(status) {
            if (status === 'diterima') {
                return `<option value="diproses">Diproses</option>`;
            }
            if (status === 'diproses') {
                return `
      <option value="diterima">Diterima</option>
      <option value="selesai">Selesai</option>
    `;
            }
            if (status === 'selesai') {
                return `
      <option value="diproses">Diproses</option>
      <option value="diantar">Diantar</option>
    `;
            }
            return '';
        }

        function loadData(status, el) {
            currentTab = status;
            setTab(el);

            fetch(`get_pesanan.php?status=${status}`)
                .then(res => res.json())
                .then(data => {
                    const container = document.getElementById('list');
                    container.innerHTML = '';

                    data.forEach(item => {
                        container.innerHTML += `
        <div class="card">
          <div style="display:flex; gap:10px;">
            <img src="img/${item.gambar}">
            <div>
              <div>${item.nama_produk}</div>
              <div style="font-size:12px;">${item.jumlah}</div>
              <div style="font-size:11px;">${item.waktu}</div>
            </div>
          </div>

          <select class="btn" onchange="updateStatus(${item.id}, this.value)">
            <option selected disabled>${item.status}</option>
            ${getOptions(item.status)}
          </select>
        </div>
      `;
                    });
                });
        }

        function updateStatus(id, status) {
            fetch('update_status.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `id=${id}&status=${status}`
                })
                .then(res => res.text())
                .then(res => {
                    if (res === 'success') {
                        loadData(currentTab, document.querySelector('.tab.active'));
                    } else {
                        alert("Status tidak valid!");
                    }
                });
        }

        // default load
        loadData('diterima', document.querySelector('.tab'));

        const urlParams = new URLSearchParams(window.location.search);
        const highlightId = urlParams.get('highlight');

        const isHighlight = item.id == highlightId;

        container.innerHTML += `
  <div class="card ${isHighlight ? 'highlight' : ''}">`;
    </script>

</body>

</html>