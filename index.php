<?php

include 'products.php';

$products = Product::all();

if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $id = $_GET['id'];

    if ($action === 'delete') {
        Product::delete($id);
        header('Location: index.php');
        exit;
    } elseif ($action === 'show') {
        $product = Product::show($id);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mahsulotlar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        h1 {
            color: #333;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        a {
            color: #333;
            text-decoration: none;
            margin-right: 10px;
        }
        a:hover {
            text-decoration: underline;
        }
        .view-link {
            color: #4CAF50;
        }
        .delete-link {
            color: #f44336;
        }
        .product-details {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .back-link {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #333;
            color: #fff;
            border-radius: 5px;
        }
        .back-link:hover {
            background-color: #555;
            text-decoration: none;
        }
        img {
            max-width: 100px;
            height: auto;
        }
    </style>
</head>
<body>
    <h1>Mahsulotlar</h1>
    <?php if (isset($product)): ?>
        <div class="product-details">
            <h2><?php echo htmlspecialchars($product['name']); ?></h2>
            <img src="<?php echo htmlspecialchars($product['img']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" style="max-width: 300px;">
            <a href="index.php" class="back-link">Orqaga</a>
        </div>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nomi</th>
                    <th>Rasm</th>
                    <th>Amallar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($product['id']); ?></td>
                        <td><?php echo htmlspecialchars($product['name']); ?></td>
                        <td><img src="<?php echo htmlspecialchars($product['img']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>"></td>
                        <td>
                            <a href="?action=show&id=<?php echo $product['id']; ?>" class="view-link">Ko'rish</a>
                            <a href="?action=delete&id=<?php echo $product['id']; ?>" class="delete-link" onclick="return confirm('Rostdan ham o\'chirmoqchimisiz?');">O'chirish</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
