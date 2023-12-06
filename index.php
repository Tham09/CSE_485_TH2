<!--Thêm đoạn mã vào tệp index.php-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Comment System</title>
    <!--Thêm các thư viện CSS và JavaScript của Bootstrap-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">		
        <h2>Example: Comment System with Ajax, PHP & MySQL</h2>		
        <form method="POST" id="commentForm">
            <div class="form-group">
                <input type="text" name="name" id="name" class="form-control" placeholder="Enter Name" required />
            </div>
            <div class="form-group">
                <textarea name="comment" id="comment" class="form-control" placeholder="Enter Comment" rows="5" required></textarea>
            </div>
            <span id="message"></span>
            <div class="form-group">
                <input type="hidden" name="commentId" id="commentId" value="0" />
                <input type="submit" name="submit" id="submit" class="btn btn-primary" value="Post Comment" />
            </div>
        </form>		
        <div id="showComments"></div>   
    </div>

    <script src="comment.js"></script> <!--Thêm file comments.js-->
</body>
</html>
