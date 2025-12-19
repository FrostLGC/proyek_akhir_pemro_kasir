<?php
session_start();
require_once __DIR__ . '/../config/database.php';
if (!isset($_SESSION['admin'])) {
    header('Location: ../public/login.php');
    exit;
}
if ($_SESSION['admin']['role'] !== 'admin') {
    echo "Akses ditolak. Hanya admin yang boleh mengelola menu.";
    exit;
}
if (isset($_POST['add'])){
    $nama = mysqli_real_escape_string($conn,$_POST['nama_menu']);
    $harga = intval($_POST['harga']);
    $kategori = intval($_POST['kategori_id']);
    $des = mysqli_real_escape_string($conn,$_POST['deskripsi']);
    $foto = null;
    if (isset($_FILES['foto']) && $_FILES['foto']['error']==0){
        $f = $_FILES['foto'];
        $ext = pathinfo($f['name'], PATHINFO_EXTENSION);
        $new = time()."_".rand(100,999).".".$ext;
        move_uploaded_file($f['tmp_name'], __DIR__ . '/../uploads/gambar_menu/' . $new);
        $foto = $new;
    }
    $sql = "INSERT INTO menu (kategori_id,nama_menu,harga,foto,deskripsi) VALUES ({$kategori},'{$nama}',{$harga},'{$foto}','{$des}')";
    mysqli_query($conn,$sql);
    header('Location: ../admin/menu.php'); exit;
}
$cats = mysqli_query($conn, "SELECT * FROM kategori");
$menus = mysqli_query($conn, "SELECT m.*, k.nama as kategori FROM menu m LEFT JOIN kategori k ON m.kategori_id=k.id ORDER BY m.nama_menu");
?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Kelola Menu</title>
    <link rel="stylesheet" href="../assets/style.css">
  </head>
  <body>
<h1>Kelola Menu</h1>
<nav>
  <a href="../admin/dashboard.php">Dashboard</a>
</nav>
<h3>Tambah Menu</h3>
<form method="post" enctype="multipart/form-data">
  <label>Nama: <input type="text" name="nama_menu" required></label>
  <label>Harga: <input type="number" name="harga" required></label>
  <label>Kategori: <select name="kategori_id"><?php while($c = mysqli_fetch_assoc($cats)) echo '<option value="'.$c['id'].'">'.htmlspecialchars($c['nama']).'</option>'; ?></select></label>
  <!-- <label>Foto: <input type="file" name="foto"></label> -->
  <label>Deskripsi:<br><textarea name="deskripsi"></textarea></label>
  <button type="submit" name="add">Simpan</button>
</form>
<h3>Daftar Menu</h3>
<table border="1">
  <tr>
    <th>ID</th>
    <th>Nama</th>
    <th>Kategori</th>
    <th>Harga</th>
    <th>Foto</th>
  </tr>
<?php 
while($m = mysqli_fetch_assoc($menus)){ 
  echo '<tr>
  <td>'.$m['id'].'</td>
  <td>'.$m['nama_menu'].'</td>
  <td>'.$m['kategori'].'</td>
  <td>'.number_format($m['harga']).'</td>
  <td>'.($m['foto']?'<img src=\"/uploads/gambar_menu/'.$m['foto'].'\" width=\"60\">':'-').'</td>
  </tr>'; } 
?>
</table>
</body>
</html>
