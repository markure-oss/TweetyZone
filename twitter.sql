-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 17, 2022 lúc 06:17 PM
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
(18, 6, 95, 'hello', '2022-12-17 21:31:06'),
(20, 6, 88, 'hi!! :)', '2022-12-17 21:44:32');

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
(21, 6, 20, '1', '2022-12-17 16:45:24'),
(23, 22, 6, '1', '2022-12-17 17:36:32'),
(35, 6, 22, '1', '2022-12-17 23:58:57');

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
(37, 87, 22),
(39, 102, 37);

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
(18, 'db', 6, 21, '2022-12-17 12:10:30', 0),
(19, 'what&#039;s pro', 20, 6, '2022-12-17 16:48:33', 0),
(20, '??', 21, 6, '2022-12-17 16:50:18', 0),
(21, 'hello', 6, 22, '2022-12-17 17:32:54', 0),
(22, 'hello guy', 22, 6, '2022-12-17 23:59:18', 0),
(23, 'how are you?', 6, 22, '2022-12-18 00:01:34', 0);

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

--
-- Đang đổ dữ liệu cho bảng `notification`
--

INSERT INTO `notification` (`ID`, `notificationFor`, `notificationFrom`, `target`, `type`, `notificationOn`, `notificationCount`, `status`) VALUES
(4, 20, 6, 62, 'retweet', '2022-12-17 16:21:00', 0, 0),
(5, 20, 6, 62, 'retweet', '2022-12-17 16:21:51', 0, 0),
(8, 20, 6, 0, 'follow', '2022-12-17 16:45:24', 0, 0),
(9, 21, 6, 20, 'message', '2022-12-17 16:50:18', 0, 0),
(10, 6, 22, 21, 'message', '2022-12-17 17:32:54', 1, 0),
(12, 6, 22, 0, 'follow', '2022-12-17 17:36:32', 1, 0),
(13, 6, 22, 87, 'like', '2022-12-17 17:36:44', 1, 0),
(14, 6, 22, 61, 'retweet', '2022-12-17 17:37:27', 1, 0),
(15, 20, 6, 95, 'mention', '2022-12-17 18:11:09', 0, 0),
(16, 6, 22, 96, 'mention', '2022-12-17 18:12:51', 1, 0),
(25, 22, 6, 88, 'comment', '2022-12-17 21:44:32', 1, 0),
(32, 22, 6, 88, 'retweet', '2022-12-17 22:02:52', 1, 0),
(33, 22, 6, 0, 'follow', '2022-12-17 23:58:57', 1, 0),
(34, 22, 6, 22, 'message', '2022-12-17 23:59:18', 1, 0),
(35, 6, 22, 23, 'message', '2022-12-18 00:01:34', 0, 0);

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
(92, 6, 62, '', '2022-12-17 16:21:51'),
(93, 22, 61, '', '2022-12-17 17:37:27'),
(98, 6, 95, '', '2022-12-17 21:30:59'),
(102, 6, 88, '', '2022-12-17 22:02:52');

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
  `tweet_id` int(11) NOT NULL,
  `hashtag` varchar(200) NOT NULL,
  `createdOn` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `trends`
--

INSERT INTO `trends` (`trendID`, `user_id`, `tweet_id`, `hashtag`, `createdOn`) VALUES
(19, 6, 60, 'hero', '2022-12-15 01:06:24'),
(20, 6, 60, 'Spiderman', '2022-12-15 01:06:24'),
(21, 20, 62, 'php', '2022-12-15 17:31:42'),
(22, 20, 62, 'ReactNative', '2022-12-15 17:31:42'),
(23, 6, 64, '039', '2022-12-16 00:00:49'),
(24, 6, 65, '039', '2022-12-16 00:01:15'),
(25, 6, 65, '039', '2022-12-16 00:01:15'),
(26, 6, 72, 'hungpham', '2022-12-16 17:01:12'),
(27, 6, 82, 'php', '2022-12-16 23:18:12'),
(28, 22, 97, 'java', '2022-12-17 21:03:15'),
(29, 22, 98, 'java', '2022-12-17 21:10:04'),
(30, 22, 99, 'ReactNative', '2022-12-17 21:10:31'),
(31, 22, 100, 'java', '2022-12-17 21:10:49'),
(32, 22, 101, 'php', '2022-12-17 21:10:59');

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
(88, 'hello guys', 22, 'frontend/media/a954de919e9cb48bb52ee4210.png', '2022-12-17 16:02:33'),
(96, '@huannguyen oke guys', 22, '', '2022-12-17 18:12:51'),
(97, 'hello #java', 22, '', '2022-12-17 21:03:15'),
(102, 'how to login?', 37, 'frontend/media/5662366d470069a2d3059ebca.png', '2022-12-18 00:05:07');

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
(6, 'Huan', 'Nguyen', 'huannguyen', 'huanNguyen@gmai.com', '$2y$10$fc8ekVfwWrIXf6j16Fa2RuP9r39vsrMqigipNroQspTrRy8HhGi3O', 'frontend/assets/images/defaultProfilePic.png', 'frontend/assets/images/backgroundCoverPic.svg', 3, 3, '', '', '', '2022-12-13 12:34:53', '0'),
(20, 'Hung', 'Tran', 'hungtran', 'hungtran@gmail.com', '$2y$10$gu4TwkvHicMpGTqZ5ZYzjOp8FbgCzi5dIJtfsLopSAWrA/qiNKH8u', 'frontend/assets/images/profilePic.jpeg', 'frontend/assets/images/backgroundCoverPic.svg', 1, 2, '', '', '', '2022-12-14 01:12:34', '0'),
(21, 'Hung', 'Tran', 'hungtran607063550', 'huhu@gmail.com', '$2y$10$l0coH5aCMH4gM80hhlHl8upwzCtPxFpp3QBWCz/KTP2d1m5NHZ4ru', 'frontend/assets/images/profilePic.jpeg', 'frontend/assets/images/backgroundCoverPic.svg', 1, 0, '', '', '', '2022-12-16 19:37:39', '0'),
(22, 'Hung', 'Pham', 'hungpham', 'hello@gmail.com', '$2y$10$ue4mGKdjIvYk4COoilOdGuLQ3bio0rnfiBBYR39opRjTi2HHShWXq', 'frontend/assets/images/defaultProfilePic.png', 'frontend/assets/images/backgroundCoverPic.svg', 1, 1, '', '', '', '2022-12-17 16:00:25', '0'),
(36, 'Test', 'Test', 'testtest', 'test@gmail.com', '$2y$10$TzSAtYLiNVI4JbAjFrDceu/gPwd7zMf8N5xMNZy7QIAl5he89alUm', 'frontend/assets/images/defaultProfilePic.png', 'frontend/assets/images/backgroundCoverPic.svg', 0, 0, '', '', '', '2022-12-17 23:55:58', '0'),
(37, 'Hieu', 'Nguyen', 'hieunguyen', 'hieuhuu05122002@gmail.com', '$2y$10$0oOPsgmZLcJwYslet4.X6ez5wUNNoFMiGazmrgbMEwjsXfzAdksYS', 'frontend/assets/images/defaultProfilePic.png', 'frontend/assets/images/backgroundCoverPic.svg', 0, 0, '', '', '', '2022-12-18 00:02:44', '0'),
(38, 'Hieu', 'Nguyenhello', 'hieunguyenhello', '1234@gmail.com', '$2y$10$aidjJobfR0gaJPZkTdwiOuES2vxIQookCb0yK/jVBelyOwAe0Whte', 'frontend/assets/images/defaultPic.svg', 'frontend/assets/images/backgroundImage.svg', 0, 0, '', '', '', '2022-12-18 00:07:52', '0');

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
(96, 36, '97482ea7ce2ce9d381a891b03', '1', '2022-12-17 23:56:03'),
(97, 36, '97482ea7ce2ce9d381a891b03', '1', '2022-12-17 23:57:34'),
(98, 6, 'aab84c1df0fd709874c12a0df', '1', '2022-12-17 23:58:24'),
(99, 6, 'aab84c1df0fd709874c12a0df', '1', '2022-12-17 23:58:34'),
(100, 22, 'ae6901478cb22163c93aa0824', '1', '2022-12-17 23:59:55'),
(101, 22, 'ae6901478cb22163c93aa0824', '1', '2022-12-18 00:00:15'),
(102, 22, 'ae6901478cb22163c93aa0824', '1', '2022-12-18 00:01:11'),
(103, 37, '41ecfb6e458c71cbce994aaeb', '1', '2022-12-18 00:02:48'),
(104, 37, '41ecfb6e458c71cbce994aaeb', '1', '2022-12-18 00:03:32'),
(110, 38, '5215ddc0401b7a563fa598912', '0', '2022-12-18 00:07:56'),
(111, 38, '6a990649e426b6c64fe708793', '0', '2022-12-18 00:08:42');

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
  MODIFY `commentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT cho bảng `follow`
--
ALTER TABLE `follow`
  MODIFY `followID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT cho bảng `likes`
--
ALTER TABLE `likes`
  MODIFY `likeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT cho bảng `messages`
--
ALTER TABLE `messages`
  MODIFY `messageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT cho bảng `notification`
--
ALTER TABLE `notification`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT cho bảng `retweet`
--
ALTER TABLE `retweet`
  MODIFY `retweetID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT cho bảng `token`
--
ALTER TABLE `token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `trends`
--
ALTER TABLE `trends`
  MODIFY `trendID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT cho bảng `tweets`
--
ALTER TABLE `tweets`
  MODIFY `tweetID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT cho bảng `verification`
--
ALTER TABLE `verification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

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
