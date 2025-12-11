<?php
require 'db.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Posts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5">

<div class="container">
    <h2 class="mb-4">Blog Posts</h2>
    <a href="add_post.php" class="btn btn-success mb-3">Add New Post</a>

    <div class="row">
        <?php
        $result = $conn->query("SELECT * FROM posts ORDER BY created_at DESC");
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <?php if($row['image']): ?>
                            <img src="uploads/<?php echo $row['image']; ?>" class="card-img-top" style="height:200px; object-fit:cover;">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
                            <p class="card-text"><?php echo nl2br(htmlspecialchars(substr($row['content'],0,100))) . '...'; ?></p>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <a href="edit_post.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                            <a href="delete_post.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">Delete</a>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p>No posts found. <a href='add_post.php'>Add a post</a></p>";
        }
        ?>
    </div>
</div>

</body>
</html>
