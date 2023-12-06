<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "btth02_1"; // Thay 'ten_csdl' bằng tên thực của cơ sở dữ liệu

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (!empty($_POST["name"]) && !empty($_POST["comment"])) {
        $insertComments = "INSERT INTO comment (parent_id, comment, sender, parent_comment_id) VALUES (:commentId, :comment, :name, :parentCommentId)";
        $stmt = $conn->prepare($insertComments);
        $stmt->bindParam(':commentId', $_POST["commentId"]);
        $stmt->bindParam(':comment', $_POST["comment"]);
        $stmt->bindParam(':name', $_POST["name"]);
        $parentCommentId = isset($_POST["parentId"]) ? $_POST["parentId"] : null; // Lấy parentId (ID của bình luận cha, nếu có)
        $stmt->bindParam(':parentCommentId', $parentCommentId);
        $stmt->execute();
        
        $message = '<label class="text-success">Comment posted Successfully.</label>';
        $status = array(
            'error'  => 0,
            'message' => $message
        );	
    } else {
        $message = '<label class="text-danger">Error: Comment not posted.</label>';
        $status = array(
            'error'  => 1,
            'message' => $message
        );	
    }
    echo json_encode($status);
} catch(PDOException $e) {
    $message = '<label class="text-danger">Error: ' . $e->getMessage() . '</label>';
    $status = array(
        'error'  => 1,
        'message' => $message
    );	
    echo json_encode($status);
}
?>
