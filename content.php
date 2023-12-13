<?php
include("config/dbconfig.php");
$sql = "SELECT * FROM blog";
$kq = mysqli_query($kn, $sql);

while ($row = mysqli_fetch_array($kq)) {
    // Extracting the data from each row
    $title = $row["title"];
    $summary = $row["summary"];
    $date = $row["date"];
    @$tags = explode(',', $row["tags"]); // Assuming tags are stored as a comma-separated string
    @$reactions = $row["reactions"];
    @$comments = $row["comments"];
    @$readTime = $row["read_time"];

    // Generating the HTML content
    echo '<div class="card" style="width: 90%; height: 192px;">';
    echo '    <div class="card-header">';
    echo '        <img src="profile-picture-url.jpg" alt="Profile" class="profile-img">';
    echo '        <span class="date">' . htmlspecialchars($date) . '</span>';
    echo '    </div>';
    echo '    <div class="card-body">';
    echo '        <h2>' . htmlspecialchars($title) . '</h2>';
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
