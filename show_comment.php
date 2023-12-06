<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "btth02_1"; // Thay 'ten_csdl' bằng tên thực của cơ sở dữ liệu

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    function getCommentReply($conn, $parent_id) {
        $replyQuery = "SELECT id, parent_id, comment, sender, date FROM comment WHERE parent_id = :parent_id ORDER BY id DESC";
        $stmt = $conn->prepare($replyQuery);
        $stmt->bindParam(':parent_id', $parent_id);
        $stmt->execute();
        $replyHTML = '';
    
        while($reply = $stmt->fetch(PDO::FETCH_ASSOC)){
            $replyHTML .= '
                <div class="panel panel-info ml-4">
                    <div class="panel-heading">By <b>'.$reply["sender"].'</b> on <i>'.$reply["date"].'</i></div>
                    <div class="panel-body">'.$reply["comment"].'</div>
                </div>';
            
            // Hiển thị các reply của reply (nếu có)
            $replyHTML .= getCommentReply($conn, $reply["id"]);
        }
    
        return $replyHTML;
    }
    
    

    $commentQuery = "SELECT id, parent_id, comment, sender, date FROM comment WHERE parent_id = '0' ORDER BY id DESC";
    $stmt = $conn->query($commentQuery);
    $commentHTML = '';

    while($comment = $stmt->fetch(PDO::FETCH_ASSOC)){
        $commentHTML .= '
            <div class="panel panel-primary">
                <div class="panel-heading">By <b>'.$comment["sender"].'</b> on <i>'.$comment["date"].'</i></div>
                <div class="panel-body">'.$comment["comment"].'</div>
                <div class="panel-footer" align="right">
                    <button type="button" class="btn btn-primary reply" id="'.$comment["id"].'">Reply</button>
                    <div id="replyForm_'.$comment["id"].'" style="display: none;">
                        <!-- Form để nhập reply -->
                        <form method="POST" id="replyForm">
                            <input type="hidden" name="commentId" value="'.$comment["id"].'" />
                            <input type="hidden" name="parentId" value="'.$comment["id"].'" /> <!-- ID của bình luận cha -->
                            <div class="form-group">
                                <input type="text" name="name" class="form-control" placeholder="Your Name" required />
                            </div>
                            <div class="form-group">
                                <textarea name="comment" class="form-control" placeholder="Your Reply" rows="3" required></textarea>
                            </div>
                            <input type="submit" class="btn btn-primary" value="Submit Reply" />
                        </form>
                    </div>
                    <div id="showReplies_'.$comment["id"].'">
                        <!-- Hiển thị các reply -->
                        '.getCommentReply($conn, $comment["id"]).'
                    </div>
                </div>
            </div>';
    }

    echo $commentHTML;
} catch(PDOException $e) {
    $message = '<label class="text-danger">Error: ' . $e->getMessage() . '</label>';
    $status = array(
        'error'  => 1,
        'message' => $message
    ); 
    echo json_encode($status);
}
?>
