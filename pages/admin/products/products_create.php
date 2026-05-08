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
// Initialisation des données du formulaire pour éviter les erreurs "undefined" dans la vue
$formData = [
    'name' => '',
    'description' => '',
    'price' => '',
    'stock' => '',
    'category_ids' => []
];
// Recuperation de toutes les categories actives et construction de la whitelist
$stmtCats = $pdo->query('SELECT * FROM categories WHERE deleted_at IS NULL ORDER BY name ASC');
$categories = $stmtCats->fetchAll();

$categoriesById = [];
foreach ($categories as $cat) {
    $categoriesById[(int)$cat['id']] = true;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // On remplit $formData avec ce que l'utilisateur vient de taper
    $formData['name'] = $_POST['name'] ?? '';
    $formData['description'] = $_POST['description'] ?? '';
    $formData['price'] = $_POST['price'] ?? '';
    $formData['stock'] = $_POST['stock'] ?? '';
    $formData['category_ids'] = $_POST['category_ids'] ?? [];

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

        // Gestion de l'upload et de la compression d'image
        $imagePath = null;
        $uploadOk = true;

        if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
            if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
                $error = "Erreur lors du transfert de l'image.";
                $uploadOk = false;
            } else {
                $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/webp'];
                $fileTmpPath = $_FILES['image']['tmp_name'];
                $fileMimeType = mime_content_type($fileTmpPath);
                $fileSize = $_FILES['image']['size'];
                $maxSize = 2 * 1024 * 1024; // 2 Mo

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

                    $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                    $baseName = uniqid('prod_') . '_' . bin2hex(random_bytes(4));

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
                                $error = "Erreur lors de la compression de l'image sur le serveur.";
                                $uploadOk = false;
                            }
                            imagedestroy($sourceImage);
                        } else {
                            $error = "Le fichier image est corrompu ou illisible.";
                            $uploadOk = false;
                        }
                    } else {
                        // Fallback de secours si GD est absent
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

        // Si l'upload s'est bien passe (ou s'il n'y avait pas d'image), on procede a l'insertion
        if ($uploadOk) {
            if (
                empty($name) ||
                $price === false || $price === null || $price < 0 ||
                $stock === false || $stock === null || $stock < 0
            ) {
                $error = "Veuillez remplir correctement tous les champs obligatoires.";
            } else {
                try {
                    // Demarrage de la transaction
                    $pdo->beginTransaction();

                    // 1. Insertion du produit avec l'image_path
                    $stmt = $pdo->prepare('INSERT INTO products (name, description, price, stock, image_path) VALUES (?, ?, ?, ?, ?)');
                    $stmt->execute([$name, $description, $price, $stock, $imagePath]);

                    // On recupere l'ID du produit fraichement cree
                    $productId = $pdo->lastInsertId();

                    // 2. Insertion des liaisons avec les categories
                    if (!empty($categoryIds) && is_array($categoryIds)) {
                        $stmtPivot = $pdo->prepare('INSERT INTO category_product (product_id, category_id) VALUES (?, ?)');
                        foreach ($categoryIds as $catId) {
                            $catIdInt = (int) $catId;
                            // On verifie que l'ID fait bien partie de la whitelist
                            if (isset($categoriesById[$catIdInt])) {
                                $stmtPivot->execute([$productId, $catIdInt]);
                            }
                        }
                    }

                    // Si tout s'est bien passe, on valide la transaction
                    $pdo->commit();

                    header('Location: /pages/admin/products/products.php');
                    exit;
                } catch (Exception $e) {
                    // En cas d'erreur, on annule la transaction si elle est active
                    if ($pdo->inTransaction()) {
                        $pdo->rollBack();
                    }
                    error_log("Erreur lors de la création du produit : " . $e->getMessage());
                    $error = "Une erreur est survenue lors de l'enregistrement en base de données.";
                }
            }
        }
    }
}

// Generation du jeton CSRF
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// On rend la vue en envoyant la variable $categories
render_view('admin/products/products_create', [
    'error' => $error,
    'categories' => $categories,
    'formData' => $formData
], 'admin');
