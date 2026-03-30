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
  margin-bottom: 10px;
}

.tab {
  cursor: pointer;
  padding-bottom: 5px;
}

.tab.active {
  border-bottom: 2px solid black;
}

.sort {
  margin: 10px 0;
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
  <h3>Pengantaran</h3>

  <div class="tabs">
    <div class="tab active" onclick="loadData('diterima', this)">Diterima</div>
    <div class="tab" onclick="loadData('dalam_proses', this)">Dalam proses</div>
    <div class="tab" onclick="loadData('sedang_diantar', this)">Sedang diantar</div>
  </div>

  <div class="sort">
    Diurutkan dari:
    <select onchange="changeSort(this.value)">
      <option value="jarak_terdekat">Jarak terdekat</option>
      <option value="jarak_terjauh">Jarak terjauh</option>
      <option value="jadwal">Jadwal pengantaran</option>
      <option value="waktu">Waktu pemesanan</option>
    </select>
  </div>

  <div id="list"></div>
</div>

<script>
let currentTab = 'diterima';
let currentSort = 'jarak_terdekat';

function setTab(el){
  document.querySelectorAll('.tab').forEach(t=>t.classList.remove('active'));
  el.classList.add('active');
}

function changeSort(value){
  currentSort = value;
  loadData(currentTab, document.querySelector('.tab.active'));
}

function getOptions(status){
  if(status === 'diantar'){
    return `<option value="dalam_proses">Dalam proses</option>`;
  }
  if(status === 'dalam_proses'){
    return `
      <option value="diantar">Diterima</option>
      <option value="sedang_diantar">Sedang diantar</option>
    `;
  }
  if(status === 'sedang_diantar'){
    return `
      <option value="dalam_proses">Dalam proses</option>
      <option value="selesai">Selesai</option>
    `;
  }
  return '';
}

function loadData(status, el){
  currentTab = status;
  setTab(el);

  fetch(`get_pengantaran.php?status=${status}&sort=${currentSort}`)
  .then(res=>res.json())
  .then(data=>{
    const container = document.getElementById('list');
    container.innerHTML = '';

    data.forEach(item=>{
      container.innerHTML += `
        <div class="card" onclick="goDetail(${item.id})">
          <div style="display:flex; gap:10px;">
            <img src="img/${item.gambar}">
            <div>
              <div>${item.nama_produk}</div>
              <div style="font-size:12px;">${item.jarak_km} km</div>
              <div style="font-size:11px;">Jadwal: ${item.jadwal_antar}</div>
            </div>
          </div>

          <select class="btn" onclick="event.stopPropagation()" 
                  onchange="updateStatus(${item.id}, this.value)">
            <option selected disabled>${item.status}</option>
            ${getOptions(item.status)}
          </select>
        </div>
      `;
    });
  });
}

function updateStatus(id, status){
  fetch('update_pengantaran.php', {
    method:'POST',
    headers:{'Content-Type':'application/x-www-form-urlencoded'},
    body:`id=${id}&status=${status}`
  })
  .then(res=>res.text())
  .then(res=>{
    if(res === 'success'){
      loadData(currentTab, document.querySelector('.tab.active'));
    } else {
      alert("Status tidak valid");
    }
  });
}

function goDetail(id){
  window.location.href = `detail_pesanan.html?id=${id}`;
}

// default load
loadData('diterima', document.querySelector('.tab'));
</script>

</body>
</html>