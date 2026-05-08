<?php
require_once __DIR__ . '/../../../bootstrap.php';
require_alias('@/helpers/db.php');
require_alias('@/helpers/view.php');

session_start();

if (empty($_SESSION['user_id']) || empty($_SESSION['is_admin'])) {
    header('Location: /pages/dashboard.php');
    exit;
}

$pdo = getDbConnection();
$error = '';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    header('Location: /pages/admin/products/products.php');
    exit;
}

$stmt = $pdo->prepare('SELECT * FROM products WHERE id = ? AND deleted_at IS NULL');
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    header('Location: /pages/admin/products/products.php');
    exit;
}

$stmtCats = $pdo->query('SELECT * FROM categories WHERE deleted_at IS NULL ORDER BY name ASC');
$categories = $stmtCats->fetchAll();

$categoriesById = [];
foreach ($categories as $cat) {
    $categoriesById[(int)$cat['id']] = true;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrfToken = $_POST['csrf_token'] ?? '';
    $sessionToken = $_SESSION['csrf_token'] ?? '';

    if (empty($csrfToken) || !hash_equals($sessionToken, $csrfToken)) {
        $error = "Jeton de sécurité invalide ou expiré.";
    } else {
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $price = filter_var($_POST['price'] ?? null, FILTER_VALIDATE_FLOAT);
        $stock = filter_var($_POST['stock'] ?? null, FILTER_VALIDATE_INT);
        $categoryIds = $_POST['category_ids'] ?? [];

        // 1. VALIDATION MÉTIER EN PREMIER
        if (
            empty($name) ||
            $price === false || $price === null || $price < 0 ||
            $stock === false || $stock === null || $stock < 0
        ) {
            $error = "Veuillez remplir correctement tous les champs obligatoires (prix et stock positifs).";
        } else {
            // 2. GESTION DE L'IMAGE ENSUITE
            $imagePath = $product['image_path']; // On garde l'ancienne par defaut
            $uploadOk = true;
            $destination = null; // Declare pour le nettoyage dans le catch

            if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
                if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
                    $error = "Erreur lors du transfert de l'image.";
                    $uploadOk = false;
                } else {
                    $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/webp'];
                    $fileTmpPath = $_FILES['image']['tmp_name'];
                    $fileMimeType = mime_content_type($fileTmpPath);
                    $fileSize = $_FILES['image']['size'];
                    $maxSize = 2 * 1024 * 1024;

                    if (!in_array($fileMimeType, $allowedMimeTypes)) {
                        $error = "Le format de l'image n'est pas autorisé (JPG, PNG ou WEBP uniquement).";
                        $uploadOk = false;
                    } elseif ($fileSize > $maxSize) {
                        $error = "L'image ne doit pas dépasser 2 Mo.";
                        $uploadOk = false;
                    } else {
                        $uploadDir = __DIR__ . '/../../../public/uploads/products/';
                        if (!is_dir($uploadDir)) {
                            mkdir($uploadDir, 0755, true);
                        }

                        // Deduction securisee de l'extension
                        $mimeTypesMap = [
                            'image/jpeg' => 'jpg',
                            'image/png'  => 'png',
                            'image/webp' => 'webp'
                        ];
                        $extension = $mimeTypesMap[$fileMimeType] ?? 'jpg';
                        $baseName = uniqid('prod_') . '_' . bin2hex(random_bytes(4));

                        // Verification de la librairie GD
                        if (extension_loaded('gd') && function_exists('imagecreatefrompng')) {
                            $newFileName = $baseName . '.webp';
                            $destination = $uploadDir . $newFileName;

                            $sourceImage = null;
                            if ($fileMimeType === 'image/jpeg') {
                                $sourceImage = @imagecreatefromjpeg($fileTmpPath);
                            } elseif ($fileMimeType === 'image/png') {
                                $sourceImage = @imagecreatefrompng($fileTmpPath);
                                if ($sourceImage) {
                                    imagepalettetotruecolor($sourceImage);
                                    imagealphablending($sourceImage, true);
                                    imagesavealpha($sourceImage, true);
                                }
                            } elseif ($fileMimeType === 'image/webp') {
                                $sourceImage = @imagecreatefromwebp($fileTmpPath);
                            }

                            if ($sourceImage) {
                                if (imagewebp($sourceImage, $destination, 80)) {
                                    $imagePath = '/public/uploads/products/' . $newFileName;
                                } else {
                                    $error = "Erreur lors de la compression de l'image.";
                                    $uploadOk = false;
                                }
                                imagedestroy($sourceImage);
                            } else {
                                $error = "Le fichier image est corrompu ou illisible.";
                                $uploadOk = false;
                            }
                        } else {
                            // Fallback classique
                            $newFileName = $baseName . '.' . $extension;
                            $destination = $uploadDir . $newFileName;

                            if (move_uploaded_file($fileTmpPath, $destination)) {
                                $imagePath = '/public/uploads/products/' . $newFileName;
                            } else {
                                $error = "Erreur lors de la sauvegarde de l'image sur le serveur.";
                                $uploadOk = false;
                            }
                        }
                    }
                }
            }

            // 3. MISE A JOUR EN BASE DE DONNEES
            if ($uploadOk) {
                try {
                    $pdo->beginTransaction();

                    $stmtUpdate = $pdo->prepare('UPDATE products SET name = ?, description = ?, price = ?, stock = ?, image_path = ? WHERE id = ?');
                    $stmtUpdate->execute([$name, $description, $price, $stock, $imagePath, $id]);

                    $stmtDeletePivot = $pdo->prepare('DELETE FROM category_product WHERE product_id = ?');
                    $stmtDeletePivot->execute([$id]);

                    if (!empty($categoryIds) && is_array($categoryIds)) {
                        $stmtInsertPivot = $pdo->prepare('INSERT INTO category_product (product_id, category_id) VALUES (?, ?)');
                        foreach ($categoryIds as $catId) {
                            $catIdInt = (int)$catId;
                            if (isset($categoriesById[$catIdInt])) {
                                $stmtInsertPivot->execute([$id, $catIdInt]);
                            }
                        }
                    }

                    $pdo->commit();

                    // NETTOYAGE POST-COMMIT : On supprime l'ancienne image seulement si l'upload et la BDD ont reussi
                    if ($imagePath !== $product['image_path'] && !empty($product['image_path'])) {
                        $oldFilePath = __DIR__ . '/../../..' . $product['image_path'];
                        if (file_exists($oldFilePath)) {
                            @unlink($oldFilePath);
                        }
                    }

                    unset($_SESSION['csrf_token']);

                    header('Location: /pages/admin/products/products.php');
                    exit;
                } catch (Exception $e) {
                    if ($pdo->inTransaction()) {
                        $pdo->rollBack();
                    }

                    // NETTOYAGE EN CAS D'ERREUR BDD : On supprime la nouvelle image pour ne pas laisser de fichier orphelin
                    if ($destination && file_exists($destination)) {
                        @unlink($destination);
                    }

                    error_log("Erreur lors de la modification du produit : " . $e->getMessage());
                    $error = "Une erreur est survenue lors de la mise à jour.";
                }
            }
        }
    }
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$stmtCurrentCats = $pdo->prepare('SELECT category_id FROM category_product WHERE product_id = ?');
$stmtCurrentCats->execute([$id]);
$currentCategoryIds = $stmtCurrentCats->fetchAll(PDO::FETCH_COLUMN);

render_view('admin/products/products_edit', [
    'error' => $error,
    'product' => $product,
    'categories' => $categories,
    'currentCategoryIds' => $currentCategoryIds
], 'admin');
