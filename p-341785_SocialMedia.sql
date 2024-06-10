-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Июн 11 2024 г., 00:00
-- Версия сервера: 10.6.17-MariaDB-cll-lve
-- Версия PHP: 8.2.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `p-341785_SocialMedia`
--

-- --------------------------------------------------------

--
-- Структура таблицы `courses`
--

CREATE TABLE `courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `file_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `courses`
--

INSERT INTO `courses` (`id`, `title`, `file_name`) VALUES
(1, 'asdasd', 'courses/1718043410_5qpk5.png'),
(3, 'qweqwe', 'courses/1718043415_tII4h.png');

-- --------------------------------------------------------

--
-- Структура таблицы `friends`
--

CREATE TABLE `friends` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user1_id` bigint(20) UNSIGNED NOT NULL,
  `user2_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `friends`
--

INSERT INTO `friends` (`id`, `user1_id`, `user2_id`, `created_at`, `updated_at`) VALUES
(1, 1, 3, '2024-06-10 19:20:13', '2024-06-10 19:20:13'),
(2, 3, 1, '2024-06-10 19:20:13', '2024-06-10 19:20:13');

-- --------------------------------------------------------

--
-- Структура таблицы `friend_requests`
--

CREATE TABLE `friend_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_user_id` bigint(20) UNSIGNED NOT NULL,
  `is_accepted` tinyint(1) NOT NULL,
  `is_blocked` tinyint(1) NOT NULL,
  `is_declined` tinyint(1) NOT NULL,
  `is_waiting` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `friend_requests`
--

INSERT INTO `friend_requests` (`id`, `user_id`, `receiver_user_id`, `is_accepted`, `is_blocked`, `is_declined`, `is_waiting`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 1, 0, 0, 0, '2024-06-10 19:20:09', '2024-06-10 19:20:13');

-- --------------------------------------------------------

--
-- Структура таблицы `gruppas`
--

CREATE TABLE `gruppas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT 'images/anonymus-avatar.jpg',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `gruppas`
--

INSERT INTO `gruppas` (`id`, `name`, `description`, `image`, `created_at`, `updated_at`, `status`) VALUES
(1, 'Әлеуметтік желі әкімшілігі', '12345', 'groupsAvatars/1718043443_vx7My.jpg', NULL, '2024-06-10 19:17:23', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `gruppa_messages`
--

CREATE TABLE `gruppa_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `gruppa_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `message` text DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `gruppa_messages`
--

INSERT INTO `gruppa_messages` (`id`, `gruppa_id`, `user_id`, `message`, `file_name`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'dawdaw', '', '2024-06-10 19:17:29', '2024-06-10 19:17:29'),
(2, 1, 1, '', 'f935e58b-ae86-478e-bb38-c0ade3f42f53.jpg', '2024-06-10 19:17:33', '2024-06-10 19:17:33');

-- --------------------------------------------------------

--
-- Структура таблицы `gruppa_users`
--

CREATE TABLE `gruppa_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `gruppa_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `gruppa_users`
--

INSERT INTO `gruppa_users` (`id`, `gruppa_id`, `user_id`, `created_at`, `updated_at`, `is_admin`) VALUES
(1, 1, 1, '2024-06-10 19:25:45', '2024-06-10 19:25:45', 1),
(2, 1, 3, '2024-06-10 19:23:50', '2024-06-10 19:23:50', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `message` text DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `sendler_user_id` bigint(20) UNSIGNED NOT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `audio_file_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `messages`
--

INSERT INTO `messages` (`id`, `message`, `user_id`, `sendler_user_id`, `file_name`, `created_at`, `updated_at`, `audio_file_path`) VALUES
(3, '', 1, 3, '5b196e58-ad5d-4757-8155-8130f2ec32ac.jpg', '2024-06-10 19:17:50', '2024-06-10 19:17:50', ''),
(4, '', 1, 3, '', '2024-06-10 19:17:55', '2024-06-10 19:17:55', 'audio_1718043475.webm'),
(5, '', 1, 3, 'CodeDecodeApp.exe', '2024-06-10 19:18:23', '2024-06-10 19:18:23', '');

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_100000_create_password_resets_table', 1),
(2, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(3, '2023_10_26_111437_create_users_table', 1),
(4, '2023_10_27_230200_create_posts_table', 1),
(9, '2023_11_09_100326_create_messages_table', 4),
(12, '2023_11_17_154511_create_friends_table', 6),
(13, '2023_11_17_152127_create_friend_requests_table', 7),
(14, '2023_11_18_144334_create_user_post_relationships_table', 8),
(22, '2023_11_30_015005_create_user_post_bookmarks_table', 9),
(23, '2023_12_26_141247_create_gruppas_table', 9),
(24, '2023_12_26_141632_create_gruppa_users_table', 9),
(25, '2023_12_26_141912_create_gruppa_messages_table', 9),
(26, '2024_01_02_222702_add_audio_file_path_to_messages_table', 10),
(27, '2023_10_31_120337_create_courses_table', 11);

-- --------------------------------------------------------

--
-- Структура таблицы `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('test9@mail.ru', '$2y$10$aDBBGOrQ9jmIbRcamEWY8.CMsLwIMOxbRxQtGVc35zsuVYDO1wDYO', '2023-11-30 06:49:49');

-- --------------------------------------------------------

--
-- Структура таблицы `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` text NOT NULL,
  `content` text DEFAULT NULL,
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `video` varchar(255) DEFAULT NULL,
  `published_at` datetime NOT NULL DEFAULT current_timestamp(),
  `is_published` tinyint(1) NOT NULL DEFAULT 1,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `posts`
--

INSERT INTO `posts` (`id`, `title`, `content`, `description`, `image`, `video`, `published_at`, `is_published`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'dawdaw', 'dawd', 'awdaw', 'posts/1718043390_4AkW9.jpg', 'dawd', '2024-06-10 22:37:55', 1, 1, '2024-06-10 18:37:55', '2024-06-10 19:16:30');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `nickname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `real_password` varchar(255) NOT NULL,
  `birthday` date DEFAULT NULL,
  `oblys` varchar(255) DEFAULT NULL,
  `qala` varchar(255) DEFAULT NULL,
  `mamandyq` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT 0,
  `iin` varchar(45) NOT NULL,
  `fio` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `lastname`, `surname`, `nickname`, `email`, `password`, `real_password`, `birthday`, `oblys`, `qala`, `mamandyq`, `phone`, `avatar`, `admin`, `iin`, `fio`) VALUES
(1, 'Qazybek', 'asdasdasd', 'Tester', 'wqdwq', 'test@mail.ru', '8cb2237d0679ca88db6464eac60da96345513964', '12345', NULL, NULL, NULL, NULL, NULL, 'avatars/1718043383_B4I2V.jpg', 1, '030804500900', 'Tester asdasdasd Qazybek'),
(2, 'Казыбек', 'Ермекулы', 'цйацйа', 'цйацй', 'test9@mail.ru', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', '123456789', NULL, NULL, 'Kentau', NULL, NULL, 'images/anonymus-avatar.jpg', 0, '030804500920', 'цйацйа Ермекулы Казыбек'),
(3, 'Qazybek', 'Ermekuly', 'Qoishygara', 'Shizik', 'test3@mail.ru', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', '123456789', '2003-08-04', 'Turkestan', 'Kentau', 'Proger', '+7 (700) 252-67-61', 'avatars/1718043604_GyNNK.jpg', 0, '123456789123', 'Qoishygara Ermekuly Qazybek'),
(4, 'Аслан', 'Асанов', 'Елеусіз', 'askoEdu', 'askon039@gmail.com', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', '123456789', NULL, NULL, NULL, NULL, NULL, 'images/anonymus-avatar.jpg', 1, '1234567891234567', 'Елеусіз Асанов Аслан'),
(5, 'Qazybek', 'Ermekuly', 'Qoishygara', 'Shizik', 'qq13k13k@gmail.com', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', '123456789', NULL, 'Turkestan', 'Kentau', 'Proger', '+7 (700) 252-67-61', 'images/anonymus-avatar.jpg', 1, '12025678912', 'Qoishygara Ermekuly Qazybek'),
(6, 'Nurmuhamed', 'Ermekuly', 'Qoishygara', 'Nurik', 'nurmukhammed.koishygara@gmail.com', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', '123456789', '2024-05-29', 'Туркестан', 'Кентау', 'Программист', '7 777 777 77 77', 'images/anonymus-avatar.jpg', 1, '12345', 'Qoishygara Ermekuly Nurmuhamed'),
(7, 'Карина', 'Муратовна', 'Абдуллаева', 'Deoxximaa', 'nekrasova11b04@gmail.com', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', '123456789', '2010-02-04', 'Туркестанская область', 'Туркестан', 'Информационные технологии', '87001418004', 'images/anonymus-avatar.jpg', 0, '', ''),
(8, 'Aktore', 'Abu', 'Ak', 'sakdaskdj', 'asdaskpaskfisdnoia!@gmail.com', '$2y$10$E19ExLAFuey5nKje7rmGj.ESFcl2.QeWmEV8rlK.KaYZky0HZiAzy', '9FGrJnceNVUyXs9', NULL, NULL, NULL, NULL, NULL, 'images/anonymus-avatar.jpg', 0, '', ''),
(9, 'Maksat', 'Marat', 'Faizulla', 'Patrick', 'maratyskakov72@gmail.com', 'maks99++', 'maks99++', NULL, 'Түркістан', NULL, NULL, NULL, 'images/anonymus-avatar.jpg', 0, '', ''),
(10, 'privet', 'dondondikidon', 'hello', 'printhelloworld', 'arsenghmcmatu@gmail.com', 'Hyfqum-kozjy2-ryjjez', 'Hyfqum-kozjy2-ryjjez', NULL, NULL, NULL, NULL, NULL, 'images/anonymus-avatar.jpg', 0, '030804500920', ''),
(11, 'Yusup', 'Mamataliev', 'Sherzatuly', 'Legend', 'mamataliev.yusuf2003@gmail.com', '$2y$10$W47sNsNpw7f8N.l8UBafouPLfFu9kc5MdORBtSy7Rg6hC2lhj231C', 'yusuf2003', NULL, NULL, NULL, NULL, NULL, 'images/anonymus-avatar.jpg', 0, '', ''),
(12, 'Галымжан', 'Казбекулы', 'Айсултанов', 'galymzhan', 'aisultanov.galym@gmail.com', '12345678', '12345678', NULL, NULL, NULL, NULL, NULL, 'images/anonymus-avatar.jpg', 0, '', ''),
(13, 'kanat', 'sdfg', 'rter', 'kano', 'a_kanat@inbox.ru', '$2y$10$yDFIq1fyWdYkpAlL4G6aDeTI2lf1lVTiePRpYFgBkB06.kYKuAFeK', '123456789', NULL, NULL, NULL, NULL, NULL, 'images/anonymus-avatar.jpg', 0, '', ''),
(14, 'Umid', 'Umid', 'Umid', 'UmiD', 'shodiyor.2000@gmail.com', '$2y$10$L.itBUm5hTkL06lGgH1B4.1HHh73e79WR250VJ8tqWgBZPY/F2bB6', 'U7Fs3RX7nVVJu8V', NULL, NULL, NULL, NULL, NULL, 'images/anonymus-avatar.jpg', 0, '', ''),
(15, 'Dauren', 'Pernebay', 'Batyrhanuly', 'daurenqwe586', 'daurn233@gmail.com', '$2y$10$dWcb/ikqWEtYIklsnEr8JetgT1sgddtrt3zB1iVkV2O9V6OIwkC7W', '8T:EKCk6TERzJqV', NULL, NULL, NULL, NULL, NULL, 'images/anonymus-avatar.jpg', 0, '', ''),
(16, 'dwq', 'dqw', 'dqw', 'dwq', 'fwdqwe@gmail.com', '', '123456789', NULL, NULL, NULL, NULL, NULL, 'images/anonymus-avatar.jpg', 0, '', ''),
(17, 'Test99', 'Test99', 'Test99', 'Test99', 'test99@mail.ru', '$2y$10$mWdAzhHvdR2KPVYsD4H/eOJKr/kC18k/fSkW2IGUZfhDt9zhx8ewC', '12345678', NULL, NULL, NULL, NULL, NULL, 'images/anonymus-avatar.jpg', 0, '12345', ''),
(18, 'testest', 'testest', 'testest', 'testest', 'testest@abcdef', '12345', '12345', '2024-05-16', NULL, NULL, NULL, NULL, 'images/anonymus-avatar.jpg', 0, '03080450099', ''),
(19, 'registers', 'registersdsd', 'register', 'register', 'register@register', 'registerregister', 'registerregister', NULL, NULL, NULL, NULL, NULL, 'images/anonymus-avatar.jpg', 1, '123456789123', ''),
(21, 'asdasd', 'asdasd', 'asdasd', 'asdasd', 'testsad@mail.com', '$2y$10$npcUQ3wgiT4GoPT97OAlcO0q6MsmxCiYc4rSIeV1Zo0SwzjHkNpL6', 'asdasd', NULL, NULL, NULL, NULL, NULL, 'images/anonymus-avatar.jpg', 0, '123456789123898', ''),
(22, 'asdasd', 'asdasd', 'asdasda', 'sdasdasd', 'darysdy_2003@mail.ru', '7c222fb2927d828af22f592134e8932480637c0d', '12345678', NULL, NULL, NULL, NULL, NULL, 'images/anonymus-avatar.jpg', 0, '123456123456', 'asdasda asdasd asdasd');

-- --------------------------------------------------------

--
-- Структура таблицы `user_post_bookmarks`
--

CREATE TABLE `user_post_bookmarks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `user_post_relationships`
--

CREATE TABLE `user_post_relationships` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `user_post_relationships`
--

INSERT INTO `user_post_relationships` (`id`, `post_id`, `user_id`) VALUES
(1, 1, 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `friend_requests`
--
ALTER TABLE `friend_requests`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `gruppas`
--
ALTER TABLE `gruppas`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `gruppa_messages`
--
ALTER TABLE `gruppa_messages`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `gruppa_users`
--
ALTER TABLE `gruppa_users`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Индексы таблицы `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Индексы таблицы `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Индексы таблицы `user_post_bookmarks`
--
ALTER TABLE `user_post_bookmarks`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user_post_relationships`
--
ALTER TABLE `user_post_relationships`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `courses`
--
ALTER TABLE `courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `friends`
--
ALTER TABLE `friends`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `friend_requests`
--
ALTER TABLE `friend_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `gruppas`
--
ALTER TABLE `gruppas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `gruppa_messages`
--
ALTER TABLE `gruppa_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `gruppa_users`
--
ALTER TABLE `gruppa_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT для таблицы `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT для таблицы `user_post_bookmarks`
--
ALTER TABLE `user_post_bookmarks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `user_post_relationships`
--
ALTER TABLE `user_post_relationships`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
