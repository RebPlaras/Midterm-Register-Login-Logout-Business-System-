<?php 

require_once 'dbConfig.php';

// insert to gpu records
function insertIntoGPURecords($pdo, $brand, $model, $price, $in_stock) {
    $sql = "INSERT INTO GPUs (brand, model, price, in_stock) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$brand, $model, $price, $in_stock]);
    return $executeQuery;  
}

// insert to sales records
function insertIntoSalesRecords($pdo, $gpuID, $quantity, $total_price) {
    $sql = "INSERT INTO SALES (gpuID, quantity, total_price) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$gpuID, $quantity, $total_price]);
    return $executeQuery;  
}

// see records from gpus
function seeGPURecords($pdo) {
    $sql = "SELECT * FROM GPUs";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}

// see records from sales
function seeSalesRecords($pdo) {
    $sql = "SELECT * FROM SALES";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}

// fetch gpu using id
function getGPUByID($pdo, $gpuID) {
    $sql = "SELECT * FROM GPUs WHERE gpuID = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$gpuID]);
    return $stmt->fetch();
}

// update gpu records
function updateGPU($pdo, $gpuID, $brand, $model, $price, $in_stock) {
    $sql = "UPDATE GPUs SET brand = ?, model = ?, price = ?, in_stock = ? WHERE gpuID = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$brand, $model, $price, $in_stock, $gpuID]);
}

// delete gpu records
function deleteGPU($pdo, $gpuID) {
    $sql = "DELETE FROM GPUs WHERE gpuID = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$gpuID]);
}

// delete sales records
function deleteSale($pdo, $saleID) {
    $sql = "DELETE FROM SALES WHERE saleID = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$saleID]);
}

// insert new user
function insertNewUser($pdo, $username, $email, $password) {
    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT); 
    $executeQuery = $stmt->execute([$username, $email, $hashedPassword]);
    return $executeQuery;
}


// insert new admin
function insertNewAdmin($pdo, $username, $email, $password) {
    $sql = "INSERT INTO admins (username, email, password) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT); 
    $executeQuery = $stmt->execute([$username, $email, $hashedPassword]);
    return $executeQuery;
}
?>