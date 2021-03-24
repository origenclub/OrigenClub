
CREATE TABLE `members` (
  `memberID` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `active` varchar(255) NOT NULL,
  `resetToken` varchar(255) DEFAULT NULL,
  `resetComplete` varchar(3) DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabla Miembros' ROW_FORMAT=COMPACT;


ALTER TABLE `members`
  ADD PRIMARY KEY (`memberID`);


ALTER TABLE `members`
  MODIFY `memberID` int(11) NOT NULL AUTO_INCREMENT;