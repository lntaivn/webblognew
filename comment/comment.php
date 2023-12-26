

<div class="center-comment" id="comment">
  <div class="add-comment">
    <input type="text" placeholder="Add to the discussion">
    <button class="add-comment-summit" onclick="submitComment()">Summit</button>
    <button class="add-comment-cannel">Cannel</button>
  </div>

  <?php
  include('../config/dbconfig.php');
  // ID của bài post cần hiển thị comment
  $id_bai_viet = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : null;

  // Truy vấn comment
  $sql = "SELECT b.title, u.name AS user_name, c.comment_text, c.comment_date
          FROM blog AS b
          LEFT JOIN comment AS c ON b.id_blog = c.id_post
          LEFT JOIN user AS u ON c.id_user = u.id_user
          WHERE b.id_blog = $id_bai_viet";

  $result = $kn->query($sql);

  // Hiển thị thông tin trong HTML
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      echo '<div class="comment">';
      echo '  <div class="comment-avatar">';
      // echo '    <img src="' . $row['avatar'] . '" alt="Not Found" />';
      echo '  </div>';
      echo '  <div class="comment-content">';
      echo '    <div class="comment-author">' . $row['user_name'] . '</div>';
      echo '    <div class="comment-date">' . date('d M', strtotime($row['comment_date'])) . '</div>';
      echo '    <p>' . $row['comment_text'] . '</p>';
      echo '  </div>';
      echo '</div>';
    }
  } else {
    echo "Không có comment nào.";
  }
  ?>

  <script>
    function submitComment() {
      console.log("Submit button clicked!");
      // Lấy dữ liệu từ input
      var commentText = document.getElementById("commentText").value;

      // Kiểm tra xem comment có dữ liệu không
      if (commentText.trim() === "") {
        alert("Please enter a comment before submitting.");
        return;
      }

      // Gửi dữ liệu lên server
      var xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
          // Xử lý kết quả từ server nếu cần
          console.log(xhr.responseText);
          // Refresh hoặc làm gì đó khi comment được lưu thành công
        }
      };

      // Mã hóa dữ liệu để truyền lên server (có thể sử dụng JSON)
      var data = "commentText=" + encodeURIComponent(commentText);

      xhr.open("POST", "save_comment.php", true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.send(data);
    }
  </script>

</div>