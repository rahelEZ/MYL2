/* Rahel Zewde + Habib Kaviani
 * Rahel.zewde@stonybrook.edu
 * habbibudin.ahmadi@stonybrook.edu
 * 111250334
 */
DROP DATABASE IF EXISTS MYL2;

CREATE DATABASE MYL2;

GRANT ALL PRIVILEGES ON database.MYL2.* to root identified by '';

USE MYL2;


CREATE TABLE `contributors` (
  `id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` varchar(10) NOT NULL
) ;



CREATE TABLE `languages` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `words_count` int(11) NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `name` varchar(255) NOT NULL,
  `rank` varchar(2) DEFAULT 'F'
) ;


CREATE TABLE `language_grade_rules` (
  `id` int(11) NOT NULL,
  `words_count` int(11) NOT NULL,
  `grade` varchar(2) NOT NULL
) ;

INSERT INTO `language_grade_rules` (`id`, `words_count`, `grade`) VALUES
(1, 5, 'D-'),
(2, 10, 'D'),
(3, 15, 'D+'),
(4, 20, 'C-'),
(5, 25, 'C'),
(6, 30, 'C+'),
(7, 40, 'B-'),
(8, 55, 'B'),
(9, 70, 'A-'),
(10, 85, 'A'),
(11, 100, 'A+'),
(12, 0, 'F');


CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ;


CREATE TABLE `words` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `word` varchar(255) NOT NULL,
  `translation` varchar(255) NOT NULL
) ;

ALTER TABLE `contributors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `language_id` (`language_id`),
  ADD KEY `user_id` (`user_id`);

ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`),
  ADD KEY `languages_ibfk_1` (`user_id`);

ALTER TABLE `language_grade_rules`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

ALTER TABLE `words`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `lang_id` (`language_id`);

ALTER TABLE `contributors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

ALTER TABLE `languages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
ALTER TABLE `language_grade_rules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

ALTER TABLE `words`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

ALTER TABLE `contributors`
  ADD CONSTRAINT `contributors_ibfk_1` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `contributors_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;


ALTER TABLE `languages`
  ADD CONSTRAINT `languages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `words`
  ADD CONSTRAINT `words_ibfk_1` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `words_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
