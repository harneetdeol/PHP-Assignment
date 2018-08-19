CREATE TABLE `appointment` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `starttime` datetime NOT NULL,
  `endtime` datetime NOT NULL
);

INSERT INTO `appointment` (`firstname`, `lastname`, `email`, `phone`, `address`,`reason`,`starttime`,`endtime`) VALUES
('alice', 'stewart', 'astewart@gmail.com', '16041234567', '12345 abc Ave Surrey BC Canada','throat infection', '2018-08-30 10:00:00','2018-08-30 10:30:00'),
('bob', 'martin', 'bob_martin123@gmail.com', '160412347788', '12345 81a Ave Abbotsford BC Canada', 'diabetics issues', '2018-08-23 14:00:00', '2018-08-23 14:30:00'),
('catherine', 'chow', 'chow.catherine@gmail.com', '16041239090', '17856 78 Ave Langley BC Canada', 'thyroid issues','2018-08-31 11:00:00', '2018-08-31 11:30:00'),
('david', 'proctor', 'davidproctor87@gmail.com', '16041230987', '13606 saanich street Langley BC Canada', 'skin infection','2018-08-22 12:00:00', '2018-08-31 12:30:00');

