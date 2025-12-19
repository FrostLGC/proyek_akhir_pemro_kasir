<?php
ini_set('display_errors', 0);
error_reporting(0);
session_start();
ob_start(); 
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../vendor/fpdf/fpdf.php';
$id = intval($_GET['id']);
$q = mysqli_query($conn, "SELECT * FROM pesanan WHERE id={$id}");
if(!$q || mysqli_num_rows($q)==0){ ob_end_clean(); die(); }
$pes = mysqli_fetch_assoc($q);
$det = mysqli_query($conn, "SELECT dp.*, m.nama_menu FROM detail_pesanan dp JOIN menu m ON dp.menu_id=m.id WHERE dp.pesanan_id={$id}");
$trx = mysqli_query($conn, "SELECT * FROM transaksi WHERE pesanan_id={$id} ORDER BY id DESC LIMIT 1");
$trans = mysqli_num_rows($trx) ? mysqli_fetch_assoc($trx) : null;
$pdf = new FPDF('P','mm',array(80,200));
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,5,'Cafe AHMF',0,1,'C');
$pdf->SetFont('Arial','',10);
$pdf->Cell(0,5,'Struk: '.$pes['kode'],0,1);
$pdf->Cell(0,5,'Tgl: '.$pes['created_at'],0,1);
$pdf->Ln(3);
while($row = mysqli_fetch_assoc($det)){
    $pdf->Cell(0,5, $row['nama_menu'].' x'.$row['jumlah'].' - Rp '.number_format($row['subtotal']),0,1);
}
$pdf->Ln(3);
$pdf->Cell(0,5,'Total: Rp '.number_format($pes['total_harga']),0,1);
if($trans){
    $pdf->Cell(0,5,'Bayar: Rp '.number_format($trans['bayar']),0,1);
    $pdf->Cell(0,5,'Kembali: Rp '.number_format($trans['kembali']),0,1);
}
ob_end_clean();
$pdf->Output('I','struk_'.$pes['kode'].'.pdf');
exit;
?>
