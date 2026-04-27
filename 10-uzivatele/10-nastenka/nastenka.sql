-- phpMyAdmin SQL Dump
-- https://www.phpmyadmin.net/

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `xvojs03`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `categories`
--

CREATE TABLE `n_categories` (
  `category_id` smallint(6) NOT NULL,
  `name` varchar(30) COLLATE utf8mb4_czech_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci COMMENT='Tabulka s přehledem kategorií';

--
-- Vypisuji data pro tabulku `categories`
--

INSERT INTO `n_categories` (`category_id`, `name`) VALUES
(1, 'Novinky');

-- --------------------------------------------------------

--
-- Struktura tabulky `posts`
--

CREATE TABLE `n_posts` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` smallint(6) NOT NULL,
  `text` text COLLATE utf8mb4_czech_ci NOT NULL,
  `updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci COMMENT='Tabulka s příspěvky';

--
-- Vypisuji data pro tabulku `posts`
--

INSERT INTO `n_posts` (`post_id`, `user_id`, `category_id`, `text`, `updated`) VALUES
(1, 1, 1, 'Testovací příspěvek', '2020-03-21 00:54:12');

-- --------------------------------------------------------

--
-- Struktura tabulky `users`
--

CREATE TABLE `n_users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(30) COLLATE utf8mb4_czech_ci NOT NULL,
  `email` varchar(200) COLLATE utf8mb4_czech_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci COMMENT='Tabulka s daty uživatelů';

--
-- Vypisuji data pro tabulku `users`
--

INSERT INTO `n_users` (`user_id`, `name`, `email`) VALUES
(1, 'Adam', 'adam@domena.tld'),
(2, 'Eva', 'eva@domena.tld');

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `categories`
--
ALTER TABLE `n_categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Klíče pro tabulku `posts`
--
ALTER TABLE `n_posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Klíče pro tabulku `users`
--
ALTER TABLE `n_users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `categories`
--
ALTER TABLE `n_categories`
  MODIFY `category_id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pro tabulku `posts`
--
ALTER TABLE `n_posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pro tabulku `users`
--
ALTER TABLE `n_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `posts`
--
ALTER TABLE `n_posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `n_categories` (`category_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `n_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
