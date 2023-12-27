



<div class="center-comment" id="comment">
      <div class="add-comment">
            <form action="../comment/savecomment.php" method="POST" onsubmit="return submitComment()">
                  <div class="add-comment">
                        <input type="text" name="comment_text" placeholder="Add to the discussion" required>
                        <input type="hidden" name="id_post"
                              value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>">
                        <input type="hidden" name="id_user"
                              value="<?php echo isset($_SESSION['id_user']) ? $_SESSION['id_user'] : ''; ?>">
                        <button type="submit" class="add-comment-submit" onclick="submitComment()">Submit</button>
                        <button type="button" class="add-comment-cancel">Cancel</button>
                  </div>
            </form>
      </div>

      <?php
      include("../config/dbconfig.php");
      // ID của bài post cần hiển thị comment
      $id_bai_viet = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : null;

      // Truy vấn comment
      $sql = "SELECT b.title, u.name AS user_name, c.comment_text, c.comment_date, u.avt
          FROM blog AS b
          LEFT JOIN comment AS c ON b.id_blog = c.id_post
          LEFT JOIN user AS u ON c.id_user = u.id_user
          WHERE b.id_blog = $id_bai_viet
          ORDER BY c.comment_date DESC
          ";



      $result = $kn->query($sql);

      // Hiển thị thông tin trong HTML
      
      while ($row = $result->fetch_assoc()) {
            echo '<div class="comment">';
            echo '  <div class="comment-avatar">';
            echo '<img class="img_comment" src="' . $row['avt'] . '" alt="Not Found" />';
            echo '  </div>';
            echo '  <div class="comment-content">';
            echo '    <div class="comment-author">' . $row['user_name'] . '</div>';
            echo '    <div class="comment-date">' . date('d M', strtotime($row['comment_date'])) . '</div>';
            echo '    <p>' . $row['comment_text'] . '</p>';
            echo '  </div>';
            echo '</div>';
      }

      ?>

      <script>
            function submitComment() {
                  var commentText = document.querySelector('input[name="comment_text"]').value;
                  // Kiểm tra nếu comment không rỗng
                  if (commentText.trim() === "") {
                        alert("Vui lòng nhập bình luận.");
                        return false; // Ngăn form không được gửi
                  }
                  // Bạn có thể thêm các xác nhận khác ở đây nếu muốn
                  return true; // Cho phép form được gửi
            }
      </script>

</div>