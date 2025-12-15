<?php
require 'db.php';
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Posts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5 bg-light">

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Blog Posts</h2>
        <div>
            <a href="add_post.php" class="btn btn-success">Add New Post</a>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>

    <div class="row">
        <?php
        $result = $conn->query("SELECT * FROM posts ORDER BY created_at DESC");

        if ($result->num_rows > 0):
            while ($row = $result->fetch_assoc()):
        ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <?php if (!empty($row['image'])): ?>
                        <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" 
                             class="card-img-top" style="height:200px; object-fit:cover;">
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
                        <p class="card-text">
                            <?php echo nl2br(htmlspecialchars(substr($row['content'], 0, 100))) . '...'; ?>
                        </p>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <a href="edit_post.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                        <a href="delete_post.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this post?');">Delete</a>
                    </div>
                </div>
            </div>
        <?php
            endwhile;
        else:
            echo "<p>No posts found. <a href='add_post.php'>Add a post</a></p>";
        endif;
        ?>
    </div>
</div>

</body>
</html>
