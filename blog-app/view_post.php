<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid post ID");
}

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Post not found");
}

$post = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($post['title']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .post-image {
            width: 100%;
            max-width: 800px; /* limit very large images */
            height: auto;
            object-fit: contain; /* preserves aspect ratio without zoom */
            display: block;
            margin: 0 auto 20px auto;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .post-card {
            max-width: 900px;
            margin: 0 auto;
        }
        .post-footer .btn {
            min-width: 100px;
        }
    </style>
</head>
<body class="bg-light py-5">

<div class="container">
    <a href="index.php" class="btn btn-secondary mb-4">← Back to Blogs</a>

    <div class="card shadow post-card p-3 bg-white">
        <?php if (!empty($post['image'])): ?>
            <img src="uploads/<?php echo htmlspecialchars($post['image']); ?>" 
                 alt="<?php echo htmlspecialchars($post['title']); ?>" 
                 class="post-image">
        <?php endif; ?>

        <div class="card-body">
            <h2 class="card-title"><?php echo htmlspecialchars($post['title']); ?></h2>
            <p class="text-muted mb-3">
                Posted on <?php echo date("F d, Y", strtotime($post['created_at'])); ?>
            </p>
            <hr>
            <p class="card-text" style="white-space: pre-line;">
                <?php echo htmlspecialchars($post['content']); ?>
            </p>
        </div>

        <!-- Edit / Delete Buttons -->
        <div class="d-flex gap-2 mt-4 post-footer justify-content-end">
            <a href="edit_post.php?id=<?php echo $post['id']; ?>" 
               class="btn btn-primary">✏️ Edit Post</a>

            <a href="delete_post.php?id=<?php echo $post['id']; ?>" 
               class="btn btn-danger"
               onclick="return confirm('Are you sure you want to delete this post?');">
               🗑 Delete Post
            </a>
        </div>
    </div>
</div>

</body>
</html>
