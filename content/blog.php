<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Display</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="LayoutDetail.css">
    <link rel="stylesheet" href="UserProfile.css">
    <link rel="stylesheet" href="ContentArea.css">
    <link rel="stylesheet" href="interaction-panel.css">
    <script type="module" src="https://md-block.verou.me/md-block.js"></script>

</head>
<body>
    <div class="page-wrapper">

        <nav class="interaction-panel">
            <!-- Dynamic social icon data could be inserted here -->
        </nav>
      
        <div class="content-area">
            <header class="content-header">
                <!-- Additional header content -->
            </header>
            <div class="content-body">
                <?php
                include("../config/dbconfig.php");

                function showBlog($id) {
                    global $kn;

                    $sql = "SELECT blog.*, user.name AS author_name, user.id_user FROM blog JOIN user ON blog.id_user = user.id_user WHERE id_blog = ?";
                    $stmt = mysqli_prepare($kn, $sql);
                    mysqli_stmt_bind_param($stmt, "i", $id);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);

                    if ($row = mysqli_fetch_assoc($result)) {
                        // Display the blog content dynamically
                        echo '<img src="./img/banner.webp" alt="Banner Image" class="wizard-image">';
                        echo '<div class="article-info">';
                        echo '<div class="author-info">';
                        echo '<img src="./img/user1.jpg" alt="'.htmlspecialchars($row['author_name']).'" class="author-image">';
                        echo '<div class="author-details">';
                        echo '<span class="author-name">'.htmlspecialchars($row['author_name']).'</span>';
                        echo '<span class="post-date">Posted on '.htmlspecialchars($row['date']).'</span>';
                        echo '</div></div>';
                        echo '<h1 class="article-title">'.htmlspecialchars($row['title']).'</h1>';
                        echo '<p class="article-summary">'.htmlspecialchars($row['summary']).'</p>';
                        echo '<md-block><div class="article-content">'.($row['content']).'</div></md-block>';
                        echo '<div class="tags">';
                        // Tags or other elements could be added here
                        echo '</div></div>';
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
            </div>
        </div>

        <aside class="user-profile">
            <!-- User profile content could be dynamically loaded here -->
        </aside>
        
    </div>
</body>
</html>
