<?php
include("config/dbconfig.php");
$sql = "SELECT b.id_blog, b.title, b.summary, b.date,
GROUP_CONCAT(c.name) AS tags,
(SELECT COUNT(*) FROM Vote WHERE id_post = b.id_blog) AS reactions,
(SELECT COUNT(*) FROM Comment WHERE id_post = b.id_blog) AS comments
FROM Blog b
LEFT JOIN Blogs_to_Categories btc ON b.id_blog = btc.id_blog
LEFT JOIN Categories c ON btc.id_category = c.id_category
WHERE b.id_blog in(1,2,3,4,5)
GROUP BY b.id_blog  
";
$kq = mysqli_query($kn, $sql);

while ($row = mysqli_fetch_array($kq)) {
    // Extracting the data from each row
    @$blogId = $row["id_blog"];
    $title = $row["title"];
    $summary = $row["summary"];
    $date = $row["date"];
    @$tags = explode(',', $row["tags"]); // Assuming tags are stored as a comma-separated string
    @$reactions = $row["reactions"];
    @$comments = $row["comments"];
    @$readTime = $row["read_time"];



    // Generating the HTML content
    echo '<div class="card" style="width: 100%; height: 192px; min-height:192px">';
    echo '    <div class="card-header">';
    echo '        <img src="profile-picture-url.jpg" alt="Profile" class="profile-img">';
    echo '        <span class="date">' . htmlspecialchars($date) . '</span>';
    echo '    </div>';
    echo '    <div class="card-body">';
    echo '        <h2><a href="content/blog.php?id=' . htmlspecialchars($blogId) . '">' . htmlspecialchars($title) . '</a></h2>';
    echo '        <div class="tags">';
    foreach ($tags as $tag) {
        echo '            <span>#' . htmlspecialchars(trim($tag)) . '</span>';
    }
    echo '        </div>';
    echo '    </div>';
    echo '    <div class="card-footer">';
    echo '        <button class="reaction-button">❤️ ' . htmlspecialchars($reactions) . ' reactions</button>';
    echo '        <button class="comments-button">💬 ' . htmlspecialchars($comments) . ' comments</button>';
    echo '        <span class="read-time">' . htmlspecialchars($readTime) . ' min read</span>';
    echo '        <button class="save-button">';
    echo '            <img src="save-icon-url.png" alt="Save">';
    echo '        </div>';
    echo '</div>';
}
?>