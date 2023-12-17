<?php
// blog.php

include("../config/dbconfig.php");
?>
    <script type="module" src="https://md-block.verou.me/md-block.js"></script>
<?php
function showBlog($id) {
    global $kn; // Use the database connection from the global scope

    $sql = "SELECT * FROM Blog WHERE id_blog = ?";
    $stmt = mysqli_prepare($kn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        // Display the blog content
        echo '<h1>' . htmlspecialchars($row['title']) . '</h1>';
        echo '<md-block>' . htmlspecialchars($row['content']) . '</md-block>';
    } else {
        echo 'Blog post not found.';
    }
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    showBlog($_GET['id']);
} else {
    echo 'Invalid blog ID.';
}
?>
