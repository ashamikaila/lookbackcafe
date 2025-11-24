<?php
session_start();
require_once '../config/db.php';

// Check if admin is logged in for write operations
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    if (!isset($_SESSION['is_logged_in']) || $_SESSION['role'] !== 'admin') {
        http_response_code(403);
        echo json_encode(['error' => 'Unauthorized']);
        exit();
    }
}

header('Content-Type: application/json');

// GET - Fetch menu items
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $category = $_GET['category'] ?? null;
    
    if ($category) {
        $stmt = $conn->prepare("SELECT * FROM menu_items WHERE category = ? AND is_available = 1 ORDER BY item_name ASC");
        $stmt->bind_param("s", $category);
    } else {
        $stmt = $conn->query("SELECT * FROM menu_items WHERE is_available = 1 ORDER BY category, item_name ASC");
    }
    
    if ($category) {
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        $result = $stmt;
    }
    
    $items = [];
    while ($row = $result->fetch_assoc()) {
        $prices = [];
        if ($row['price_16oz']) $prices['16oz'] = (float)$row['price_16oz'];
        if ($row['price_upsize']) $prices['upsize'] = (float)$row['price_upsize'];
        if ($row['price_1liter']) $prices['1liter'] = (float)$row['price_1liter'];
        if ($row['price_hot']) $prices['hot'] = (float)$row['price_hot'];
        if ($row['price_500ml']) $prices['500ml'] = (float)$row['price_500ml'];
        if ($row['price_regular']) $prices['regular'] = (float)$row['price_regular'];
        
        $items[] = [
            'id' => $row['item_id'],
            'name' => $row['item_name'],
            'category' => $row['category'],
            'image' => $row['image_path'],
            'prices' => $prices
        ];
    }
    
    echo json_encode($items);
}

// POST - Add new menu item (or update if id is provided)
elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    // normalize input variables to ensure bind_param receives variables (not expressions)
    $name = $data['name'] ?? null;
    $category_val = $data['category'] ?? null;
    $image = $data['image'] ?? null;
    $price_16oz = isset($data['prices']['16oz']) ? (float)$data['prices']['16oz'] : null;
    $price_upsize = isset($data['prices']['upsize']) ? (float)$data['prices']['upsize'] : null;
    $price_1liter = isset($data['prices']['1liter']) ? (float)$data['prices']['1liter'] : null;
    $price_hot = isset($data['prices']['hot']) ? (float)$data['prices']['hot'] : null;
    $price_500ml = isset($data['prices']['500ml']) ? (float)$data['prices']['500ml'] : null;
    $price_regular = isset($data['prices']['regular']) ? (float)$data['prices']['regular'] : null;
    $item_id = isset($data['id']) ? (int)$data['id'] : null;

    if ($item_id === null) {
        // INSERT new item
        $stmt = $conn->prepare("INSERT INTO menu_items (item_name, category, image_path, price_16oz, price_upsize, price_1liter, price_hot, price_500ml, price_regular) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to prepare insert statement']);
            exit();
        }
        $stmt->bind_param(
            "sssdddddd",
            $name,
            $category_val,
            $image,
            $price_16oz,
            $price_upsize,
            $price_1liter,
            $price_hot,
            $price_500ml,
            $price_regular
        );

        if ($stmt->execute()) {
            // Log activity
            $admin_id = $_SESSION['user_id'];
            $activity_desc = "Added menu item: {$name} in category {$category_val}";
            $ip = $_SERVER['REMOTE_ADDR'];
            $log_stmt = $conn->prepare("INSERT INTO admin_activity_log (admin_id, activity_type, activity_description, ip_address) VALUES (?, 'menu_management', ?, ?)");
            if ($log_stmt) {
                $log_stmt->bind_param("iss", $admin_id, $activity_desc, $ip);
                $log_stmt->execute();
            }
            echo json_encode(['success' => true, 'id' => $conn->insert_id]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to add item']);
        }
    } else {
        // UPDATE existing item
        $stmt = $conn->prepare("UPDATE menu_items SET item_name = ?, image_path = ?, price_16oz = ?, price_upsize = ?, price_1liter = ?, price_hot = ?, price_500ml = ?, price_regular = ? WHERE item_id = ?");
        if (!$stmt) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to prepare update statement']);
            exit();
        }

        $stmt->bind_param(
            "ssddddddi",
            $name,
            $image,
            $price_16oz,
            $price_upsize,
            $price_1liter,
            $price_hot,
            $price_500ml,
            $price_regular,
            $item_id
        );

        if ($stmt->execute()) {
            // Log activity
            $admin_id = $_SESSION['user_id'];
            $activity_desc = "Updated menu item: {$name} (ID: {$item_id})";
            $ip = $_SERVER['REMOTE_ADDR'];
            $log_stmt = $conn->prepare("INSERT INTO admin_activity_log (admin_id, activity_type, activity_description, ip_address) VALUES (?, 'menu_management', ?, ?)");
            if ($log_stmt) {
                $log_stmt->bind_param("iss", $admin_id, $activity_desc, $ip);
                $log_stmt->execute();
            }
            echo json_encode(['success' => true]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to update item']);
        }
    }
}

// DELETE - Delete menu item
elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $id = $_GET['id'] ?? null;
    
    if ($id) {
        // Soft delete - mark as unavailable
        $stmt = $conn->prepare("UPDATE menu_items SET is_available = 0 WHERE item_id = ?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            // Log activity
            $admin_id = $_SESSION['user_id'];
            $activity_desc = "Deleted menu item ID: $id";
            $ip = $_SERVER['REMOTE_ADDR'];
            $log_stmt = $conn->prepare("INSERT INTO admin_activity_log (admin_id, activity_type, activity_description, ip_address) VALUES (?, 'menu_management', ?, ?)");
            $log_stmt->bind_param("iss", $admin_id, $activity_desc, $ip);
            $log_stmt->execute();
            
            echo json_encode(['success' => true]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to delete item']);
        }
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Missing item ID']);
    }
}
?>