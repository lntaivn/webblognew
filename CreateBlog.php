<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
        <label for="tag-dropdown">Choose a tag:</label>
            <select id="tag-dropdown" onchange="addTag()">
            <option value="">Select a tag...</option>
            <option value="webdev">#webdev</option>
            <option value="javascript">#javascript</option>
            <option value="programming">#programming</option>
            <option value="beginners">#beginners</option>
            <option value="tutorial">#tutorial</option>
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
    var dropdown = document.getElementById('tag-dropdown');
    var selectedValue = dropdown.value;
    var tagsContainer = document.getElementById('tags-container');
    var errorMessage = document.getElementById('error-message');

    if (selectedValue && !document.getElementById('tag-' + selectedValue)) {
      if (tagsContainer.children.length < 4) { // Minimum of 2 tags required
        var tag = document.createElement('span');
        tag.classList.add('tag');
        tag.id = 'tag-' + selectedValue;
        tag.textContent = selectedValue + ' x';
        tag.onclick = function() { removeTag(selectedValue); };
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
</script>
  <script>
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
  </script>

  <script>
    function triggerFileInput() {
      document.getElementById('hung').click();
    }

    function displayImage() {
      var input = document.getElementById('hung');
      var fileNameDisplay = document.getElementById('fileName');
      var preview = document.getElementById('preview');

      // Kiểm tra xem người dùng đã chọn file chưa
      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
          // Hiển thị hình ảnh trên thẻ img
          preview.src = e.target.result;
        };

        // Đọc file hình ảnh
        reader.readAsDataURL(input.files[0]);

        // Hiển thị tên file (hoặc bạn có thể ẩn hoàn toàn)
        fileNameDisplay.textContent = input.files[0].name;
      }
    }

    function cancelImage() {
      // Đặt giá trị của trường input file về rỗng
      document.getElementById('hung').value = '';

      // Xóa hình ảnh và tên file
      document.getElementById('preview').src = '';
      document.getElementById('fileName').textContent = '';
    }
  </script>
  <script>
    function savePost() {
      // Get the content from the textarea
      var postContent = document.getElementById('article_body_markdown').value;

      // You can perform further actions, such as sending the content to the server
      // For now, let's just log the content to the console
      console.log('Post content:', postContent);

      // If you want to submit the form, uncomment the next line
      // document.getElementById('postForm').submit();
    }
  </script>
  <script>
    // Gọi function để tạo ra các phần tử <li>
    async function updateValue(id, newValue, check) {
      const spanElement = document.getElementById(id);
      if (spanElement) {
        if (check === 'DUPO') {
          var value, resust = spanElement.textContent
          const cleanResust = cleanUpString(resust);

          var arr = cleanResust.split(',').map(function (item) {
            return item.trim();
          }).filter(function (item) {
            return item !== '';
          });
          console.log(arr)
          if (arr.length === 0) {
            spanElement.textContent = newValue;
          } else {
            if (!arr.includes(newValue)) {
              arr.push(newValue);
              arr.sort(
                function (a, b) {
                  const numA = parseInt(a.match(/\d+/)[0]);
                  const numB = parseInt(b.match(/\d+/)[0]);
                  return numA - numB;
                });
            }
            spanElement.textContent = arr.join(', ');
          }
        } else if (check === 'CDR') {
          var value, resust = spanElement.textContent
          const cleanResust = cleanUpString(resust);

          var arr = cleanResust.split(',').map(function (item) {
            return item.trim();
          }).filter(function (item) {
            return item !== '';
          });
          if (arr.length === 0) {
            spanElement.textContent = newValue;
          } else {
            if (!arr.includes(newValue)) {
              arr.push(newValue);
              arr.sort();
            }
            spanElement.textContent = arr.join(', ');
          }
        } else if (check === 'TUA') {
          spanElement.textContent = newValue;
        }

      }
    }
  </script>
  <script>
    function StringIdGetNumber_DecreaseBy1Unit(id) {
      var numberFromId = parseInt(id.match(/\d+/)[0], 10);
      var newNumber = numberFromId - 1;
      return newNumber;
    }
    function cleanUpString(input) {

      return input.replace(/\n\s+/g, ' ').trim();
    }
    function cleanUp2String(input) {

      return input.replace(/\s+/g, ' ').trim();
    }
  </script>
</body>

</html>