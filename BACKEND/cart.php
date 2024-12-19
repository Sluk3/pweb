<?php
include './utility.php';
session_start();
if (!isset($_SESSION['username'])) {

    header("Location:./login.php");
}
$conn = dbConnect();
// Decodifica il corpo della richiesta JSON
$data = json_decode(file_get_contents("php://input"), true);
$query = "";
switch ($data['action']) {
    case 'add':
        if (isset($_SESSION['cart'])) {
            $found = false;
            foreach ($_SESSION['cart'] as &$item) {
                if ($data['id'] == $item['id']) {
                    $query = "UPDATE order_detail SET quantity = quantity + 1 WHERE order_id = ? AND prod_id = ?";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("is", $item['order_id'], $data['id']);
                    $stmt->execute();
                    $stmt->close();
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $query = "INSERT INTO order_detail (order_id, prod_id, quantity) VALUES (?, ?, 1)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("is", $_SESSION['orid'], $data['id']);
                $stmt->execute();
                $stmt->close();
            }
            loadCart($conn, 'refresh');
            echo json_encode(['success' => true]);
        } else {
            $query = "INSERT INTO order_head (username, confirmed) VALUES (?, 0)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $_SESSION['username']);
            $stmt->execute();
            $stmt->close();

            $orId = $conn->insert_id;
            $query = "INSERT INTO order_detail (order_id, prod_id, quantity) VALUES (?, ?, 1)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("is", $orId, $data['id']);
            $stmt->execute();
            $stmt->close();

            loadCart($conn, 'refresh');
            echo json_encode(['success' => true]);
        }
        break;
    case 'delete':
        $query = "DELETE FROM order_detail WHERE order_id = ? AND prod_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("is", $_SESSION['orid'], $data['id']);
        if ($stmt->execute()) {

            $stmt->close();
            foreach ($_SESSION['cart'] as $key => $row) {
                if ($data['id'] == $row['id']) {
                    unset($_SESSION['cart'][$key]);
                    break;
                }
            }

            loadCart($conn, 'refresh');
            echo json_encode(['success' => true]);
        }
        break;
    case 'decrease':
        $qty = 0;
        foreach ($_SESSION['cart'] as $row) {
            if ($data['id'] == $row['id']) {
                $qty = $row['quantity'];
            }
        }
        if ($qty > 1) {
            $query = "UPDATE order_detail SET quantity = quantity - 1 WHERE order_id = ? AND prod_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("is", $_SESSION['orid'], $data['id']);
            if ($stmt->execute()) {
                $stmt->close();
                loadCart($conn, 'refresh');
                echo json_encode(['success' => true]);
            }
        } else {
            $query = "DELETE FROM order_detail WHERE order_id = ? AND prod_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("is", $_SESSION['orid'], $data['id']);
            if ($stmt->execute()) {
                $stmt->close();
                loadCart($conn, 'refresh');
                echo json_encode(['success' => true]);
            }
        }


        break;
    default:
        echo json_encode(['success' => false, 'message' => 'Azione non valida']);
        break;
}
