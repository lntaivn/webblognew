<!DOCTYPE html>
<html lang="en">

<head>

      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="">
      <meta name="author" content="">

      <title>SB Admin 2 - Charts</title>

      <!-- Custom fonts for this template-->
      <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
      <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
            rel="stylesheet">

      <!-- Custom styles for this template-->
      <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

      <!-- Page Wrapper -->
      <div id="wrapper">

            <!-- Sidebar -->
            <?php
        include("sideBar.php");
        ?>
            <!-- End of Sidebar -->

            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">

                  <!-- Main Content -->
                  <div id="content">

                        <!-- Topbar -->
                        <?php
                include("topBar.php")
                    ?>
                        <!-- End of Topbar -->

                        <!-- Begin Page Content -->
                        <div class="container-fluid">

                              <!-- Page Heading -->
                              <h1 class="h3 mb-2 text-gray-800">Charts</h1>
                              <p class="mb-4">Chart.js is a third party plugin that is used to generate the charts in
                                    this theme.
                                    The charts below have been customized - for further customization options, please
                                    visit the <a target="_blank" href="https://www.chartjs.org/docs/latest/">official
                                          Chart.js
                                          documentation</a>.</p>

                              <!-- Content Row -->
                              <div class="row">

                                    <div class="col-xl-8 col-lg-7">

                                          <!-- Area Chart -->
                                          <div class="card shadow mb-4">
                                                <div class="card-header py-3">
                                                      <h6 class="m-0 font-weight-bold text-primary">Area Chart</h6>
                                                </div>
                                                <div class="card-body">
                                                      <div class="chart-area">
                                                            <canvas id="myAreaChart"></canvas>
                                                      </div>
                                                      <hr>
                                                      Số lượng bài viết của người dùng

                                                </div>
                                          </div>

                                          <!-- Bar Chart -->
                                          <div class="card shadow mb-4">
                                                <div class="card-header py-3">
                                                      <h6 class="m-0 font-weight-bold text-primary">Biểu đồ</h6>
                                                </div>
                                                <div class="card-body">
                                                      <div class="chart-bar">
                                                            <canvas id="myBarChart"></canvas>
                                                      </div>
                                                      <!-- BarChart -->
                                                      <?php
                                    // Kết nối đến cơ sở dữ liệu
                                    include('config/dbconfig.php');

                                    // Kiểm tra kết nối
                                    if ($kn->connect_error) {
                                        die("Connection failed: " . $kn->connect_error);
                                    }

                                    // Truy vấn cơ sở dữ liệu để lấy danh sách người dùng với tổng số bài post
                                    $sql = "SELECT user.id_user, user.name, user.email, user.gender, COUNT(blog.id_blog) AS total_posts
                                              FROM user
                                              LEFT JOIN blog ON user.id_user = blog.id_user
                                              GROUP BY user.id_user, user.name, user.email, user.gender";

                                    $result = $kn->query($sql);

                                    // Kiểm tra kết quả truy vấn
                                    if ($result->num_rows > 0) {
                                        $data = array();
                                        // Tạo mảng dữ liệu cho biểu đồ
                                        while ($row = $result->fetch_assoc()) {
                                            $data[] = array(
                                                'label' => $row['name'],
                                                'data' => $row['total_posts'],
                                            );
                                        }
                                        // Chuyển mảng dữ liệu sang JSON để truyền vào biểu đồ
                                        $json_data = json_encode($data);
                                        ?>
                                                      <!-- Truyền dữ liệu vào biểu đồ -->

                                                      <?php
                                    } else {
                                        echo "0 results";
                                    }

                                    // Đóng kết nối
                                    $kn->close();
                                    ?>
                                                      <hr>
                                                      Số lượng bài viết của người dùng

                                                </div>
                                          </div>

                                    </div>

                                    <!-- Donut Chart -->
                                    <?php
                        include('config/dbconfig.php'); // Adjust this include path as needed
                        
                        $sql = "SELECT categories.name, COUNT(blogs_to_categories.id_blog) as post_count
                                            FROM categories
                                            LEFT JOIN blogs_to_categories ON categories.id_category = blogs_to_categories.id_category
                                            GROUP BY categories.name";

                        $result = $kn->query($sql);
                        $categories = [];
                        $counts = [];

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $categories[] = $row['name'];
                                $counts[] = (int) $row['post_count'];
                            }
                        } else {
                            echo "0 results";
                        }

                        $kn->close();
                        ?>

                                    <div class="col-xl-4 col-lg-5">
                                          <div class="card shadow mb-4">
                                                <!-- Card Header - Dropdown -->
                                                <div class="card-header py-3">
                                                      <h6 class="m-0 font-weight-bold text-primary">Donut Chart</h6>
                                                </div>
                                                <!-- Card Body -->
                                                <div class="card-body">
                                                      <div class="chart-pie pt-4">
                                                            <canvas id="myPieChart"></canvas>
                                                      </div>
                                                      <hr>
                                                      Styling for the donut chart can be found in the
                                                      <code>/js/demo/chart-pie-demo.js</code> file.
                                                </div>

                                          </div>
                                    </div>
                              </div>

                        </div>
                        <!-- /.container-fluid -->

                  </div>
                  <!-- End of Main Content -->

                  <!-- Footer -->
                  <footer class="sticky-footer bg-white">
                        <div class="container my-auto">
                              <div class="copyright text-center my-auto">
                                    <span>Copyright &copy; Your Website 2020</span>
                              </div>
                        </div>
                  </footer>
                  <!-- End of Footer -->

            </div>
            <!-- End of Content Wrapper -->

      </div>
      <!-- End of Page Wrapper -->

      <!-- Scroll to Top Button-->
      <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
      </a>

      <!-- Logout Modal-->
      <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                  <div class="modal-content">
                        <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                              </button>
                        </div>
                        <div class="modal-body">Select "Logout" below if you are ready to end your current session.
                        </div>
                        <div class="modal-footer">
                              <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                              <a class="btn btn-primary" href="login.html">Logout</a>
                        </div>
                  </div>
            </div>
      </div>

      <!-- Bootstrap core JavaScript-->
      <script src="vendor/jquery/jquery.min.js"></script>
      <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

      <!-- Core plugin JavaScript-->
      <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

      <!-- Custom scripts for all pages-->
      <script src="js/sb-admin-2.min.js"></script>

      <!-- Page level plugins -->
      <script src="vendor/chart.js/Chart.min.js"></script>

      <!-- Page level custom scripts -->
      <script src="js/demo/chart-area-demo.js"></script>
      <script src="js/demo/chart-pie-demo.js"></script>
      <script src="js/demo/chart-bar-demo.js"></script>

</body>
<!-- Script BarChart -->
<script>
var ctx = document.getElementById("myBarChart");
var data = <?php echo $json_data; ?>;
var labels = data.map(item => item.label);
var values = data.map(item => item.data);

var myBarChart = new Chart(ctx, {
      type: "bar",
      data: {
            labels: labels,
            datasets: [{
                  label: "Total Posts",
                  backgroundColor: "#4e73df",
                  hoverBackgroundColor: "#2e59d9",
                  borderColor: "#4e73df",
                  data: values,
            }, ],
      },
      // ... (các options khác của biểu đồ)
});
</script>
<script>
var pieCtx = document.getElementById("myPieChart");

// PHP block to fetch data from the database

var myPieChart = new Chart(pieCtx, {
      type: 'doughnut',
      data: {
            labels: <?php echo json_encode($categories); ?>,
            datasets: [{
                  data: <?php echo json_encode($counts); ?>,
                  backgroundColor: ['#4e73df', '#1cc88a',
                  '#36b9cc'], // Add more colors as needed
                  hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
                  hoverBorderColor: "rgba(234, 236, 244, 1)",
            }],
      },

});
</script>

</html>