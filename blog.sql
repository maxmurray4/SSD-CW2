-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 16, 2022 at 02:04 PM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `contactName` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contactNumber` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contactEmail` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contactMessage` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `contactName`, `contactNumber`, `contactEmail`, `contactMessage`) VALUES
(1, 'Josh Whelan', '07123456789', 'joshwhelan999@gmail.com', 'test'),
(2, 'Josh Whelan', '07123456789', 'joshwhelan999@gmail.com', 'I love fifa');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `id` bigint(20) NOT NULL,
  `authorId` bigint(20) NOT NULL,
  `parentId` bigint(20) DEFAULT NULL,
  `title` varchar(75) COLLATE utf8mb4_unicode_ci NOT NULL,
  `summary` tinytext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `imgName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `authorId`, `parentId`, `title`, `summary`, `createdAt`, `updatedAt`, `content`, `imgName`) VALUES
(1, 1, NULL, 'Auto experts discuss how Gran Turismo 7 celebrates car culture', '', '2022-03-03 14:57:21', NULL, 'Since the beginning, Gran Turismo have always offered an experience where it goes beyond just racing. Staying true in being ‘The Real Driving SImulator’, GT really lets you express your innate love of cars be it through racing, collecting, tuning, photography, or simply just driving. Regardless of your background, everyone who has played GT have their own unique path and stories that often runs in direct parallels to real life experiences of cars and automotive culture.\r\nAs we get ready for Gran Turismo 7 to race onto PS4 and PS5 this Friday, we thought it would be fun to invite five of the most talented and influential automotive experts across different automotive categories to Race Service in Los Angeles, CA to see how their love of cars are experienced in GT7.\r\nSung Kang – Collector\r\n\r\nBeyond a notable actor, Sung Kang started his love for cars started very much like the classic GT Campaign mode where he purchased a relatively inexpensive Nissan 240Z online and started building it up with his friends on the weekends, tuning and learning as the build evolved through different stages of upgrades. Following its completion and debut of the “Fugu Z” at the 2016 SEMA Show (Speed Equipment Manufacturing Association), the customized Z won the coveted Gran Turismo Awards where it was later immortalized in GT Sport. Since then, Sung has continued to evolve the development of the Fugu Z and also started a collection of various vehicles including other classic JDM golden era and American Domestic vehicles, making him a true Collector.\r\nToni Breidinger – Racer\r\n\r\nProfessional NASCAR Driver and 19-time US Auto Club Champion grew up racing go-karts and naturally fell in love with the sport. Toni arrives to Race Service the day before traveling to Florida for a test weekend at Daytona International Speedway for the very first time. With our GT Simulators equipped with GT7 and the new Fanatec DD PRO, Toni had a chance to do some practice laps virtually at both the Daytona International Superspeedway and Road Course circuit configurations. She also had a chance to do her own virtual to reality comparisons of WeatherTech Raceway Laguna Seca, a local track for being from a native Californian.\r\nJon Sibal – Designer\r\n\r\nAutomotive Artist and Designer, Jon Sibal grew up playing Gran Turismo and took inspirations of 90s era Nissan GT-R from the game and he applied aero inspired designs to his personal vehicle. His love and passion for design are realized through GT7 but not just the visuals of the game but also future opportunities that are possible with the power of the Livery Editor and design projects like the Vision Gran Turismo\r\n13th Witness (Tim Mcgurr) – Photographer\r\n\r\nProfessional Photographer and Director, 13th Witness has endless stories of his favorite pass times playing past Gran Turismo including many endless nights of grinding his way to 100% GT Campaign mode completion and insane 24-hour races. GT7 was the first time he experienced the in-depth Photo Mode, but very quickly he was able to take his real-world professional photography skills and camera controls are directly mirrored in GT7.\r\nAdam LZ – Tuner\r\n\r\nCar Builder and YouTuber, Adam LZ knew very little of Gran Turismo coming into Race Service, but one look at his beloved S14 Nissan Z got him hooked into tuning in GT7 immediately. Being a true Tuner, Adam started off adjusting his suspension and transmission settings, ensuring the vehicle was going to be able to sustain the increased boost he had planned next on his upgrades list. A few laps around Tsukuba Circuit proved the Racing Soft tires didn’t give him the slippage he desired for a drift car, Adam started testing against his newfound suspension settings and LSD with various tire options. Adam is all about balance when it comes to tuning, too much of anything is never good.\r\n\r\nGran Turismo 7 races to PS5 and PS4 on March 4.', 'IMG-6220d751e29e38.09900398.jpg'),
(2, 1, NULL, 'Dead By Daylight’s Sadako Rising: Creating the curse', '', '2022-03-03 14:58:22', NULL, '', 'IMG-6220d78eab1ba0.67435449.jpg'),
(3, 1, NULL, 'Free visual novel prequel Ghostwire: Tokyo – Prelude is available today on ', '\'Ghostwire: Tokyo\' Drops a Visual Novel \'Prelude\' To Set Up the Game', '2022-03-03 15:02:30', NULL, 'In Ghostwire: Tokyo, a mass vanishing whisks away nearly every living being in the once-packed streets of Tokyo. Supernatural beings from myths and folklore take over the city and the lines of reality are blurred. To better understand how Tokyo got this way, let’s rewind the clock and see the city before everything descended into chaos…\r\nEnter Ghostwire: Tokyo – Prelude, a free visual novel adventure available today on PlayStation 4 and PlayStation 5 systems. The story of Prelude focuses on KK, a wisened detective investigating mysterious phenomenon set roughly six months right before the events of Ghostwire: Tokyo. Following a lead on a missing friend, KK and his fellow investigators stumble upon what can only be described as urban legends coming to life…\r\n“By having people experience and enjoy the events that occurred before the events in [Ghostwire: Tokyo] through a different genre made by a different team, it could help open up and widen people’s interpretations of the world and universe we’ve created,” says Game Director Kenji Kimura.\r\n\r\n“There’s a different, kind of more relaxed atmosphere in the visual novel,” says Scenario Writer Takahiro Kaji. “KK is a veteran, accustomed to the situation, working within his realm of expertise and there’s good teamwork with Rinko’s group. By understanding KK a little better through [Ghostwire: Tokyo – Prelude], the player would be able to gain more perspective and see another side to KK’s dialogue in [Ghostwire: Tokyo].”\r\nWith each playthrough, players will discover new elements of the story by building their relationship with KK’s crew, experience a taste of Tokyo’s paranormal side and acquaint themselves with KK’s background before he teams up with Akito to stop a city-wide threat in Ghostwire Tokyo.\r\n\r\nGhostwire: Tokyo – Prelude is available now as a free download for PS4 and PS5 systems via the PlayStation Store. Once you learn how it all begins, keep pursuing the truth and see how it ends when Ghostwire: Tokyo launches March 25 on PS5.', 'IMG-6220d886592679.21432082.jpg'),
(4, 1, NULL, 'Anti Social Social Club x Gran Turismo 7 collaboration drops March 4', 'The Gran Turismo x Anti Social Social Club collection drops on 8am PT on Friday, March 4, 2022, exclusively on AntiSocialSocialClub.com', '2022-03-03 15:04:10', NULL, 'Timed with the launch of the highly-anticipated Gran Turismo 7, streetwear brand Anti Social Social Club has designed a custom vehicle skin for a GT500-spec Toyota Supra. The livery will be available on GT7 and the aesthetics from the design trickle into a capsule collection including a hoodie, T-shirt, snapback hat, gaming socks, and racing gloves. Additionally, a custom Fanatec Gran Turismo DD Pro wheel released for GT7 will be offered as an accessory.\n\nThis is the second time the two brands have worked together. Gran Turismo and Anti Social Social Club collaborated for PSX 2017, showcasing a vehicle livery designed in the game’s Livery Editor feature and an apparel collection. For the release of GT7, the streetwear brand dug deep into Toyota Gazoo Racing’s rich motorsports history and explored an alternate timeline where Anti Social Social Club helmed a Japanese Grand Touring Championship (JGTC) team in the ‘90s, competing in the premier GT500-class of racing. ', 'IMG-6220d8eaf0ef65.73400233.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `post_comment`
--

CREATE TABLE `post_comment` (
  `id` bigint(20) NOT NULL,
  `userID` bigint(20) NOT NULL,
  `postId` bigint(20) NOT NULL,
  `createdAt` datetime NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `post_comment`
--

INSERT INTO `post_comment` (`id`, `userID`, `postId`, `createdAt`, `content`) VALUES
(1, 1, 4, '2022-03-08 22:39:32', 'test123'),
(2, 1, 3, '2022-03-08 23:18:25', 'Free visual novel prequel Ghostwire: Tokyo – Prelude is available today on '),
(3, 1, 3, '2022-03-08 23:41:36', 'In Ghostwire: Tokyo, a mass vanishing whisks away nearly every living being in the once-packed streets of Tokyo. Supernatural beings from myths and folklore take over the city and the lines of reality are blurred. To better understand how Tokyo got this way, let’s rewind the clock and see the city before everything descended into chaos…');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` bigint(20) NOT NULL,
  `firstName` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `middleName` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastName` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `passwordHash` varchar(265) COLLATE utf8mb4_unicode_ci NOT NULL,
  `registeredAt` datetime NOT NULL,
  `lastLogin` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `firstName`, `middleName`, `lastName`, `mobile`, `email`, `passwordHash`, `registeredAt`, `lastLogin`) VALUES
(1, 'David', '', 'Blaine', '0739823983', 'email@gmail.com', '$2y$10$WIcKDT92iRWw4f77w9yzc.R/zOf69tEsAjU8rCwqIwJW/41hgJj26', '2022-03-01 11:28:39', '2022-03-15 13:15:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_post_user` (`authorId`),
  ADD KEY `idx_post_parent` (`parentId`);

--
-- Indexes for table `post_comment`
--
ALTER TABLE `post_comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_comment_post` (`postId`),
  ADD KEY `fk_userID` (`userID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_email` (`email`),
  ADD UNIQUE KEY `uq_mobile` (`mobile`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `post_comment`
--
ALTER TABLE `post_comment`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `fk_post_parent` FOREIGN KEY (`parentId`) REFERENCES `post` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_post_user` FOREIGN KEY (`authorId`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `post_comment`
--
ALTER TABLE `post_comment`
  ADD CONSTRAINT `fk_comment_post` FOREIGN KEY (`postId`) REFERENCES `post` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_userID` FOREIGN KEY (`userID`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
