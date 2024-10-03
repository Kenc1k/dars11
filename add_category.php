<?php
include 'products.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoryName = trim($_POST['category_name'] ?? '');
    $uploadDir = 'uploads/';
    $imagePath = '';

    if (!empty($categoryName) && isset($_FILES['category_image'])) {
        $imageName = basename($_FILES['category_image']['name']);
        $imagePath = $uploadDir . time() . '_' . $imageName;

        if (move_uploaded_file($_FILES['category_image']['tmp_name'], $imagePath)) {
            try {
                Product::addCategory($categoryName, $imagePath);
                $message = "Kategoriya muvaffaqiyatli qo'shildi.";
                $success = true;
            } catch (Exception $e) {
                $message = "Kategoriyani qo'shishda xatolik yuz berdi: " . $e->getMessage();
                $success = false;
                unlink($imagePath);
            }
        } else {
            $message = "Rasmni yuklashda xatolik yuz berdi.";
            $success = false;
        }
    } else {
        $message = "Kategoriya nomi va rasm kiritilishi shart.";
        $success = false;
    }

    header('Location: index.php?message=' . urlencode($message) . '&success=' . ($success ? '1' : '0'));
    exit;
}
