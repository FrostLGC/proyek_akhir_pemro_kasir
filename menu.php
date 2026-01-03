  <?php
  session_start();
  require_once __DIR__ . '/config/database.php';

  $sql = "SELECT m.*, k.nama AS kategori
          FROM menu m
          LEFT JOIN kategori k ON m.kategori_id = k.id
          ORDER BY k.id ASC, m.nama_menu ASC";
  $res = mysqli_query($conn, $sql);
  ?>

<!DOCTYPE HTML>
  <html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link rel="stylesheet" href="assets/style.css">
  </head>
  <body>

  <header>
    <h2>Menu Cafe</h2>
    <nav>
      <a href="index.php">Home</a>
      <a href="keranjang.php">Keranjang</a>
      <?php if (isset($_SESSION['customer'])): ?>
        <a href="riwayat_pesanan.php">Riwayat</a>
      <?php endif; ?>
    </nav>
  </header>

  <main>

  <?php
  $lastKategori = null;
  while ($row = mysqli_fetch_assoc($res)):
  ?>

    <?php if ($lastKategori !== $row['kategori']): ?>
      <?php if ($lastKategori !== null): ?>
        </div>
      <?php endif; ?>

      <h2 style="margin-top:30px;">
        <?= htmlspecialchars($row['kategori']) ?>
      </h2>
      <div class="cards">

      <?php $lastKategori = $row['kategori']; ?>
    <?php endif; ?>

    <div class="card">
      <?php if ($row['foto']): ?>
        <img src="uploads/gambar_menu/<?= htmlspecialchars($row['foto']) ?>">
      <?php else: ?>
        <div class="noimg">No Image</div>
      <?php endif; ?>

      <h3><?= htmlspecialchars($row['nama_menu']) ?></h3>
      <p><?= htmlspecialchars($row['deskripsi']) ?></p>
      <p><strong>Rp <?= number_format($row['harga'],0,',','.') ?></strong></p>

      <form method="post" action="tambah_keranjang.php">
        <input type="hidden" name="menu_id" value="<?= $row['id'] ?>">

        <label>Jumlah</label>
        <input type="number" name="jumlah" value="1" min="1">

        <button type="submit">Tambah</button>
      </form>
    </div>

  <?php endwhile; ?>
  </div>

  </main>
  </body>
  </html>
