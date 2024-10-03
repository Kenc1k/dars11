<?php

include 'products.php';

$products = Product::all();
$message = '';
$messageClass = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_category'])) {
    $categoryName = trim($_POST['category_name'] ?? '');
    $uploadDir = 'uploads/';
    $imagePath = '';

    if (!empty($categoryName) && isset($_FILES['category_image'])) {
        $imageName = basename($_FILES['category_image']['name']);
        $imagePath = $uploadDir . time() . '_' . $imageName;

        if (move_uploaded_file($_FILES['category_image']['tmp_name'], $imagePath)) {
            if (Product::addCategory($categoryName, $imagePath)) {
                $message = "Kategoriya muvaffaqiyatli qo'shildi.";
                $messageClass = 'success';
            } else {
                $message = "Kategoriyani qo'shishda xatolik yuz berdi.";
                $messageClass = 'error';
                unlink($imagePath);
            }
        } else {
            $message = "Rasmni yuklashda xatolik yuz berdi.";
            $messageClass = 'error';
        }
    } else {
        $message = "Kategoriya nomi va rasm kiritilishi shart.";
        $messageClass = 'error';
    }
}

if (isset($_POST['add_category'])) {
    $categoryName = $_POST['category_name'];
    if (!empty($categoryName)) {
        Product::addCategory($categoryName, $imagePath);
        header('Location: index.php');
        exit;
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
        .add-category-form {
            margin-top: 20px;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .add-category-form input[type="text"] {
            padding: 8px;
            width: 200px;
            margin-right: 10px;
        }
        .add-category-form input[type="submit"] {
            padding: 8px 15px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        .add-category-form input[type="submit"]:hover {
            background-color: #45a049;
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
        <div class="add-category-form">
            <form method="POST" action="" enctype="multipart/form-data">
                <input type="text" name="category_name" placeholder="Yangi kategoriya nomi" required>
                <input type="file" name="category_image" accept="image/*" required>
                <input type="submit" name="add_category" value="Kategoriya qo'shish">
            </form>
        </div>
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
