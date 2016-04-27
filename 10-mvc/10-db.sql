-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Stř 27. dub 2016, 02:52
-- Verze serveru: 5.6.17
-- Verze PHP: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Databáze: `xname`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `articles`
--

CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) COLLATE utf8_czech_ci NOT NULL,
  `perex` text COLLATE utf8_czech_ci NOT NULL,
  `content` text COLLATE utf8_czech_ci NOT NULL,
  `category` int(11) NOT NULL,
  `author` int(11) NOT NULL,
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `author` (`author`),
  KEY `category` (`category`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='Tabulka obsahující články v CMS' AUTO_INCREMENT=6 ;

--
-- Vypisuji data pro tabulku `articles`
--

INSERT INTO `articles` (`id`, `title`, `perex`, `content`, `category`, `author`, `last_modified`) VALUES
(3, 'Admini', '<p>Bavi se dva admini</p>', '<ul>\r\n<li>K&aacute;mo&scaron; včera během 5 minut shodil hlavn&iacute; server.</li>\r\n<li>On je hacker?</li>\r\n<li>Ne, debil.</li>\r\n</ul>', 1, 9, '2016-04-27 00:51:08'),
(4, 'Já tam nechci...', '<p>"Vst&aacute;vej synku, mus&iacute;&scaron; do &scaron;koly!"</p>', '<p>"Maminko, j&aacute; tam nechci, oni mě tam vůbec neberou, směj&iacute; se mi... Opravdu tam mus&iacute;m j&iacute;t?"</p>\r\n<p>"Mus&iacute;&scaron;, mus&iacute;&scaron;, vždyť jse&scaron; učitel."</p>', 1, 9, '2016-04-27 00:48:10'),
(5, ':)', '<p><strong>funguje to...</strong></p>', '<p>pr&aacute;vě se V&aacute;m podařilo rozchodit uk&aacute;zkov&aacute; př&iacute;klad...</p>', 2, 9, '2016-04-27 00:50:18');

-- --------------------------------------------------------

--
-- Struktura tabulky `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_czech_ci NOT NULL,
  `order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='Tabulka obsahující přehled kategorií' AUTO_INCREMENT=4 ;

--
-- Vypisuji data pro tabulku `categories`
--

INSERT INTO `categories` (`id`, `name`, `order`) VALUES
(1, 'Vtipy', 1),
(2, 'Novinky', 0),
(3, 'Poznámky', 2);

-- --------------------------------------------------------

--
-- Struktura tabulky `resources`
--

CREATE TABLE IF NOT EXISTS `resources` (
  `role` varchar(20) COLLATE utf8_czech_ci NOT NULL,
  `resource` varchar(100) COLLATE utf8_czech_ci NOT NULL,
  `action` varchar(100) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`role`,`resource`,`action`),
  KEY `role` (`role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='Tabulka obsahující přehled oprávnění přístupu ke zdrojům';

--
-- Vypisuji data pro tabulku `resources`
--

INSERT INTO `resources` (`role`, `resource`, `action`) VALUES
('admin', 'category', ''),
('admin', 'user', ''),
('editor', 'article', ''),
('editor', 'comment', ''),
('guest', 'article', 'list'),
('guest', 'article', 'show'),
('guest', 'homepage', ''),
('guest', 'user', 'login'),
('guest', 'user', 'register'),
('registered', 'comment', 'new'),
('registered', 'user', 'logout');

-- --------------------------------------------------------

--
-- Struktura tabulky `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` varchar(20) COLLATE utf8_czech_ci NOT NULL,
  `parent_id` varchar(20) COLLATE utf8_czech_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_role` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='Tabulka obsahující přehled podporovaných rolí';

--
-- Vypisuji data pro tabulku `roles`
--

INSERT INTO `roles` (`id`, `parent_id`) VALUES
('guest', NULL),
('admin', 'editor'),
('registered', 'guest'),
('editor', 'registered');

-- --------------------------------------------------------

--
-- Struktura tabulky `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_czech_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `password` varchar(200) COLLATE utf8_czech_ci NOT NULL,
  `role` varchar(20) COLLATE utf8_czech_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `role` (`role`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='Tabulka obsahující uživatelské účty' AUTO_INCREMENT=11 ;

--
-- Vypisuji data pro tabulku `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `active`) VALUES
(9, 'xname', 'xname@vse.cz', '$2y$10$Jp2.VQ.ecpwQk7Rs6O20Nuad2uLQ.delHfCgToDCy9oLVMARckzEm', 'registered', 1),
(10, 'xadmin', 'xadmin@vse.cz', '$2y$10$7y1iNg56lD57m0zXc9tq4eedcxp3HBUjvHihagr0cIwQ394Bg/D7G', 'admin', 1);

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articleCategory` FOREIGN KEY (`category`) REFERENCES `categories` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `articleUser` FOREIGN KEY (`author`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Omezení pro tabulku `resources`
--
ALTER TABLE `resources`
  ADD CONSTRAINT `resources_ibfk_1` FOREIGN KEY (`role`) REFERENCES `roles` (`id`) ON UPDATE CASCADE;

--
-- Omezení pro tabulku `roles`
--
ALTER TABLE `roles`
  ADD CONSTRAINT `parentRole` FOREIGN KEY (`parent_id`) REFERENCES `roles` (`id`) ON UPDATE CASCADE;

--
-- Omezení pro tabulku `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `userRule` FOREIGN KEY (`role`) REFERENCES `roles` (`id`) ON UPDATE CASCADE;
