<style>
.body-flexFist__ {
      background-color: #f5f5f5 !important;
      width: 240px;
      min-height: 210px;
      max-width: 350px;
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      margin: 0 auto;
}

.latest-posts {
      background-color: #f8f9fc;
      /* Light background color */
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      /* Soft shadow for depth */
      margin: 20px 0;
}

.latest-posts h2 {
      color: #4e73df;
      /* Dark blue color for headings */
      margin-bottom: 15px;
}

.post {
      padding: 10px 0;
      border-bottom: 1px solid #e3e6f0;
      /* Light line between posts */
}

.post:last-child {
      border-bottom: none;
}

.post h3 {
      margin: 0;
      color: #2e59d9;
      /* Slightly lighter blue for post titles */
      font-size: 1.2em;
}

.post a {
      text-decoration: none;
      /* Remove underline from links */
      color: inherit;
      /* Inherit color from parent */
}

.post a:hover {
      color: #224abe;
      /* Darker blue for hover effect */
}

.post p {
      margin: 5px 0 0;
      color: #5a5c69;
      /* Dark gray for text */
      font-size: 0.9em;
}

/* Responsive adjustments */
@media (max-width: 768px) {
      .latest-posts {
            padding: 15px;
      }

      .post h3 {
            font-size: 1em;
      }
}
</style>

<div class="body-flexFist__ row row3">

      <?php
      // Check if the user is logged in
      if (!isset($_SESSION["user"])) {
            // User is not logged in, show the login section
            ?>
      <div class="body-flexFist__login">
            <div class="body-flexFist__login-content">
                  <h1>DEV Community is a</h1>
                  <h1>community of</h1>
                  <h1>1,161,805 amazing</h1>
                  <h1>developers</h1>
                  <p>
                        We're a place where coders share, stay
                        up-to-date and grow their careers.
                  </p>
            </div>
            <div class="body-flexFist__login-button">
                  <a href="#" class="flexFist__login-button-Create">Create</a>

                  <a href="#" class="flexFist__login-button-login">login</a>
            </div>
      </div>
      <?php
      }
      ?>
      <?php

      ?>



      <!-- Latest Posts Section -->
      <div class="latest-posts">
            <h2>Latest Posts</h2>
            <?php
            include('config/dbconfig.php'); // Ensure this path is correct
            
            // Adjust the query to join with the 'user' table to get author's name
            $sql = "SELECT blog.title, blog.id_blog, user.name AS author_name 
                                    FROM blog 
                                    JOIN user ON blog.id_user = user.id_user 
                                    ORDER BY blog.date DESC LIMIT 10";
            $result = $kn->query($sql);

            if ($result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                        echo '<div class="post">';
                        echo '<a href="content/blog.php?id=' . $row['id_blog'] . '"><h3 >' . htmlspecialchars($row['title']) . '</h3></a>';
                        echo '<p>Written by: ' . htmlspecialchars($row['author_name']) . '</p>';
                        echo '</div>';
                  }
            } else {
                  echo '<p>No posts found.</p>';
            }

            $kn->close();
            ?>
      </div>
</div>