<?php
include("config/dbconfig.php");
$sql = "SELECT 
b.id_blog, 
b.title, 
b.summary, 
b.date, 
b.banner,
u.name,
u.avt,
GROUP_CONCAT(DISTINCT c.name) AS tags,
(SELECT COUNT(*) FROM Comment WHERE id_post = b.id_blog) AS comments,
(SELECT ROUND(AVG(count_vote),0) FROM Vote WHERE id_post = b.id_blog) AS average_rating
FROM 
Blog b
LEFT JOIN 
Blogs_to_Categories btc ON b.id_blog = btc.id_blog
LEFT JOIN 
Categories c ON btc.id_category = c.id_category
LEFT JOIN 
User u ON b.id_user = u.id_user
where b.status = 1
GROUP BY 
b.id_blog;
; 
";
$kq = mysqli_query($kn, $sql);

while ($row = mysqli_fetch_array($kq)) {
    // Extracting the data from each row
    @$blogId = $row["id_blog"];
    $title = $row["title"];
    $summary = $row["summary"];
    $date = $row["date"];
    @$tags = explode(',', $row["tags"]); // Assuming tags are stored as a comma-separated string
    @$reactions = (int) $row["average_rating"];
    @$comments = $row["comments"];
    @$readTime = $row["date"];
    $banner = $row["banner"];
    $name = $row["name"];
    $avt = $row["avt"];
    $avt = str_replace('../', './', $avt);



    // Generating the HTML content
    echo '<div class="card" style="width: 90%; height: 192px; min-height:192px">';
    echo '    <div class="card-header">';
    echo '        <img src="' . htmlspecialchars($avt) . '" alt="Profile" class="profile-img">';
    echo '        <span class="date" style="font-weight: 700">' . htmlspecialchars($name) . '</span>';
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
    echo '        <button class="reaction-button">' . htmlspecialchars($reactions) . '&nbsp<i class="fa fa-star" style="color: gold;"></i> </button>';
    echo '<a href="content/blog.php?id=' . htmlspecialchars($blogId) . '#comment" style="text-decoration: none; color: #333; font-weight: bold;">';
    echo '<button class="comments-button">💬 ' . htmlspecialchars($comments) . ' comments</button></a>';
    echo '        <span class="read-time">' . htmlspecialchars($readTime) . '</span>';
    echo '        </div>';
    echo '</div>';
}
?>


 
                          