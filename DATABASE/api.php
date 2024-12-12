<?php
header("Content-Type: application/json");

// SQLite database file path
$db_file = 'school_management.db';

// Establish SQLite connection
try {
    $conn = new PDO("sqlite:" . $db_file);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["error" => "Database connection failed: " . $e->getMessage()]);
    exit;
}

// Get POST data
$action = $_POST['action'] ?? null;
$table = $_POST['table'] ?? null;

if (!$action || !$table) {
    echo json_encode(["error" => "Action and table are required."]);
    exit;
}

$data = isset($_POST['data']) ? json_decode($_POST['data'], true) : [];
$conditions = isset($_POST['conditions']) ? json_decode($_POST['conditions'], true) : [];
$columns = $_POST['columns'] ?? '*';

// Helper functions
function buildConditions($conditions)
{
    if (!$conditions)
        return ""; // No conditions means no WHERE clause
    $clauses = [];
    foreach ($conditions as $key => $value) {
        $clauses[] = "$key = :$key"; // Bind parameters securely
    }
    return "WHERE " . implode(" AND ", $clauses); // Combine with AND for multiple conditions
}

function bindParams($stmt, $data)
{
    foreach ($data as $key => $value) {
        $stmt->bindValue(":$key", $value);
    }
}

// Process actions
try {
    if ($action === "select") {
        $sql = "SELECT $columns FROM $table " . buildConditions($conditions);
        $stmt = $conn->prepare($sql);
        bindParams($stmt, $conditions);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
    } elseif ($action === "insert") {
        $keys = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));
        $sql = "INSERT INTO $table ($keys) VALUES ($placeholders)";
        $stmt = $conn->prepare($sql);
        bindParams($stmt, $data);
        $stmt->execute();
        echo json_encode(["success" => true, "id" => $conn->lastInsertId()]);
    } elseif ($action === "update") {
        $setClause = implode(", ", array_map(fn($key) => "$key = :$key", array_keys($data)));
        $sql = "UPDATE $table SET $setClause " . buildConditions($conditions);
        $stmt = $conn->prepare($sql);
        bindParams($stmt, array_merge($data, $conditions));
        $stmt->execute();
        echo json_encode(["success" => true]);
    } elseif ($action === "delete") {
        $sql = "DELETE FROM $table " . buildConditions($conditions);
        $stmt = $conn->prepare($sql);
        bindParams($stmt, $conditions);
        $stmt->execute();
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["error" => "Unknown action: $action"]);
    }
} catch (PDOException $e) {
    echo json_encode(["error" => "SQL error: " . $e->getMessage()]);
}
?>