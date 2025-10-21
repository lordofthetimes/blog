-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 21 Paź 2025, 12:13
-- Wersja serwera: 10.4.27-MariaDB
-- Wersja PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `blog`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `title` text DEFAULT NULL,
  `article` text DEFAULT NULL,
  `ownerID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `articles`
--

INSERT INTO `articles` (`id`, `title`, `article`, `ownerID`) VALUES
(1, 'This is a test article', 'I hope this works fine', 1),
(3, 'Lorem ipsum - 765 words', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer eleifend velit purus, quis scelerisque mi porta sed. Fusce posuere quam in arcu interdum ornare. Nulla varius quam elit, sed suscipit odio consequat vitae. Proin sed lacinia erat. Donec eleifend nibh a tellus posuere, sed tristique diam semper. Ut lorem nisl, varius vel nibh vitae, varius elementum ante. Vestibulum mi eros, tristique at tortor quis, molestie lacinia tellus. Integer sit amet sem quis libero pulvinar molestie et at felis. Vivamus erat purus, condimentum et urna vel, suscipit iaculis nisl. Nulla bibendum ultricies orci, id convallis lorem fringilla eget. Morbi in blandit nulla, vel gravida metus. Nunc quis lectus turpis. Nunc consequat est a gravida pulvinar. Aenean posuere tellus eget velit commodo hendrerit.\r\n\r\nNunc consectetur, neque sed scelerisque semper, nibh sapien mattis arcu, non consequat magna sapien et urna. Quisque non nisi condimentum, interdum ipsum ut, interdum ipsum. Interdum et malesuada fames ac ante ipsum primis in faucibus. Aliquam erat volutpat. Proin varius mi vel nulla facilisis, a cursus leo aliquam. Morbi ut fermentum dui. Sed volutpat augue velit, at vehicula purus vehicula vel. Donec maximus tempor neque in lacinia. Integer in auctor nulla. Pellentesque a ultricies ipsum, et efficitur ipsum.\r\n\r\nMaecenas quam justo, aliquet id mollis sed, sollicitudin quis dui. Cras euismod gravida convallis. Fusce ut fermentum lectus. Cras eu mattis arcu, quis mattis lacus. Donec accumsan faucibus nunc, id condimentum urna iaculis eu. Proin massa velit, porttitor vel tortor at, cursus tempus sem. Phasellus et purus sem. Integer dapibus ornare nibh, et egestas arcu tristique vehicula. Integer quam velit, tempor ac ultricies consequat, maximus vel quam. Etiam ullamcorper aliquam dolor at aliquam. Donec mollis sapien eget diam mollis, non malesuada lacus consectetur. Sed aliquam enim vel nisl malesuada consectetur. Cras tempor consequat massa nec tincidunt. Sed quis sem sit amet nibh consectetur posuere eu eget turpis. Suspendisse sem orci, pellentesque ac faucibus ac, porttitor ac purus. Donec vehicula arcu quis orci suscipit pellentesque.\r\n\r\nVivamus iaculis euismod posuere. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. In consequat convallis purus sed pulvinar. Proin nisl lectus, efficitur quis imperdiet a, bibendum ac est. Duis lacinia eros sed ullamcorper dapibus. Fusce non eros orci. Integer dictum posuere metus eget lacinia. Nam porta dolor rhoncus, congue diam nec, vulputate ligula. Aenean dictum commodo congue. Donec venenatis porttitor hendrerit. Nunc facilisis erat eget tortor mollis, eget commodo orci efficitur. Nam tincidunt fermentum mattis. In at sem at leo viverra interdum eu ac odio.\r\n\r\nPraesent malesuada et quam id fermentum. Morbi tincidunt, turpis vel eleifend aliquam, elit leo facilisis tortor, sit amet tempus purus lacus id eros. Maecenas ut ex nec arcu scelerisque ornare. Nulla dui odio, gravida vel aliquam eleifend, elementum vel urna. Phasellus mollis enim felis, nec fringilla quam elementum sed. Nam dictum urna neque, eget porttitor purus fringilla id. Phasellus diam turpis, hendrerit vel lorem at, scelerisque varius erat. Suspendisse porta, orci eu mollis pulvinar, nisl lacus vulputate lorem, et tristique metus eros non massa. Proin porttitor erat enim, ut sodales nisi mattis quis. Ut tempus neque tellus, in vestibulum diam tristique a.\r\n\r\nVestibulum at porta tellus. Duis ornare nisl sit amet ligula interdum efficitur. Nulla et gravida quam. Donec volutpat gravida scelerisque. Nullam ut congue mauris, ut aliquet odio. Curabitur orci odio, rhoncus eu tempus vitae, maximus sit amet dolor. Pellentesque volutpat gravida metus luctus tincidunt. Mauris laoreet convallis dolor, at suscipit dolor rhoncus nec.\r\n\r\nDonec eget lorem eget nulla sollicitudin gravida. Proin accumsan a massa venenatis venenatis. Mauris facilisis libero augue, vel luctus libero egestas a. Aenean vulputate risus quis rhoncus aliquam. Phasellus quis tellus arcu. Morbi ante tellus, cursus nec orci sed, tristique interdum felis. Aliquam aliquet facilisis odio eget sodales.\r\n\r\nAenean ut erat vitae justo tempor imperdiet. Duis mattis odio sit amet porttitor condimentum. Praesent in lobortis justo. Mauris fermentum urna ullamcorper sollicitudin semper. Donec erat ex, finibus eu suscipit eget, ultricies ac ex. Maecenas in eros ac mauris pellentesque dignissim. Proin vel nisl vitae leo efficitur pellentesque accumsan in enim. Cras orci velit, feugiat a ligula quis, pulvinar laoreet ex. Aliquam tempus, neque at tincidunt porttitor, ante augue vulputate eros, vitae consequat quam tellus id massa. Ut feugiat, nisl quis sollicitudin sagittis, nisl lectus consectetur neque, eget ultrices mauris risus ac felis. Nam eget libero eget orci commodo accumsan sit amet laoreet ex. Nunc dolor orci, placerat ut faucibus vitae, blandit ac ex. Donec non convallis orci. Aenean molestie id odio vel ornare.\r\n\r\nUt vitae hendrerit libero. Proin luctus mauris vel justo bibendum tempus. Vivamus eleifend et ante non volutpat. Sed lobortis velit nunc, eget convallis nunc consectetur vitae.', 1),
(8, 'nie dlugie slowo artykul test dlugi tytul', 'tytul tutaj', 1),
(9, 'To jest piekny artykul', 'Nowy piekny artykul zwyklego uzytkownika', 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` text DEFAULT NULL,
  `password` text DEFAULT NULL,
  `role` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `role`) VALUES
(1, 'superadmin', 'superPass!@#$%', 'superadmin'),
(2, 'user1', 'password', 'user'),
(3, 'user2', 'password', 'user');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ownerID` (`ownerID`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`ownerID`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
