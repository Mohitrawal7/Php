<?php
require 'db.php';
$msg = "";

if(!isset($_GET['id'])){
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

// Fetch current post data
$sql = $conn->prepare("SELECT * FROM posts WHERE id=?");
$sql->bind_param("i", $id);
$sql->execute();
$result = $sql->get_result();
$post = $result->fetch_assoc();

if(!$post){
    echo "Post not found!";
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $image = $post['image']; // Keep old image by default

    if(isset($_FILES['image']) && $_FILES['image']['name'] != "") {
        // Delete old image if exists
        if($post['image'] && file_exists("uploads/".$post['image'])){
            unlink("uploads/".$post['image']);
        }

        $image = time() . "_" . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "uploads/" . $image);
    }

    $update = $conn->prepare("UPDATE posts SET title=?, content=?, image=? WHERE id=?");
    $update->bind_param("sssi", $title, $content, $image, $id);

   if($update->execute()){
    // Redirect to same page with success message to avoid resubmission
    header("Location: edit_post.php?id=$id&success=1");
    exit();
} else {
    $msg = "Error: " . $conn->error;
}
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5">

<div class="container" style="max-width:600px;">
    <h2 class="mb-4">Edit Post</h2>

    <?php if(isset($_GET['success'])): ?>
    <div class="alert alert-success">Post updated successfully!</div>
<?php endif; ?>


    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" required class="form-control" value="<?php echo htmlspecialchars($post['title']); ?>">
        </div>

        <div class="mb-3">
            <label>Content</label>
            <textarea name="content" required class="form-control" rows="5"><?php echo htmlspecialchars($post['content']); ?></textarea>
        </div>

        <div class="mb-3">
            <label>Image</label><br>
            <?php if($post['image']): ?>
                <img src="uploads/<?php echo $post['image']; ?>" style="width:150px; margin-bottom:10px;"><br>
            <?php endif; ?>
            <input type="file" name="image" class="form-control">
        </div>

        <button class="btn btn-primary">Update Post</button>
        <a href="index.php" class="btn btn-secondary">Back</a>
    </form>
</div>

</body>
</html>
