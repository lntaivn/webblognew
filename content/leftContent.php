<style>
    .sidebar {
        width: 250px;
        background: #fff;
        padding: 20px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
    }

    .sidebar-header h2 {
        color: #333;
        margin-bottom: 15px;
        font-size: 18px;
        font-weight: bold;
        text-align: center;
    }

    .category-list {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .category-list li {
        padding: 10px 15px;
        display: flex;
        align-items: center;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .category-list li:not(:last-child) {
        margin-bottom: 10px;
    }

    .category-list li:hover {
        background-color: #f9f9f9;
        cursor: pointer;
    }

    .category-list .icon {
        color: #FFA500;
        /* Màu cam cho biểu tượng */
        margin-right: 10px;
    }

    .category-list .title {
        color: #333;
        font-size: 16px;
    }
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="path/to/your/script.js"></script>
<div class="sidebar">
    <div class="sidebar-header">
        <h2>Các thể loại</h2>
    </div>
    <ul class="category-list">
        <?php
        include 'config/dbconfig.php'; // Đường dẫn đến file cấu hình cơ sở dữ liệu của bạn
        
        $query = "SELECT * FROM categories";
        $result = mysqli_query($kn, $query);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                // Thay đổi ở đây: thêm liên kết đến blogByCategory.php với tham số id là id_category
                echo "<li>";
                echo "<span class='icon'>#</span>"; // Bạn có thể thay đổi biểu tượng nếu muốn
                echo "<a href='blogByCategory.php?id=" . $row['id_category'] . "'>" . htmlspecialchars($row['name']) . "</a>";
                echo "</li>";
            }
        } else {
            echo "<li>No categories found.</li>";
        }
        ?>
    </ul>
</div>