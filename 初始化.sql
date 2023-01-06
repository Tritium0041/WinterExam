create table `user` (`number_id` INT auto_increment not null primary key,`username_base64` varchar(100) not null,`pwd_sha256` char(64) not null);
create table `file` (`number_id` INT auto_increment not null primary key,`hash_sha256` char(64) not null,`path` varchar(100) not null,`count` int not null);
