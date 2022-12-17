-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 17, 2022 lúc 09:36 AM
-- Phiên bản máy phục vụ: 10.4.24-MariaDB
-- Phiên bản PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `twitter`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comment`
--

CREATE TABLE `comment` (
  `commentID` int(11) NOT NULL,
  `commentBy` int(11) NOT NULL,
  `commentOn` int(11) NOT NULL,
  `comment` text NOT NULL,
  `commentAt` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `comment`
--

INSERT INTO `comment` (`commentID`, `commentBy`, `commentOn`, `comment`, `commentAt`) VALUES
(13, 6, 62, 'hello', '2022-12-16 23:15:46');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `follow`
--

CREATE TABLE `follow` (
  `followID` int(11) NOT NULL,
  `sender` int(11) NOT NULL,
  `receiver` int(11) NOT NULL,
  `followStatus` enum('0','1') NOT NULL,
  `followOn` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `follow`
--

INSERT INTO `follow` (`followID`, `sender`, `receiver`, `followStatus`, `followOn`) VALUES
(15, 20, 6, '1', '2022-12-16 20:39:52'),
(17, 21, 6, '1', '2022-12-17 10:01:35'),
(18, 6, 20, '1', '2022-12-17 11:45:03');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `likes`
--

CREATE TABLE `likes` (
  `likeID` int(11) NOT NULL,
  `likeOn` int(11) NOT NULL,
  `likeBy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `likes`
--

INSERT INTO `likes` (`likeID`, `likeOn`, `likeBy`) VALUES
(24, 63, 6),
(29, 61, 6),
(30, 61, 20),
(31, 60, 20),
(32, 62, 6);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `messages`
--

CREATE TABLE `messages` (
  `messageID` int(11) NOT NULL,
  `message` text NOT NULL,
  `messageTo` int(11) NOT NULL,
  `messageFrom` int(11) NOT NULL,
  `messageOn` datetime NOT NULL DEFAULT current_timestamp(),
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `messages`
--

INSERT INTO `messages` (`messageID`, `message`, `messageTo`, `messageFrom`, `messageOn`, `status`) VALUES
(11, 'hello', 20, 6, '2022-12-17 11:50:36', 0),
(12, 'hello', 6, 20, '2022-12-17 11:54:15', 0),
(13, '12', 19, 6, '2022-12-17 11:55:59', 0),
(15, 'hi', 21, 6, '2022-12-17 12:08:04', 0),
(16, 'hello', 6, 21, '2022-12-17 12:09:58', 0),
(17, 'dmm', 21, 6, '2022-12-17 12:10:11', 0),
(18, 'db', 6, 21, '2022-12-17 12:10:30', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `notification`
--

CREATE TABLE `notification` (
  `ID` int(11) NOT NULL,
  `notificationFor` int(11) NOT NULL,
  `notificationFrom` int(11) NOT NULL,
  `target` int(11) NOT NULL,
  `type` enum('like','comment','retweet','follow','message','mention') NOT NULL,
  `notificationOn` datetime NOT NULL DEFAULT current_timestamp(),
  `notificationCount` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `retweet`
--

CREATE TABLE `retweet` (
  `retweetID` int(11) NOT NULL,
  `retweetBy` int(11) NOT NULL,
  `retweetFrom` int(11) NOT NULL,
  `status` text NOT NULL,
  `tweetOn` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `retweet`
--

INSERT INTO `retweet` (`retweetID`, `retweetBy`, `retweetFrom`, `status`, `tweetOn`) VALUES
(76, 6, 71, '', '2022-12-16 11:56:46'),
(80, 20, 61, '', '2022-12-16 21:51:37'),
(82, 6, 62, '', '2022-12-16 23:15:49'),
(84, 6, 61, '', '2022-12-17 00:52:24');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `token`
--

CREATE TABLE `token` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `trends`
--

CREATE TABLE `trends` (
  `trendID` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tweetID` int(11) NOT NULL,
  `hashtag` varchar(200) NOT NULL,
  `createdOn` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `trends`
--

INSERT INTO `trends` (`trendID`, `user_id`, `tweetID`, `hashtag`, `createdOn`) VALUES
(19, 6, 60, 'hero', '2022-12-15 01:06:24'),
(20, 6, 60, 'Spiderman', '2022-12-15 01:06:24'),
(21, 20, 62, 'php', '2022-12-15 17:31:42'),
(22, 20, 62, 'ReactNative', '2022-12-15 17:31:42'),
(23, 6, 64, '039', '2022-12-16 00:00:49'),
(24, 6, 65, '039', '2022-12-16 00:01:15'),
(25, 6, 65, '039', '2022-12-16 00:01:15'),
(26, 6, 72, 'hungpham', '2022-12-16 17:01:12'),
(27, 6, 82, 'php', '2022-12-16 23:18:12');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tweets`
--

CREATE TABLE `tweets` (
  `tweetID` int(11) NOT NULL,
  `status` text NOT NULL,
  `tweetBy` int(11) NOT NULL,
  `tweetImage` text NOT NULL,
  `postedOn` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `tweets`
--

INSERT INTO `tweets` (`tweetID`, `status`, `tweetBy`, `tweetImage`, `postedOn`) VALUES
(61, '@hungtran is my best friend', 6, '', '2022-12-15 01:07:20'),
(62, 'i am studying #php and #ReactNative', 20, '', '2022-12-15 17:31:42'),
(87, 'hello', 6, 'frontend/media/1197a8551e2e71c329b52aa54.png', '2022-12-17 00:56:49');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `firstName` varchar(100) NOT NULL,
  `lastName` varchar(100) NOT NULL,
  `username` varchar(150) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profileImage` varchar(255) NOT NULL,
  `profileCover` varchar(255) NOT NULL,
  `following` int(11) NOT NULL,
  `followers` int(11) NOT NULL,
  `bio` text NOT NULL,
  `country` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `signUpDate` datetime NOT NULL DEFAULT current_timestamp(),
  `profileEdit` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`user_id`, `firstName`, `lastName`, `username`, `email`, `password`, `profileImage`, `profileCover`, `following`, `followers`, `bio`, `country`, `website`, `signUpDate`, `profileEdit`) VALUES
(6, 'Huan', 'Nguyen', 'huannguyen', 'huanNguyen@gmai.com', '$2y$10$fc8ekVfwWrIXf6j16Fa2RuP9r39vsrMqigipNroQspTrRy8HhGi3O', 'frontend/assets/images/defaultProfilePic.png', 'frontend/assets/images/backgroundCoverPic.svg', 2, 2, '', '', '', '2022-12-13 12:34:53', '0'),
(19, 'Ydam', 'Cong', 'y damcong', 'ydamcong@gmail.com', '$2y$10$nXWqJDQ3pqUldgvXNNWOuuO2BlQ4/Sx41BauXFbPCWxC3XboaeRvK', 'frontend/assets/images/defaultProfilePic.png', 'frontend/assets/images/backgroundCoverPic.svg', 0, 0, '', '', '', '2022-12-13 22:56:21', '0'),
(20, 'Hung', 'Tran', 'hungtran', 'hungtran@gmail.com', '$2y$10$gu4TwkvHicMpGTqZ5ZYzjOp8FbgCzi5dIJtfsLopSAWrA/qiNKH8u', 'frontend/assets/images/profilePic.jpeg', 'frontend/assets/images/backgroundCoverPic.svg', 1, 2, '', '', '', '2022-12-14 01:12:34', '0'),
(21, 'Hung', 'Tran', 'hungtran607063550', 'huhu@gmail.com', '$2y$10$l0coH5aCMH4gM80hhlHl8upwzCtPxFpp3QBWCz/KTP2d1m5NHZ4ru', 'frontend/assets/images/profilePic.jpeg', 'frontend/assets/images/backgroundCoverPic.svg', 1, 0, '', '', '', '2022-12-16 19:37:39', '0');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `verification`
--

CREATE TABLE `verification` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `code` varchar(256) NOT NULL,
  `status` enum('0','1') NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `verification`
--

INSERT INTO `verification` (`id`, `user_id`, `code`, `status`, `createdAt`) VALUES
(74, 20, '16f66629ba5bfd5f8ba9182e2', '1', '2022-12-14 01:12:38'),
(75, 20, '16f66629ba5bfd5f8ba9182e2', '1', '2022-12-14 01:13:03'),
(76, 6, '64698b9ffaff012f319551065', '1', '2022-12-14 16:24:36'),
(77, 6, '64698b9ffaff012f319551065', '1', '2022-12-14 16:24:57'),
(78, 21, 'b79ba9ae27f21e9e7765f1003', '1', '2022-12-16 19:37:44'),
(79, 21, 'b79ba9ae27f21e9e7765f1003', '1', '2022-12-16 19:38:14');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`commentID`);

--
-- Chỉ mục cho bảng `follow`
--
ALTER TABLE `follow`
  ADD PRIMARY KEY (`followID`);

--
-- Chỉ mục cho bảng `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`likeID`);

--
-- Chỉ mục cho bảng `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`messageID`);

--
-- Chỉ mục cho bảng `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`ID`);

--
-- Chỉ mục cho bảng `retweet`
--
ALTER TABLE `retweet`
  ADD PRIMARY KEY (`retweetID`);

--
-- Chỉ mục cho bảng `token`
--
ALTER TABLE `token`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tokenForein` (`user_id`);

--
-- Chỉ mục cho bảng `trends`
--
ALTER TABLE `trends`
  ADD PRIMARY KEY (`trendID`);

--
-- Chỉ mục cho bảng `tweets`
--
ALTER TABLE `tweets`
  ADD PRIMARY KEY (`tweetID`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Chỉ mục cho bảng `verification`
--
ALTER TABLE `verification`
  ADD PRIMARY KEY (`id`),
  ADD KEY `verify_foreign` (`user_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `comment`
--
ALTER TABLE `comment`
  MODIFY `commentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `follow`
--
ALTER TABLE `follow`
  MODIFY `followID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `likes`
--
ALTER TABLE `likes`
  MODIFY `likeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT cho bảng `messages`
--
ALTER TABLE `messages`
  MODIFY `messageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `notification`
--
ALTER TABLE `notification`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `retweet`
--
ALTER TABLE `retweet`
  MODIFY `retweetID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT cho bảng `token`
--
ALTER TABLE `token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `trends`
--
ALTER TABLE `trends`
  MODIFY `trendID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT cho bảng `tweets`
--
ALTER TABLE `tweets`
  MODIFY `tweetID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT cho bảng `verification`
--
ALTER TABLE `verification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `token`
--
ALTER TABLE `token`
  ADD CONSTRAINT `tokenForein` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `verification`
--
ALTER TABLE `verification`
  ADD CONSTRAINT `verify_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
