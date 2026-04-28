-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
-- Verze PHP: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Databáze: `xvojs03`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `forgotten_passwords`
--

CREATE TABLE `forgotten_passwords` (
                                       `forgotten_password_id` int(10) UNSIGNED NOT NULL,
                                       `user_id` int(10) UNSIGNED NOT NULL,
                                       `code` varchar(255) NOT NULL,
                                       `created` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `users`
--

CREATE TABLE `users` (
                         `user_id` int(10) UNSIGNED NOT NULL,
                         `name` varchar(100) NOT NULL,
                         `email` varchar(255) NOT NULL,
                         `password` varchar(255) DEFAULT NULL,
                         `google_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Indexy pro exportované tabulky
--

--
-- Indexy pro tabulku `forgotten_passwords`
--
ALTER TABLE `forgotten_passwords`
    ADD PRIMARY KEY (`forgotten_password_id`);

--
-- Indexy pro tabulku `users`
--
ALTER TABLE `users`
    ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `google_id` (`google_id`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `forgotten_passwords`
--
ALTER TABLE `forgotten_passwords`
    MODIFY `forgotten_password_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pro tabulku `users`
--
ALTER TABLE `users`
    MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;
