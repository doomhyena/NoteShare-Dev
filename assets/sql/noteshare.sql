CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `postid` int(11) NOT NULL,
  `text` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `uploaded_by` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `file_path` varchar(255) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `tags` varchar(255) NOT NULL,
  `tn_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `friends`
--

CREATE TABLE `friends` (
  `id` int(11) NOT NULL,
  `fromid` int(11) NOT NULL,
  `toid` int(11) NOT NULL,
  `status` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `messages`
--

CREATE TABLE `messages` (
  `id` int(255) NOT NULL,
  `fromid` int(255) NOT NULL,
  `toid` int(255) NOT NULL,
  `content` text NOT NULL,
  `sent_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `namedays`
--

CREATE TABLE `namedays` (
  `id` int(11) NOT NULL,
  `datum` varchar(5) DEFAULT NULL,
  `nevek` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `namedays`
--

INSERT INTO `namedays` (`id`, `datum`, `nevek`) VALUES
(1, '01-01', 'Fruzsina'),
(2, '01-02', 'Ábel'),
(3, '01-03', 'Benjámin, Genovéva'),
(4, '01-04', 'Leóna, Titusz'),
(5, '01-05', 'Simon'),
(6, '01-06', 'Boldizsár'),
(7, '01-07', 'Attila, Ramóna'),
(8, '01-08', 'Gyöngyvér'),
(9, '01-09', 'Marcell'),
(10, '01-10', 'Melánia'),
(11, '01-11', 'Ágota'),
(12, '01-12', 'Ernő'),
(13, '01-13', 'Veronika'),
(14, '01-14', 'Bódog'),
(15, '01-15', 'Lóránd, Lóránt'),
(16, '01-16', 'Gusztáv'),
(17, '01-17', 'Antal, Antónia'),
(18, '01-18', 'Piroska'),
(19, '01-19', 'Márió, Sára'),
(20, '01-20', 'Fábián, Sebestyén'),
(21, '01-21', 'Ágnes'),
(22, '01-22', 'Artúr, Vince'),
(23, '01-23', 'Rajmund, Zelma'),
(24, '01-24', 'Timót'),
(25, '01-25', 'Pál'),
(26, '01-26', 'Paula, Vanda'),
(27, '01-27', 'Angelika'),
(28, '01-28', 'Karola, Károly'),
(29, '01-29', 'Adél'),
(30, '01-30', 'Martina'),
(31, '01-31', 'Gerda, Marcella'),
(32, '02-01', 'Ignác'),
(33, '02-02', 'Aida, Karolina'),
(34, '02-03', 'Balázs'),
(35, '02-04', 'Csenge, Ráhel'),
(36, '02-05', 'Ágota, Ingrid'),
(37, '02-06', 'Dóra, Dorottya'),
(38, '02-07', 'Rómeó, Tódor'),
(39, '02-08', 'Aranka'),
(40, '02-09', 'Abigél, Alex'),
(41, '02-10', 'Elvira'),
(42, '02-11', 'Bertold, Marietta'),
(43, '02-12', 'Lídia, Lívia'),
(44, '02-13', 'Ella, Linda'),
(45, '02-14', 'Bálint, Valentin'),
(46, '02-15', 'Georgina, Kolos'),
(47, '02-16', 'Julianna, Lilla'),
(48, '02-17', 'Donát'),
(49, '02-18', 'Bernadett'),
(50, '02-19', 'Zsuzsanna'),
(51, '02-20', 'Aladár, Álmos'),
(52, '02-21', 'Eleonóra'),
(53, '02-22', 'Gerzson'),
(54, '02-23', 'Alfréd'),
(55, '02-24', 'Mátyás'),
(56, '02-25', 'Géza'),
(57, '02-26', 'Edina'),
(58, '02-27', 'Ákos, Bátor'),
(59, '02-28', 'Elemér'),
(60, '03-01', 'Albin'),
(61, '03-02', 'Lujza'),
(62, '03-03', 'Kornélia'),
(63, '03-04', 'Kázmér'),
(64, '03-05', 'Adorján, Adrián'),
(65, '03-06', 'Inez, Leonóra'),
(66, '03-07', 'Tamás'),
(67, '03-08', 'Zoltán'),
(68, '03-09', 'Fanni, Franciska'),
(69, '03-10', 'Ildikó'),
(70, '03-11', 'Szilárd'),
(71, '03-12', 'Gergely'),
(72, '03-13', 'Ajtony, Krisztián'),
(73, '03-14', 'Matild'),
(74, '03-15', 'Kristóf'),
(75, '03-16', 'Henrietta'),
(76, '03-17', 'Gertrúd, Patrik'),
(77, '03-18', 'Ede, Sándor'),
(78, '03-19', 'Bánk, József'),
(79, '03-20', 'Klaudia'),
(80, '03-21', 'Benedek'),
(81, '03-22', 'Beáta, Izolda'),
(82, '03-23', 'Emőke'),
(83, '03-24', 'Gábor, Karina'),
(84, '03-25', 'Irén, Írisz'),
(85, '03-26', 'Emánuel'),
(86, '03-27', 'Hajnalka'),
(87, '03-28', 'Gedeon, Johanna'),
(88, '03-29', 'Auguszta'),
(89, '03-30', 'Zalán'),
(90, '03-31', 'Árpád'),
(91, '04-01', 'Hugó'),
(92, '04-02', 'Áron'),
(93, '04-03', 'Buda, Richárd'),
(94, '04-04', 'Izidor'),
(95, '04-05', 'Vince'),
(96, '04-06', 'Bíborka, Vilmos'),
(97, '04-07', 'Herman'),
(98, '04-08', 'Dénes'),
(99, '04-09', 'Erhard'),
(100, '04-10', 'Zsolt'),
(101, '04-11', 'Leó, Szaniszló'),
(102, '04-12', 'Gyula'),
(103, '04-13', 'Ida'),
(104, '04-14', 'Tibor'),
(105, '04-15', 'Anasztázia, Tas'),
(106, '04-16', 'Csongor'),
(107, '04-17', 'Rudolf'),
(108, '04-18', 'Andrea, Ilma'),
(109, '04-19', 'Emma'),
(110, '04-20', 'Tivadar'),
(111, '04-21', 'Konrád'),
(112, '04-22', 'Csilla, Noémi'),
(113, '04-23', 'Béla'),
(114, '04-24', 'György'),
(115, '04-25', 'Márk'),
(116, '04-26', 'Ervin'),
(117, '04-27', 'Zita'),
(118, '04-28', 'Valéria'),
(119, '04-29', 'Péter'),
(120, '04-30', 'Katalin, Kitti'),
(121, '05-01', 'Fülöp, Jakab'),
(122, '05-02', 'Zsigmond'),
(123, '05-03', 'Irma, Tímea'),
(124, '05-04', 'Flórián, Mónika'),
(125, '05-05', 'Adrián, Györgyi'),
(126, '05-06', 'Frida, Ivett'),
(127, '05-07', 'Gizella'),
(128, '05-08', 'Mihály'),
(129, '05-09', 'Gergely'),
(130, '05-10', 'Ármin, Pálma, Mira'),
(131, '05-11', 'Ferenc'),
(132, '05-12', 'Pongrác'),
(133, '05-13', 'Imola, Szervác'),
(134, '05-14', 'Bonifác'),
(135, '05-15', 'Szonja, Zsófia'),
(136, '05-16', 'Botond, Mózes'),
(137, '05-17', 'Paszkál'),
(138, '05-18', 'Alexandra, Erik'),
(139, '05-19', 'Ivó, Milán'),
(140, '05-20', 'Bernát, Felícia'),
(141, '05-21', 'Konstantin'),
(142, '05-22', 'Júlia, Rita'),
(143, '05-23', 'Dezső'),
(144, '05-24', 'Eliza, Eszter'),
(145, '05-25', 'Orbán'),
(146, '05-26', 'Evelin, Fülöp'),
(147, '05-27', 'Hella'),
(148, '05-28', 'Csanád, Emil'),
(149, '05-29', 'Magdolna'),
(150, '05-30', 'Janka, Zsanett'),
(151, '05-31', 'Angéla'),
(152, '06-01', 'Tünde'),
(153, '06-02', 'Anita, Kármen'),
(154, '06-03', 'Klotild'),
(155, '06-04', 'Bulcsú'),
(156, '06-05', 'Fatime'),
(157, '06-06', 'Cintia, Norbert'),
(158, '06-07', 'Róbert'),
(159, '06-08', 'Medárd'),
(160, '06-09', 'Félix'),
(161, '06-10', 'Gréta, Margit'),
(162, '06-11', 'Barnabás'),
(163, '06-12', 'Villő'),
(164, '06-13', 'Anett, Antal'),
(165, '06-14', 'Vazul'),
(166, '06-15', 'Jolán, Vid'),
(167, '06-16', 'Jusztin'),
(168, '06-17', 'Alida, Laura'),
(169, '06-18', 'Arnold, Levente'),
(170, '06-19', 'Gyárfás'),
(171, '06-20', 'Rafael'),
(172, '06-21', 'Alajos, Leila'),
(173, '06-22', 'Paulina'),
(174, '06-23', 'Zoltán'),
(175, '06-24', 'Iván'),
(176, '06-25', 'Vilmos'),
(177, '06-26', 'János, Pál'),
(178, '06-27', 'László'),
(179, '06-28', 'Irén, Levente'),
(180, '06-29', 'Péter, Pál'),
(181, '06-30', 'Pál'),
(182, '07-01', 'Annamária, Tihamér'),
(183, '07-02', 'Ottó'),
(184, '07-03', 'Kornél, Soma'),
(185, '07-04', 'Ulrik'),
(186, '07-05', 'Emese, Sarolta'),
(187, '07-06', 'Csaba'),
(188, '07-07', 'Apollónia'),
(189, '07-08', 'Ellák'),
(190, '07-09', 'Lukrécia'),
(191, '07-10', 'Amália'),
(192, '07-11', 'Lili, Nóra'),
(193, '07-12', 'Dalma, Izabella'),
(194, '07-13', 'Jenő'),
(195, '07-14', 'Örs, Stella'),
(196, '07-15', 'Henrik, Roland'),
(197, '07-16', 'Valter'),
(198, '07-17', 'Elek, Endre'),
(199, '07-18', 'Frigyes'),
(200, '07-19', 'Emília'),
(201, '07-20', 'Illés'),
(202, '07-21', 'Dániel, Daniella'),
(203, '07-22', 'Magdolna'),
(204, '07-23', 'Lenke'),
(205, '07-24', 'Kincső, Kinga'),
(206, '07-25', 'Jakab, Kristóf'),
(207, '07-26', 'Anikó, Anna'),
(208, '07-27', 'Liliána, Olga'),
(209, '07-28', 'Szabolcs'),
(210, '07-29', 'Flóra, Márta'),
(211, '07-30', 'Judit, Xénia'),
(212, '07-31', 'Oszkár'),
(213, '08-01', 'Boglárka'),
(214, '08-02', 'Lehel'),
(215, '08-03', 'Hermina'),
(216, '08-04', 'Dominika, Domonkos'),
(217, '08-05', 'Krisztina'),
(218, '08-06', 'Berta, Bettina'),
(219, '08-07', 'Ibolya'),
(220, '08-08', 'László'),
(221, '08-09', 'Emőd'),
(222, '08-10', 'Lőrinc'),
(223, '08-11', 'Tiborc, Zsuzsanna'),
(224, '08-12', 'Klára'),
(225, '08-13', 'Ipoly'),
(226, '08-14', 'Marcell'),
(227, '08-15', 'Mária'),
(228, '08-16', 'Ábrahám'),
(229, '08-17', 'Jácint'),
(230, '08-18', 'Ilona'),
(231, '08-19', 'Huba'),
(232, '08-20', 'István'),
(233, '08-21', 'Hajna, Sámuel'),
(234, '08-22', 'Menyhért, Mirjam'),
(235, '08-23', 'Bence'),
(236, '08-24', 'Bertalan'),
(237, '08-25', 'Lajos, Patrícia'),
(238, '08-26', 'Izsó'),
(239, '08-27', 'Gáspár'),
(240, '08-28', 'Ágoston'),
(241, '08-29', 'Beatrix, Erna'),
(242, '08-30', 'Rózsa'),
(243, '08-31', 'Bella, Erika'),
(244, '09-01', 'Egon, Egyed'),
(245, '09-02', 'Dorina, Rebeka'),
(246, '09-03', 'Hilda'),
(247, '09-04', 'Rozália'),
(248, '09-05', 'Lőrinc, Viktor'),
(249, '09-06', 'Zakariás'),
(250, '09-07', 'Regina'),
(251, '09-08', 'Adrienn, Mária'),
(252, '09-09', 'Adám'),
(253, '09-10', 'Hunor, Nikolett'),
(254, '09-11', 'Teodóra'),
(255, '09-12', 'Mária'),
(256, '09-13', 'Kornél'),
(257, '09-14', 'Roxána, Szeréna'),
(258, '09-15', 'Enikő, Melitta'),
(259, '09-16', 'Edit'),
(260, '09-17', 'Zsófia'),
(261, '09-18', 'Diána'),
(262, '09-19', 'Vilhelmina'),
(263, '09-20', 'Friderika'),
(264, '09-21', 'Máté, Mirella'),
(265, '09-22', 'Móric'),
(266, '09-23', 'Tekla'),
(267, '09-24', 'Gellért, Mercédesz'),
(268, '09-25', 'Eufrozina, Kende'),
(269, '09-26', 'Jusztina, Pál'),
(270, '09-27', 'Adalbert'),
(271, '09-28', 'Vencel'),
(272, '09-29', 'Mihály'),
(273, '09-30', 'Jeromos'),
(274, '10-01', 'Malvin'),
(275, '10-02', 'Petra'),
(276, '10-03', 'Helga'),
(277, '10-04', 'Ferenc'),
(278, '10-05', 'Aurél'),
(279, '10-06', 'Brúnó, Renáta'),
(280, '10-07', 'Amália'),
(281, '10-08', 'Koppány'),
(282, '10-09', 'Dénes'),
(283, '10-10', 'Gedeon'),
(284, '10-11', 'Brigitta'),
(285, '10-12', 'Miksa'),
(286, '10-13', 'Ede, Kálmán'),
(287, '10-14', 'Helén'),
(288, '10-15', 'Teréz'),
(289, '10-16', 'Gál'),
(290, '10-17', 'Hedvig'),
(291, '10-18', 'Lukács'),
(292, '10-19', 'Nándor'),
(293, '10-20', 'Vendel'),
(294, '10-21', 'Orsolya'),
(295, '10-22', 'Előd'),
(296, '10-23', 'Gyöngyi'),
(297, '10-24', 'Salamon'),
(298, '10-25', 'Bianka, Blanka'),
(299, '10-26', 'Dömötör'),
(300, '10-27', 'Szabina'),
(301, '10-28', 'Simon, Szimonetta'),
(302, '10-29', 'Nárcisz'),
(303, '10-30', 'Alfonz'),
(304, '10-31', 'Farkas'),
(305, '11-01', 'Marianna'),
(306, '11-02', 'Achilles'),
(307, '11-03', 'Győző'),
(308, '11-04', 'Károly'),
(309, '11-05', 'Imre'),
(310, '11-06', 'Lénárd'),
(311, '11-07', 'Rezső'),
(312, '11-08', 'Zsombor'),
(313, '11-09', 'Tivadar'),
(314, '11-10', 'Réka'),
(315, '11-11', 'Márton'),
(316, '11-12', 'Jónás, Renátó'),
(317, '11-13', 'Szilvia'),
(318, '11-14', 'Aliz'),
(319, '11-15', 'Albert, Lipót'),
(320, '11-16', 'Ödön'),
(321, '11-17', 'Gergő, Hortenzia'),
(322, '11-18', 'Jenő'),
(323, '11-19', 'Erzsébet'),
(324, '11-20', 'Jolán'),
(325, '11-21', 'Olivér'),
(326, '11-22', 'Cecília'),
(327, '11-23', 'Kelemen, Klementina'),
(328, '11-24', 'Emma'),
(329, '11-25', 'Katalin'),
(330, '11-26', 'Virág'),
(331, '11-27', 'Virgil'),
(332, '11-28', 'Stefánia'),
(333, '11-29', 'Taksony'),
(334, '11-30', 'Andor, András'),
(335, '12-01', 'Elza'),
(336, '12-02', 'Melinda, Vivien'),
(337, '12-03', 'Ferenc, Olívia'),
(338, '12-04', 'Barbara, Borbála'),
(339, '12-05', 'Vilma'),
(340, '12-06', 'Miklós'),
(341, '12-07', 'Ambrus'),
(342, '12-08', 'Mária'),
(343, '12-09', 'Natália'),
(344, '12-10', 'Judit'),
(345, '12-11', 'Árpád'),
(346, '12-12', 'Gabriella'),
(347, '12-13', 'Luca, Otília'),
(348, '12-14', 'Szilárda'),
(349, '12-15', 'Valér'),
(350, '12-16', 'Aletta, Etelka'),
(351, '12-17', 'Lázár, Olimpia'),
(352, '12-18', 'Auguszta'),
(353, '12-19', 'Viola'),
(354, '12-20', 'Teofil'),
(355, '12-21', 'Tamás'),
(356, '12-22', 'Zénó'),
(357, '12-23', 'Viktória'),
(358, '12-24', 'Adám, Éva'),
(359, '12-25', 'Eugénia'),
(360, '12-26', 'István'),
(361, '12-27', 'János'),
(362, '12-28', 'Kamilla'),
(363, '12-29', 'Tamara, Tamás'),
(364, '12-30', 'Dávid'),
(365, '12-31', 'Szilveszter');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `notifys`
--

CREATE TABLE `notifys` (
  `id` int(11) NOT NULL,
  `fromid` int(255) NOT NULL,
  `toid` int(255) NOT NULL,
  `notifytype` varchar(100) NOT NULL,
  `readed` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tábla szerkezet ehhez a táblához `ratings`
--

CREATE TABLE `ratings` (
  `id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` tinyint(1) NOT NULL CHECK (`rating` between 1 and 5),
  `rated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `firstname` varchar(100) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `birthdate` date DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `security_question` varchar(255) NOT NULL,
  `security_answer` varchar(255) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `registration_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fromid` (`fromid`),
  ADD KEY `toid` (`toid`);

--
-- A tábla indexei `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `notifys`
--
ALTER TABLE `notifys`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `file_id` (`file_id`),
  ADD KEY `user_id` (`user_id`);

--
-- A tábla indexei `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT a táblához `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT a táblához `friends`
--
ALTER TABLE `friends`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT a táblához `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT a táblához `notifys`
--
ALTER TABLE `notifys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT a táblához `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT a táblához `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `friends`
--
ALTER TABLE `friends`
  ADD CONSTRAINT `friends_ibfk_1` FOREIGN KEY (`fromid`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `friends_ibfk_2` FOREIGN KEY (`toid`) REFERENCES `users` (`id`);

--
-- Megkötések a táblához `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_file_fk` FOREIGN KEY (`file_id`) REFERENCES `files` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ratings_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;