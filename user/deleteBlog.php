<?php
include('../config/dbconfig.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id_blog = $_POST['id_blog'];
    echo $id_blog;
    $stmt = $kn->prepare("UPDATE blog SET status = 0 WHERE id_blog = ?");
    $stmt->bind_param("i", $id_blog);

    if ($stmt->execute()) {

        echo 'success';
    } else {
 
        echo 'error';
    }

    $stmt->close();
} else {
    
    echo 'Invalid request method';
}
?>