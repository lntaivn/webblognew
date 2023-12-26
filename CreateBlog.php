<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Xử lý upload cho "fileToUpload"
  if (isset($_FILES["fileToUpload"])) {
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
      mkdir($target_dir, 0755, true);
    }
    $imageFileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));
    $hashedFilename = uniqid('img_', true) . '.' . $imageFileType;
    $target_file = $target_dir . $hashedFilename;

    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
      // Successfully uploaded
      echo $hashedFilename;
    } else {
      // Upload failed
      http_response_code(500);
      echo "Sorry, there was an error uploading your file.";
    }
    exit(); // Stop the script after handling upload
  }

  /////////////////////////////////////////////////
  elseif (isset($_FILES["hung"])) {
    $target_dir = "upload_Banner/";
    if (!is_dir($target_dir)) {
      mkdir($target_dir, 0755, true);
    }

    $imageFileType = strtolower(pathinfo($_FILES["hung"]["name"], PATHINFO_EXTENSION));
    $hashedFilename = uniqid('img_', true) . '.' . $imageFileType;
    $target_file = $target_dir . $hashedFilename;

    if (move_uploaded_file($_FILES["hung"]["tmp_name"], $target_file)) {
      echo $hashedFilename; // Trả về tên file đã được hash
      exit();
    } else {
      exit();
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Markdown Text Editor Toolbar</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="./css/createPost.css">

</head>

<body>

  <!-- <form method="post" enctype="multipart/form-data">
        <label for="fileToUpload" class="upload-icon">
            <i class="fa-regular fa-image"></i> Make sure this class matches your FontAwesome version
        </label>
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Upload Image" name="submit">
    </form>  -->

  <div class="main__author">
    <div>
      <h2>Create Blog Post</h2>
    </div>
    <div class="post-creation">
      <div class="post__display">
        <img src="" id="preview" style="max-width: 300px; max-height: 300px; margin-top: 20px;">
        <input type="file" id="hung" name="hung" style="display: none;" onchange="displayImage()">
        <span id="fileName"></span>

        <div class="post__display-add-img">
          <button type="button" onclick="triggerFileInput()">Add Image</button>
          <button type="button" onclick="cancelImage()">Cancel</button>
        </div>

        <div class="post__display-textare">
          <input type="text" class="post-title" placeholder="New post title here...">

        </div>
        <?php
        include 'config/dbconfig.php'; // Đảm bảo đường dẫn này phản ánh đúng cấu trúc thư mục của bạn
        
        try {
          // Lấy dữ liệu từ bảng categories
          $result = mysqli_query($kn, "SELECT id_category, name FROM categories");

          // Kiểm tra xem kết quả có trả về dữ liệu không
          if (!$result) {
            throw new Exception("Database Error [{$kn->errno}] {$kn->error}");
          }

          $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
        } catch (Exception $e) {
          echo "Query failed: " . $e->getMessage();
          exit;
        }

        // Tiếp tục với phần hiển thị HTML của bạn...
        ?>

        <label for="category-dropdown">Choose a category:</label>
        <select id="category-dropdown" onchange="addTag()">
          <option value="">Select a category...</option>
          <?php foreach ($categories as $category): ?>
            <option value="<?php echo htmlspecialchars($category['name']); ?>">
              <?php echo htmlspecialchars($category['name']); ?>
            </option>
          <?php endforeach; ?>
        </select>
        <div class="tags-container" id="tags-container">
          <!-- Selected tags will appear here -->
        </div>

        <p id="error-message" class="error"></p>

      </div>
    </div>
    <div class="author-form__tooltip">
      <div class="toolbar">
        <div class="tooltip">
          <button onclick="insertMarkdown('**', '**')"><b>B</b></button>
          <span class="tooltiptext">Bold (CTRL+B)</span>
        </div>
        <div class="tooltip">
          <button onclick="insertMarkdown('_', '_')"><i>I</i></button>
          <span class="tooltiptext">Italic (CTRL+I)</span>
        </div>
        <div class="tooltip">
          <button><i class="fa-solid fa-list-ol"></i></button>
          <span class="tooltiptext">Ordered list</span>
        </div>
        <div class="tooltip">
          <button><i class="fa-solid fa-list"></i></button>
          <span class="tooltiptext">Unordered list</span>
        </div>
        <div class="tooltip">


          <input type="file" name="fileToUpload" id="fileToUpload">

        </div>
      </div>
      <form id="postForm" action="/hung" method="post">
        <textarea id="article_body_markdown" name="article_body_markdown" class="textarea"
          placeholder="Write your post content here..."></textarea>
        <button type="button" onclick="savePost()">Save</button>
      </form>

    </div>
  </div>
  <script>
    function addTag() {
      var dropdown = document.getElementById('category-dropdown'); // Đã cập nhật ID này
      var selectedValue = dropdown.value;
      var tagsContainer = document.getElementById('tags-container');
      var errorMessage = document.getElementById('error-message');

      if (selectedValue && !document.getElementById('tag-' + selectedValue)) {
        if (tagsContainer.children.length < 4) { // Giới hạn 4 tags cho ví dụ này
          var tag = document.createElement('span');
          tag.classList.add('tag');
          tag.id = 'tag-' + selectedValue;
          tag.textContent = selectedValue + ' x';
          tag.onclick = function () { removeTag(selectedValue); };
          tagsContainer.appendChild(tag);
          errorMessage.textContent = '';
        }
      } else {
        // Reset the dropdown if no selection or tag already exists
        dropdown.selectedIndex = 0;
      }
    }


    function removeTag(tagValue) {
      var tag = document.getElementById('tag-' + tagValue);
      if (tag) {
        tag.parentNode.removeChild(tag);
      }

      // Check if less than 2 tags, show error
      var tagsContainer = document.getElementById('tags-container');
      var errorMessage = document.getElementById('error-message');

    }
    function insertMarkdown(before, after) {
      const textarea = document.getElementById('article_body_markdown');
      const start = textarea.selectionStart;
      const end = textarea.selectionEnd;
      const text = textarea.value;
      const beforeText = text.substring(0, start);
      const afterText = text.substring(end);
      const selectedText = text.substring(start, end);

      textarea.value = beforeText + before + selectedText + after + afterText;
      textarea.focus();
      textarea.setSelectionRange(start + before.length, end + before.length);
    }
    function insertList(type) {
      const textarea = document.getElementById('article_body_markdown');
      const cursorPosition = textarea.selectionStart;
      const textBefore = textarea.value.substring(0, cursorPosition);
      const textAfter = textarea.value.substring(cursorPosition);
      let listSyntax;

      if (type === 'ol') {
        listSyntax = '1. ';
      } else if (type === 'ul') {
        listSyntax = '- ';
      }

      // Add a new line before the list syntax if the cursor is not at the start of the textarea
      if (cursorPosition !== 0 && textBefore[textBefore.length - 1] !== '\n') {
        listSyntax = '\n' + listSyntax;
      }

      textarea.value = textBefore + listSyntax + '\n' + textAfter;
      // Move the cursor to the end of the inserted list syntax
      const newPosition = cursorPosition + listSyntax.length;
      textarea.setSelectionRange(newPosition, newPosition);
      textarea.focus();
    }

    document.addEventListener('DOMContentLoaded', () => {
      const textarea = document.getElementById('article_body_markdown');
      textarea.addEventListener('input', autoExpandTextarea);
      textarea.addEventListener('focus', setCursorAtEnd); // or setCursorAtStart

      // Attach the list insertion functions to the buttons
      const orderedListButton = document.querySelector('.fa-list-ol');
      const unorderedListButton = document.querySelector('.fa-list');
      if (orderedListButton) {
        orderedListButton.addEventListener('click', () => insertList('ol'));
      }
      if (unorderedListButton) {
        unorderedListButton.addEventListener('click', () => insertList('ul'));
      }

      // Initial call to set the correct height of the textarea
      autoExpandTextarea({ target: textarea });
    });

    function setCursorAtEnd(event) {
      const el = event.target;
      const textLength = el.value.length;
      el.selectionStart = textLength;
      el.selectionEnd = textLength;
    }

    function autoExpandTextarea(event) {
      event.target.style.height = 'auto';
      event.target.style.height = event.target.scrollHeight + 'px';
    }
  </script>
  <script>
    document.getElementById('fileToUpload').addEventListener('change', function () {
      var formData = new FormData();
      formData.append('fileToUpload', this.files[0]);

      fetch('CreateBlog.php', {
        method: 'POST',
        body: formData
      })
        .then(response => response.text())
        .then(hashedFilename => {
          var markdownTextarea = document.getElementById('article_body_markdown');
          var imageURL = 'http://localhost/webblognew/uploads/' + hashedFilename.trim();
          markdownTextarea.value += `\n![image.png](${imageURL})\n`;
        })
        .catch(error => {
          console.error('Error:', error);
        });
    });
    function triggerFileInput() {
      document.getElementById('hung').click();
    }
    var uploadedFileName;
    //biến cục bộ xử lý xóa
    function displayImage() {
      var input = document.getElementById('hung');
      var preview = document.getElementById('preview');
      var fileNameDisplay = document.getElementById('fileName');

      if (input.files && input.files[0]) {
        // Hiển thị hình ảnh xem trước
        var reader = new FileReader();
        reader.onload = function (e) {
          preview.src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
        fileNameDisplay.textContent = input.files[0].name;

        // Gửi file đến máy chủ
        var formData = new FormData();
        formData.append('hung', input.files[0]);

        fetch('CreateBlog.php', {
          method: 'POST',
          body: formData
        })
          .then(response => response.text())
          .then(data => {
            console.log(data);
            uploadedFileName = data; // Cập nhật biến toàn cục
          })
          .catch(error => {
            console.error('Error:', error);
          });
      }
    }

    function cancelImage() {
      var preview = document.getElementById('preview');
      var input = document.getElementById('hung');
      var fileNameDisplay = document.getElementById('fileName');

      //console.log(uploadedFileName);
      preview.src = '';
      input.value = '';
      fileNameDisplay.textContent = '';
      if (uploadedFileName) {
        // Gửi yêu cầu xóa file
        fetch('deleteFile.php', {
          method: 'POST',
          body: JSON.stringify({ filename: uploadedFileName }),
          headers: {
            'Content-Type': 'application/json',
          },
        })
          .then(response => response.text())
          .then(data => console.log(data))
          .catch(error => console.error('Error:', error));
      }
    }
    function savePost() {
      console.log("dc")
      var formData = new FormData();
      if (uploadedFileName) {
        const temp = 'upload_Banner/' + uploadedFileName;
        formData.append('banner', temp);
      }
      formData.append('title', document.querySelector('.post-title').value);
      formData.append('content', document.getElementById('article_body_markdown').value);

      // Thêm các tags
      var tags = document.querySelectorAll('.tags-container .tag');
      tags.forEach(function (tag, index) {
        formData.append('tags[' + index + ']', tag.textContent.replace(' x', ''));
      });

      // Trong hàm savePost() của bạn
      fetch('SavePost.php', {
        method: 'POST',
        body: formData
      })
        .then(response => response.text())
        .then(data => {
          console.log('Success:', data); // Log thông báo thành công vào console
          alert('Lưu dữ liệu thành công: ' + data); // Hiển thị thông báo cho người dùng
        })
        .catch((error) => {
          console.error('Error:', error);
          // Xử lý lỗi
        });

    }
  </script>
</body>

</html>