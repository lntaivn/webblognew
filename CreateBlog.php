<?php
$uploadOk = 1;
$imageURL = '';
$imageMarkdown = '';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["fileToUpload"])) {
    $target_dir = "uploads/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    $imageFileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));
    $hashedName = uniqid('img_', true) . '.' . $imageFileType;
    $target_file = $target_dir . $hashedName;

    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
    }

    if ($_FILES["fileToUpload"]["size"] > 5000000) {
        $uploadOk = 0;
    }

    if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
        $uploadOk = 0;
    }

    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            // Set the URL to the uploaded image
            $imageURL = 'http://localhost/webblognew/' . $target_file;
            // Create Markdown image text
            $imageMarkdown = "![Image description]($imageURL)";
        }
    }
}

// If the form was submitted and the image was uploaded successfully,
// $imageMarkdown will contain the Markdown text to be inserted into the textarea.
if ($imageMarkdown) {
    echo "<script>parent.setImageMarkdown(`$imageMarkdown`);</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Markdown Text Editor Toolbar</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        body {
            line-height: 1.15;
            font-size: 18pt;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
        }

        .toolbar {
            display: flex;
            justify-content: start;
            background-color: #f3f3f3;
            padding: 10px;
            border-bottom: 1px solid #ccc;
            width: 100%;

            textarea {
                width: 100%;
            }
        }

        .author-form__tooltip {
            display: flex;
            flex-direction: column;
            min-height: 604px;
            width: 806px;
        }

        /* 672 */
        .toolbar button {
            background: none;
            border: none;
            padding: 8px;
            margin-right: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .toolbar button:hover {
            background-color: #e0e0e0;
        }

        .textarea {
            width: 100%;
            height: 400px;
            border: 1px solid #ccc;
            padding: 10px;
            font-family: monospace;
            font-size: 13pt;
            line-height: 1.15;
            resize: none;
        }

        .textarea:focus {
            outline: none;
            border: 1px solid #ccc;
        }

        .tooltip {
            position: relative;
            display: inline-block;
            font-size: 13pt;
            line-height: 1.15;
        }

        .tooltip .tooltiptext {
            visibility: hidden;
            width: 120px;
            background-color: black;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 5px 0;
            position: absolute;
            z-index: 1;
            bottom: 150%;
            left: 50%;
            margin-left: -60px;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .tooltip:hover .tooltiptext {
            visibility: visible;
            opacity: 1;
        }

        .main__author {
            padding-top: 50px;
            display: flex;
            width: 100%;
            min-height: 600px;
            justify-content: center;
            align-items: center;
        }

        #article_body_markdown {
            min-height: 400px;
            height: 400px;
        }
 
        .upload-icon {
            cursor: pointer; /* Change cursor to pointer when over the icon */
        }
    </style>
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



        document.addEventListener('DOMContentLoaded', function() {
    // ... Your existing JavaScript ...

    // Listen for the file input change
    document.getElementById('fileToUpload').addEventListener('change', function() {
        if (this.files && this.files[0]) {
            // Assuming you want to insert a placeholder text for the image
            var markdownTextarea = document.getElementById('article_body_markdown');
            var fileName = this.files[0].name; // Get the file name
            // Insert some placeholder text into the textarea
            markdownTextarea.value += '\nUploading image ' + fileName + '...\n';
            
            // Alternatively, if you want to display an image preview:
            // Create a FileReader object
            var reader = new FileReader();
            reader.onload = function(e) {
                // Create an image markdown with the preview
                markdownTextarea.value += '\n![Image preview](' + e.target.result + ')\n';
            };
            // Read the image file as a data URL.
            reader.readAsDataURL(this.files[0]);
        }
    });
});
        
    </script>
</body>

</html>