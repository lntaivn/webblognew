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
<h2>Create Blog Post</h2>
   <!-- <form method="post" enctype="multipart/form-data">
        <label for="fileToUpload" class="upload-icon">
            <i class="fa-regular fa-image"></i> Make sure this class matches your FontAwesome version
        </label>
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Upload Image" name="submit">
    </form>  -->

    <div class="main__author">
        <div class="post-creation">
        <button class="image-upload">Add a cover image</button>
        <textarea class="post-title" placeholder="New post title here..."></textarea>
        <input type="text" class="tags-input" placeholder="Add up to 4 tags..." />
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
                    <form method="post" enctype="multipart/form-data">
                        <button class="upload-icon">
                            <i class="fa-solid fa-upload"></i>
                        </button>
                        <input type="file" name="fileToUpload" id="fileToUpload">
                    </form>
                </div>
            </div>

            <textarea id="article_body_markdown" class="textarea"
                placeholder="Write your post content here..."></textarea>

        </div>
    </div>
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
document.getElementById('fileToUpload').addEventListener('change', function() {
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
</body>

</html>