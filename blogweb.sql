-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Dec 26, 2023 at 10:03 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blogweb`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `id_blog` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `summary` text DEFAULT NULL,
  `content` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `banner` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `blog`
--

INSERT INTO `blog` (`id_blog`, `id_user`, `title`, `summary`, `content`, `date`, `modified`, `banner`, `status`) VALUES
(1, 1, 'Cà Phê và Văn Hóa', 'Tổng quan về văn hóa cà phê', 'Nội dung đầy đủ về văn hóa cà phê...', '2023-12-11 01:42:47', '2023-12-11 01:42:47', '', 0),
(2, 2, 'Lịch Sử Trà Đen', 'Khám phá lịch sử của trà đen', 'Nội dung đầy đủ về lịch sử trà đen...', '2023-12-11 01:42:47', '2023-12-11 01:42:47', '', 0),
(3, 2, 'Hướng dẫn tạo pull request trên GitHub', 'Pull request là một tính năng của Git giúp các lập trình viên cộng tác với nhau trên một dự án. Pull request cho phép bạn đề xuất các thay đổi đối với một nhánh chính của dự án, chẳng hạn như nhánh master.', '\r\n# Hướng Dẫn Tạo Pull Request trên GitHub\r\n\r\nPull request là một tính năng của Git giúp các lập trình viên cộng tác với nhau trên một dự án. Pull request cho phép bạn đề xuất các thay đổi đối với một nhánh chính của dự án, chẳng hạn như nhánh master. Sau khi tạo pull request, các thành viên khác của dự án có thể xem xét các thay đổi của bạn và cung cấp phản hồi.\r\n\r\n## Bước 1: Fork Dự Án\r\nNếu bạn chưa có quyền truy cập vào dự án, bạn cần fork dự án đó vào tài khoản của mình. Để làm điều này, hãy truy cập trang dự án trên GitHub và nhấn vào nút \"Fork\" ở góc trên bên phải.\r\n\r\n## Bước 2: Tạo Nhánh\r\nTạo một nhánh mới để chứa các thay đổi của bạn. Bạn có thể làm điều này bằng cách sử dụng lệnh `git checkout -b <tên-nhánh>`.\r\n\r\n## Bước 3: Thực Hiện Các Thay Đổi\r\nThực hiện các thay đổi cần thiết đối với dự án trong nhánh mới của bạn.\r\n\r\n## Bước 4: Commit Các Thay Đổi\r\nKhi bạn đã thực hiện xong các thay đổi, hãy commit chúng bằng lệnh `git commit -a -m \"<thông báo-commit>\"`.\r\n\r\n## Bước 5: Tạo Pull Request\r\nTạo pull request để đề xuất các thay đổi của bạn cho nhánh chính của dự án. Để làm điều này, hãy truy cập trang dự án trên GitHub và nhấn vào nút \"New pull request\".\r\n\r\n## Bước 6: Chỉnh Sửa Pull Request\r\nTrên trang pull request, bạn có thể chỉnh sửa thông tin pull request, chẳng hạn như tiêu đề, mô tả và các thành viên cần review.\r\n\r\n## Bước 7: Xem Xét Pull Request\r\nCác thành viên khác của dự án sẽ xem xét pull request của bạn và cung cấp phản hồi. Bạn có thể trả lời phản hồi của họ và thực hiện các thay đổi cần thiết.\r\n\r\n## Bước 8: Merge Pull Request\r\nKhi pull request đã được chấp nhận, nó sẽ được merge vào nhánh chính của dự án.\r\n\r\n### Thông Tin Pull Request\r\n- **Tiêu đề**: Một tiêu đề ngắn gọn mô tả các thay đổi được đề xuất.\r\n- **Mô tả**: Một mô tả chi tiết hơn về các thay đổi được đề xuất.\r\n- **Branch**: Nhánh chứa các thay đổi được đề xuất.\r\n- **Target branch**: Nhánh mà các thay đổi được đề xuất sẽ được merge vào.\r\n- **Issues**: Các issue liên quan đến pull request.\r\n\r\n### Review Pull Request\r\nKhi bạn nhận được một pull request, bạn có thể xem xét các thay đổi được đề xuất và cung cấp phản hồi. Bạn có thể thực hiện các hành động sau đối với pull request:\r\n- **Approve**: Chấp nhận pull request.\r\n- **Request changes**: Yêu cầu người tạo pull request thực hiện các thay đổi.\r\n- **Comment**: Để lại nhận xét về pull request.\r\n- **Close**: Đóng pull request.\r\n\r\n### Merge Pull Request\r\nKhi pull request đã được chấp nhận, bạn có thể merge nó vào nhánh chính của dự án. Để làm điều này, bạn có thể thực hiện các lệnh sau:\r\n- Trên nhánh chính: `git pull <tên-nhánh-pull-request>`\r\n- Trên nhánh pull request: `git push origin master`\r\n\r\n### Lưu Ý\r\n- Pull request chỉ được merge vào nhánh chính của dự án khi nó đã được chấp nhận bởi tất cả các thành viên cần review.\r\n- Bạn có thể tạo pull request cho bất kỳ nhánh nào của dự án, không chỉ nhánh chính.\r\n- Bạn có thể tạo pull request cho nhiều nhánh cùng một lúc.\r\n\r\nHy vọng hướng dẫn này sẽ giúp bạn tạo pull request trên GitHub.\r\n', '2023-12-14 01:14:10', '2023-12-14 01:14:10', '', 0),
(4, 1, 'So sánh giữa HTMLCollection và NodeList', 'HTMLCollection là một đối tượng trong JavaScript, đại diện cho một tập hợp (collection) các phần tử HTML.', '# So sánh giữa HTMLCollection và NodeList\r\n\r\n## 1. Khái Niệm\r\n\r\n### HTMLCollection\r\n\r\n- **Định nghĩa:** HTMLCollection là một đối tượng trong JavaScript, đại diện cho một tập hợp (collection) các phần tử HTML.\r\n- **Sử dụng chủ yếu:** Khi làm việc với kết quả trả về từ các phương thức DOM như `getElementsByClassName`, `getElementsByTagName`.\r\n\r\n### NodeList\r\n\r\n- **Định nghĩa:** NodeList là một đối tượng trong JavaScript, đại diện cho một tập hợp (collection) các nút trong DOM (Document Object Model).\r\n- **Sử dụng chủ yếu:** Khi sử dụng các phương thức DOM như `querySelectorAll`, `childNodes`.\r\n\r\n## 2. Sự Giống Nhau\r\n\r\n- Cả HTMLCollection và NodeList đều là tập hợp các Nodes (elements) lấy ra từ Document thông qua các phương thức get element trong DOM.\r\n- Cả hai đều hỗ trợ truy cập các Nodes thông qua chỉ số index.\r\n- Cả hai đều có thuộc tính `length` để trả về số phần tử của tập hợp.\r\n\r\n## 3. Sự Khác Nhau\r\n\r\n### Định nghĩa\r\n\r\n- HTMLCollection là một tập hợp các document elements.\r\n- NodeList là một tập hợp các document nodes (element nodes, attribute nodes, và text nodes).\r\n\r\n### Cách Truy Cập Các Item Con\r\n\r\n- HTMLCollection cho phép truy cập các item bằng tên, id, và chỉ số index.\r\n- NodeList chỉ cho phép truy cập các item bằng chỉ số index.\r\n\r\n### LIVE hay STATIC Collection\r\n\r\n- **Live Collection (HTMLCollection):** Tự động cập nhật khi có sự thay đổi trong DOM, ví dụ khi thêm hoặc xóa phần tử thỏa mãn điều kiện tìm kiếm.\r\n- **NodeList:** Có thể là \"live\" hoặc \"static\". Phương thức như `querySelectorAll` trả về NodeList \"live\", tự động cập nhật khi có thay đổi trong DOM. Ngược lại, một số phương thức khác như `childNodes` trả về NodeList \"static\", không cập nhật khi có thay đổi trong DOM.\r\n\r\n### Theo Cách Tạo Ra\r\n\r\n- Phương thức `getElementsByClassName()` và `getElementsByTagName()` trả về 1 live HTMLCollection.\r\n- Phương thức `querySelectorAll()` trả về 1 static NodeList.\r\n- Thuộc tính `childNodes` trả về 1 live NodeList.\r\n\r\n## Kết Luận\r\n\r\nHTMLCollection và NodeList đều là các tập hợp trong DOM, có nhiều điểm giống nhau nhưng cũng có những đặc điểm khác nhau quan trọng, đặc biệt là về tính chất \"live\" hay \"static\" của chúng khi có sự thay đổi trong DOM. Việc lựa chọn giữa chúng phụ thuộc vào yêu cầu cụ thể của dự án và cách chúng được tạo ra.\r\n', '2023-12-14 01:14:10', '2023-12-14 01:14:10', '', 0),
(5, 4, 'Tích hợp Jenkins với Github', 'Bước 1: Tạo repository trên GitHub\r\n\r\nTạo một repository trên GitHub cho dự án của bạn.\r\n\r\nBước 2: Cấu hình Webhook trên GitHub\r\n\r\n1. Truy cập vào repository vừa tạo trên GitHub.\r\n\r\n2. Chọn mục \"Settings\" (Cài đặt) trong repository.', '# Tích hợp Jenkins với GitHub\r\n\r\n## Bước 1: Tạo repository trên GitHub\r\n\r\nTạo một repository trên GitHub cho dự án của bạn.\r\n\r\n## Bước 2: Cấu hình Webhook trên GitHub\r\n\r\n1. Truy cập vào repository vừa tạo trên GitHub.\r\n\r\n2. Chọn mục \"Settings\" (Cài đặt) trong repository.\r\n\r\n3. Trong danh sách menu bên trái, chọn \"Webhooks\".\r\n\r\n4. Nhấn nút \"Add webhook\".\r\n\r\n5. Trong trường \"Payload URL\", điền đường dẫn công khai của Jenkins, kết hợp với `/github-webhook/`. Ví dụ:\r\n\r\n![image.png](https://images.viblo.asia/362a409d-2aaa-4586-9ac6-fa326c2edfc2.png)\r\n\r\n\r\n6. Chọn \"Content type\" là \"application/json\".\r\n\r\n7. Dưới phần \"Which events would you like to trigger this webhook?\", chọn \"Just the push event\" hoặc các sự kiện khác tùy theo yêu cầu của bạn.\r\n\r\n8. Sau đó, nhấn nút \"Add webhook\" để lưu cấu hình.\r\n\r\n## Bước 3: Cấu hình Jenkins\r\n\r\n1. Tạo một project trên Jenkins.\r\n\r\n2. Trong cấu hình của project, chọn mục \"Source code management\" (Quản lý mã nguồn).\r\n\r\n3. Chọn \"Git\" và điền URL của repository Git của bạn.\r\n\r\n4. Chọn branch mà bạn muốn sử dụng để triển khai (Branch build).\r\n\r\n5. Trong phần \"Build Triggers\" (Kích hoạt xây dựng), chọn \"GitHub hook trigger for GITScm polling\".\r\n\r\n6. Nhấn nút \"Save\" để lưu cấu hình.\r\n\r\n## Bước 4: Kiểm tra tích hợp\r\n\r\n1. Tiến hành push mã nguồn lên branch đã chọn trong Jenkins.\r\n\r\n2. Sau khi push lên, kiểm tra phần \"Build History\" (Lịch sử xây dựng) của project trên Jenkins.\r\n\r\n3. Nếu bạn thấy các xây dựng mới được bắt đầu, điều này cho thấy kết nối thành công giữa Jenkins và GitHub.\r\n\r\n## Bước 5: Kiểm tra mã nguồn đã được tải về\r\n\r\n1. Sử dụng lệnh sau để truy cập vào container Jenkins:\r\n\r\n`<docker exec -it <Container_ID_của_Jenkins> /bin/bash>`\r\n\r\nTrong đó, `<Container_ID_của_Jenkins>` là ID của container Jenkins.\r\n\r\n2. Di chuyển đến thư mục chứa mã nguồn đã được tải về:\r\n\r\n`<cd /var/jenkins_home/workspace/<tên_project_của_bạn>` \r\n\r\n3. Kiểm tra xem mã nguồn đã được tải về thành công.\r\n\r\nKết quả là bạn đã tích hợp thành công Jenkins với GitHub. Chúc bạn thành công!', '2023-12-14 01:43:38', '2023-12-14 01:45:00', '', 0),
(6, 6, 'So sánh React Native Animated API và React Native Reanimated', 'Trong cộng đồng React Native, có hai thư viện chính được sử dụng để thực hiện animation: React Native Animated API và React Native Reanimated .Cả hai đều giúp đơn giản hóa việc tạo và quản lý animation, nhưng mỗi thư viện mang lại những ưu điểm và hạn chế riêng.', '# So sánh React Native Animated API và React Native Reanimated\r\n\r\nKhi phát triển ứng dụng di động với React Native, việc quản lý và tối ưu hóa animation là một phần quan trọng trong trải nghiệm người dùng. Trong cộng đồng React Native, có hai thư viện chính được sử dụng để thực hiện animation: **React Native Animated API** và **React Native Reanimated**. Cả hai đều giúp đơn giản hóa việc tạo và quản lý animation, nhưng mỗi thư viện mang lại những ưu điểm và hạn chế riêng.\r\n\r\n## Sự Khác Biệt Giữa Animated API và React Native Reanimated\r\n\r\nTrong bài viết này, chúng ta sẽ khám phá sự khác biệt giữa Animated API, một phần của React Native core, và React Native Reanimated, một thư viện mở rộng với những tính năng và hiệu suất tối ưu hóa.\r\n\r\n### Bảng So Sánh\r\n\r\n| Tiêu chí                    | React Native Animated API                            | React Native Reanimated                      |\r\n|-----------------------------|------------------------------------------------------|---------------------------------------------|\r\n| Khả Năng Tương Thích        | Tương thích tốt với các phiên bản React Native.      | Có thể có vấn đề với các phiên bản mới.     |\r\n| Hiệu Suất                   | Tốt với native driver cho một số thuộc tính.         | Cao với native driver cho nhiều thuộc tính. |\r\n| Khả năng Tối Ưu Hóa         | Giới hạn cho một số thuộc tính.                      | Rộng rãi, bao gồm thuộc tính phức tạp.      |\r\n| Sự Phức Tạp                 | Cú pháp đơn giản và dễ học.                          | Cú pháp phức tạp hơn.                       |\r\n| Native Thread               | Chạy trên native thread khi useNativeDriver = true.  | Chạy một phần logic trên native thread.     |\r\n| Khả Năng Hỗ Trợ             | Hỗ trợ đầy đủ từ cộng đồng React Native.             | Hỗ trợ lớn nhưng có thể không đầy đủ.       |\r\n| Dung Lượng Ứng Dụng         | Có thể giảm nếu không sử dụng native driver.         | Có thể tăng do tính năng và tối ưu hóa.     |\r\n| Hỗ Trợ Native Driver        | Cho một số thuộc tính cụ thể.                        | Cho nhiều thuộc tính, bao gồm phức tạp.     |\r\n\r\n## Kết Luận\r\n\r\nAnimated API và React Native Reanimated là hai lựa chọn mạnh mẽ với những đặc tính riêng. Quyết định giữa chúng phụ thuộc vào yêu cầu cụ thể của dự án và sự thoải mái của nhóm phát triển. Animated API mang lại sự đơn giản và tích hợp tốt, trong khi Reanimated cung cấp khả năng tối ưu hóa cao hơn. Quan trọng nhất là hiểu rõ yêu cầu của dự án và đánh giá mức độ thoải mái với cú pháp và tính năng của từng thư viện để đảm bảo quá trình phát triển animation không chỉ tận dụng hiệu suất cao mà còn đáp ứng được các yêu cầu của đội ngũ phát triển.', '2023-12-14 01:54:59', '2023-12-14 01:54:59', '', 0),
(7, 5, 'Các loại cân bằng tải trên AWS - Phần 2', 'Trong phần này, chúng ta sẽ cùng tìm hiểu về 2 loại cân bằng tải còn lại là Network Load Balancer - NLB và Gateway Load Balancer - GWLB.', '# Các loại cân bằng tải trên AWS - Phần 2\r\n\r\nTrong phần trước, chúng ta đã đề cập đến 2 loại cân bằng tải trên AWS là **Classic Load Balancer - CLB** và **Application Load Balancer - ALB**. Trong phần này, chúng ta sẽ cùng tìm hiểu về 2 loại cân bằng tải còn lại là **Network Load Balancer - NLB** và **Gateway Load Balancer - GWLB**.\r\n\r\n## Network Load Balancer - NLB (v2)\r\n\r\n**Network Load Balancer - NLB** là phiên bản cân bằng tải thứ 3 được cung cấp bởi AWS vào năm 2017. Nó hoạt động ở lớp mạng (Layer 4 - TCP, UDP, TLS). NLB cho phép:\r\n\r\n- Forward TCP & UDP traffic tới các instances khác nhau.\r\n- Có thể handle hàng triệu request mỗi giây với độ trễ cực thấp (~100ms khi so với 400ms của ALB).\r\n\r\nNLB chỉ có một static IP cho mỗi Availability Zone, tuy nhiên việc Assign Elastic IP cho NLB cũng rất đơn giản. Điều này tương đối hữu ích khi ta muốn thiết lập các Whitelist IP cho ứng dụng của mình.\r\n\r\nNLB nên được sử dụng cho các ứng dụng cần hiệu suất cực cao khi làm việc với TCP hoặc UDP traffic. Với các ưu điểm nói trên, dĩ nhiên NLB không nằm trong chương trình AWS Free Tier.\r\n\r\n### TCP (Layer 4) Based Traffic\r\n![tcp-based-traffic](https://raw.githubusercontent.com/phamr39/ezidev-imagestorage/master/aws-saa-c03/aws-13/tcp-based-traffic.png)\r\n\r\n### Target Groups trên NLB\r\nNLB có thể làm việc với nhiều loại target groups khác nhau, bao gồm:\r\n\r\n- EC2 instances.\r\n- IP addresses. Tuy nhiên cũng giống như ALB, NLB chỉ hỗ trợ Private IPs.\r\n- Health checks được hỗ trợ với các giao thức TCP, HTTP and HTTPS.\r\n![nlb-target-groups](https://raw.githubusercontent.com/phamr39/ezidev-imagestorage/master/aws-saa-c03/aws-13/nlb-target-groups.png)\r\n\r\n## Gateway Load Balancer\r\n\r\n**Gateway Load Balancer** là phiên bản cân bằng tải thứ 4 được cung cấp bởi AWS vào năm 2021. Nó hoạt động ở cả Layer 3 và 4. Gateway Load Balancer không can thiệp bất cứ phần nào của gói tin. Gateway Load Balancer được thiết kế để xử lý hàng triệu yêu cầu/giây và có độ trễ cực kỳ thấp. GWLB cũng đồng thời đảm bảo được các yêu cầu về bảo mật, tuân thủ khi làm việc với các ứng dụng chạy trong các lớp mạng riêng biệt của bên thứ 3.\r\n\r\n![gateway-load-balancer](https://raw.githubusercontent.com/phamr39/ezidev-imagestorage/master/aws-saa-c03/aws-13/gateway-load-balancer.png)\r\n\r\nGWLB có khả năng làm việc với nhiều loại ứng dụng bảo mật trên các mạng của bên thứ 3 như Firewalls, Intrusion Detection and Prevention Systems, Deep Packet Inspection Systems, payload manipulation, ...\r\n\r\nGWLB sử dụng giao thức GENEVE trên port 6081. GENEVE là một giao thức overlay network, được thiết kế để hỗ trợ các mạng ảo hóa. GWLB sử dụng GENEVE để gửi các gói tin từ các máy chủ đến các ứng dụng bảo mật của bên thứ 3. Các ứng dụng bảo mật của bên thứ 3 sẽ xử lý các gói tin này và trả về kết quả cho GWLB. GWLB sẽ tiếp tục gửi các gói tin này tới các máy chủ đích.\r\n\r\n### Target Groups trên GWLB\r\n![gwlb-target-groups](https://raw.githubusercontent.com/phamr39/ezidev-imagestorage/master/aws-saa-c03/aws-13/gwlb-target-groups.png)\r\n\r\nDo đặc thù nhiệm vụ của mình, Gateway Load Balancer chỉ hỗ trợ chuyển các gói tin tới các EC2 instances và các Private IP.', '2023-12-14 02:03:32', '2023-12-14 02:03:32', '', 0),
(8, 1, 'aaaaaaaaaaaa', 'HUNGTRAN', 'sâsasasasasasas', '2023-12-26 08:52:00', '2023-12-26 08:52:00', 'upload_Banner/img_658a941fb08db2.35339497.png', 0);

-- --------------------------------------------------------

--
-- Table structure for table `blogs_to_categories`
--

CREATE TABLE `blogs_to_categories` (
  `id_blog` int(11) NOT NULL,
  `id_category` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `blogs_to_categories`
--

INSERT INTO `blogs_to_categories` (`id_blog`, `id_category`) VALUES
(1, 1),
(1, 3),
(2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id_category` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `summary` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id_category`, `name`, `summary`) VALUES
(1, 'Văn Hóa', 'Bài viết liên quan đến văn hóa'),
(2, 'Lịch Sử', 'Bài viết về lịch sử'),
(3, 'Ẩm Thực', 'Bài viết về ẩm thực');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `id_comment` int(11) NOT NULL,
  `id_post` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `comment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `comment_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`id_comment`, `id_post`, `id_user`, `comment_date`, `comment_text`) VALUES
(1, 1, 2, '2023-12-11 01:42:47', 'Bài viết rất thú vị!'),
(2, 1, 3, '2023-12-11 01:42:47', 'Tôi hoàn toàn đồng ý với quan điểm của bạn.'),
(3, 2, 1, '2023-12-11 01:42:47', 'Thông tin bổ ích, cảm ơn tác giả.');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gender` enum('M','F','O') DEFAULT NULL,
  `avt` varchar(255) NOT NULL,
  `position` enum('user','admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `name`, `email`, `password`, `gender`, `avt`, `position`) VALUES
(1, 'Nguyen Van A', 'nguyenvana@example.com', 'hashed_password1', 'M', '', 'user'),
(2, 'Tran Thi B', 'tranthib@example.com', 'hashed_password2', 'F', '', 'user'),
(3, 'Le Van C', 'levanc@example.com', 'hashed_password3', 'O', '', 'user'),
(4, 'Nguyễn Hồng Duy', 'duy@email.com', '202cb962ac59075b964b07152d234b70', 'M', '', 'user'),
(5, 'Nguyễn Ánh Viên', 'anhvien@email.com', '123', 'F', '', 'user'),
(6, 'Cao Thái Hòa', 'thaihoa@email.com', '123', 'O', '', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `vote`
--

CREATE TABLE `vote` (
  `id_vote` int(11) NOT NULL,
  `id_post` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `count_vote` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `vote`
--

INSERT INTO `vote` (`id_vote`, `id_post`, `id_user`, `count_vote`, `date`) VALUES
(1, 1, 2, 1, '2023-12-11 01:42:47'),
(2, 1, 3, 1, '2023-12-11 01:42:47'),
(3, 2, 1, 1, '2023-12-11 01:42:47'),
(4, 1, 4, 4, '2023-12-26 08:41:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`id_blog`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `blogs_to_categories`
--
ALTER TABLE `blogs_to_categories`
  ADD PRIMARY KEY (`id_blog`,`id_category`),
  ADD KEY `id_category` (`id_category`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id_category`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id_comment`),
  ADD KEY `id_post` (`id_post`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `vote`
--
ALTER TABLE `vote`
  ADD PRIMARY KEY (`id_vote`),
  ADD KEY `id_post` (`id_post`),
  ADD KEY `id_user` (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `id_blog` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id_comment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `vote`
--
ALTER TABLE `vote`
  MODIFY `id_vote` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blog`
--
ALTER TABLE `blog`
  ADD CONSTRAINT `blog_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Constraints for table `blogs_to_categories`
--
ALTER TABLE `blogs_to_categories`
  ADD CONSTRAINT `blogs_to_categories_ibfk_1` FOREIGN KEY (`id_blog`) REFERENCES `blog` (`id_blog`),
  ADD CONSTRAINT `blogs_to_categories_ibfk_2` FOREIGN KEY (`id_category`) REFERENCES `categories` (`id_category`);

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`id_post`) REFERENCES `blog` (`id_blog`),
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Constraints for table `vote`
--
ALTER TABLE `vote`
  ADD CONSTRAINT `vote_ibfk_1` FOREIGN KEY (`id_post`) REFERENCES `blog` (`id_blog`),
  ADD CONSTRAINT `vote_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
