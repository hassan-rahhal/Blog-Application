SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `content` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED DEFAULT NULL,
  `comment_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `comments` (`id`, `content`, `user_id`, `post_id`, `comment_id`, `created_at`) VALUES
(4, 'thanks', 1, 1, NULL, '2024-12-06 19:32:59'),
(5, 'Test', 1, 1, NULL, '2024-12-06 19:40:59'),
(6, 'bla', 1, 1, NULL, '2024-12-06 19:41:04'),
(7, 'you&#039;re welcome', 1, 1, 4, '2024-12-06 19:48:25'),
(8, 'test', 1, 1, 6, '2024-12-06 19:55:53'),
(9, 'hasan', 1, 1, 6, '2024-12-06 19:55:58'),
(10, 'youbee', 1, 1, 4, '2024-12-06 19:56:09'),
(11, 'hi', 1, 1, 6, '2024-12-06 19:56:17'),
(12, 'test2', 1, 1, 5, '2024-12-06 19:56:31');

CREATE TABLE `likes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `likes` (`id`, `user_id`, `post_id`) VALUES
(18, 2, 2),
(19, 2, 1),
(61, 1, 1);

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subject` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `posts` (`id`, `subject`, `content`, `user_id`, `created_at`) VALUES
(1, 'test', 'test', 1, '2024-12-06 18:25:59'),
(2, 'no comments', 'test', 1, '2024-12-06 19:41:16'),
(3, 'fsdfs', 'sdfsdf', 1, '2024-12-10 18:41:15');

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `profile` varchar(255) NOT NULL DEFAULT 'default.png',
  `is_admin` bit(1) NOT NULL DEFAULT b'0',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `users` (`id`, `email`, `name`, `password`, `profile`, `is_admin`, `created_at`) VALUES
(1, 'info@youbee.ai', 'hasan', '$2y$10$OTuFzW8c.Up9UzPUQn6owu7Dt3wxLlhCZnYC1YL7sMaPfjl6zotkK', 'default.png', b'0', '2024-12-06 18:25:52'),
(2, 'elie@elie.com', 'test', '$2y$10$X4eBz.HguUQxUILscL4efe7zpLcVsGQb0Htv/nd2Ejc4pnBGlX.we', 'default.png', b'0', '2024-12-09 19:58:09');

ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comment_id` (`comment_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`);

ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

ALTER TABLE `likes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_3` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;
