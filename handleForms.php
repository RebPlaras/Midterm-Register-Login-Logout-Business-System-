<?php 

require_once 'dbConfig.php'; 
require_once 'models.php';

if (isset($_POST['registerBtn'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);

    if (!empty($username) && !empty($email) && !empty($password) && !empty($role)) {

        // checking for existing username in both users and admins tables
        $query = "SELECT username FROM users WHERE username = :username
                  UNION
                  SELECT username FROM admins WHERE username = :username";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $existingUser = $stmt->fetch();

        if ($existingUser) {
            echo " Username already exists. Please choose a different username.";
        } else {
            // no duplicates found, proceed with normal registration
            if ($role === 'admin') {
                $query = insertNewAdmin($pdo, $username, $email, $password);
            } else {
                $query = insertNewUser($pdo, $username, $email, $password);
            }

            if ($query) {
                header("Location: ../sql/index.php"); 
                exit;
            } else {
                echo "Failed to register.";
            }
        }
    } else {
        echo "All fields are required.";
    }
}
// login as user or admin
if (isset($_POST['loginBtn'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    // check if regular user in users table
    $query = "SELECT * FROM users WHERE username = :username";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch();
    
    if ($user && password_verify($password, $user['password'])) {
        session_start();
        $_SESSION['username'] = $username;
        
        // redirect regular user to sales page
        header("Location: ../sql/salespage.php");
        exit;
    }
    
    // check admin in admins table if not found in users
    $query = "SELECT * FROM admins WHERE username = :username";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $admin = $stmt->fetch();
    
    if ($admin && password_verify($password, $admin['password'])) {
        session_start();
        $_SESSION['username'] = $username;
        
        // redirect admin to business management page
        header("Location: ../sql/businessManagementpage.php");
        exit;
    }

    // else no user is found, therefore invalid credentials
    echo "Invalid credentials.";
}


// insert GPU
if (isset($_POST['insertNewGPUBtn'])) {
    $brand = trim($_POST['brand']);
    $model = trim($_POST['model']);
    $price = trim($_POST['price']);
    $in_stock = trim($_POST['in_stock']);

    if (!empty($brand) && !empty($model) && !empty($price) && isset($in_stock)) {
        $query = insertIntoGPURecords($pdo, $brand, $model, $price, $in_stock);

        if ($query) {
            header("Location: ../sql/businessManagementpage.php");
            exit;
        } else {
            echo "Failed to insert GPU record.";
        }
    } else {
        echo "All fields are required. Please fill in all fields.";
    }
}

// edit GPU
if (isset($_POST['editGPUBtn'])) {
    $gpuID = $_GET['gpuID'];
    $brand = trim($_POST['brand']);
    $model = trim($_POST['model']);
    $price = trim($_POST['price']);
    $in_stock = trim($_POST['in_stock']);

    if (!empty($gpuID) && !empty($brand) && !empty($model) && !empty($price) && isset($in_stock)) {
        $query = updateGPU($pdo, $gpuID, $brand, $model, $price, $in_stock);

        if ($query) {
            header("Location: ../sql/businessManagementpage.php");
            exit;
        } else {
            echo "Failed to update GPU record.";
        }
    } else {
        echo "All fields are required. Please fill in all fields.";
    }
}


// insert sale records
if (isset($_POST['insertNewSaleBtn'])) {
    $gpuID = trim($_POST['gpuID']);
    $quantity = trim($_POST['quantity']);
    $total_price = trim($_POST['total_price']);

    if (!empty($gpuID) && !empty($quantity) && !empty($total_price)) {
        $query = insertIntoSalesRecords($pdo, $gpuID, $quantity, $total_price);

        if ($query) {
            header("Location: ../sql/salespage.php");
            exit;
        } else {
            echo "Failed to record the sale.";
        }
    } else {
        echo "All fields are required. Please fill in all fields.";
    }
}
