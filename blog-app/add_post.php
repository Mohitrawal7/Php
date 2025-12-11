<?php
require 'db.php';
$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    // Image upload
    $image = "";
    if(isset($_FILES['image']) && $_FILES['image']['name'] != "") {
        $image = time() . "_" . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "uploads/" . $image);
    }

    $sql = $conn->prepare("INSERT INTO posts (title, content, image) VALUES (?, ?, ?)");
    $sql->bind_param("sss", $title, $content, $image);

   if ($sql->execute()) {
    // Redirect to avoid resubmission
    header("Location: add_post.php?success=1");
    exit();
} else {
    $msg = "Error: " . $conn->error;
}

}
?>




<!DOCTYPE html>
<html>
<head>
    <title>Add Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5">

<div class="container" style="max-width:600px;">
    <h2 class="mb-4">Add New Post</h2>

   <?php if(isset($_GET['success'])): ?>
    <div class="alert alert-success">Post added successfully!</div>
<?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" required class="form-control">
        </div>
        <div class="mb-3">
            <label>Content</label>
            <textarea name="content" required class="form-control" rows="5"></textarea>
        </div>
        <div class="mb-3">
            <label>Image</label>
            <input type="file" name="image" class="form-control">
        </div>
        <button class="btn btn-primary">Add Post</button>
        <a href="index.php" class="btn btn-secondary">View Posts</a>
    </form>
</div>

</body>
</html>
