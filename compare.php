<?php
// compare.php — salīdzina cenas no dažādiem veikaliem
$productName = $_GET['product'] ?? '';
$prices = [
  "Rimi" => [
    "Piens" => 1.49,
    "Gurķi" => 2.99,
    "Banāni" => 1.39,
  ],
  "Maxima" => [
    "Piens" => 1.19,
    "Gurķi" => 1.99,
    "Banāni" => 1.29,
  ],
  "Mego" => [
    "Piens" => 1.35,
    "Gurķi" => 1.79,
    "Banāni" => 1.35,
  ]
];
?>
<!DOCTYPE html>
<html lang="lv">
<head>
  <meta charset="UTF-8">
  <title>Salīdzināt cenas</title>
  <style>
    body { font-family: Arial; background: #f4f4f4; padding: 20px; }
    table { width: 60%; margin: auto; border-collapse: collapse; background: white; }
    th, td { padding: 10px; border: 1px solid #ccc; text-align: center; }
    h2 { text-align: center; }
    a { text-decoration: none; color: blue; }
  </style>
</head>
<body>
  <h2>Salīdzināt cenas: <?= htmlspecialchars($productName) ?></h2>
  <table>
    <tr>
      <th>Veikals</th>
      <th>Cena (€)</th>
    </tr>
    <?php foreach ($prices as $store => $products): ?>
      <?php if (isset($products[$productName])): ?>
        <tr>
          <td><?= $store ?></td>
          <td><?= number_format($products[$productName], 2) ?></td>
        </tr>
      <?php endif; ?>
    <?php endforeach; ?>
  </table>
  <p style="text-align: center;"><a href="shop.php">⬅️ Atgriezties</a></p>
</body>
</html>
