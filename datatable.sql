/*
 * create the database 
*/
create database if not exists `parkingfinder`;
use `parkingfinder`;

/*
 * create the users table
*/
create table if not exists `users` (
    `id` int unsigned not null AUTO_INCREMENT,
    `username` varchar(50) not null,
    `password` varchar(255) not null,
    `birthday` date,
    `email` varchar(255),
    constraint unique_username unique (`username`),
    primary key (`id`)
);

/*
 * create the lots table 
*/
create table if not exists `lots` (
    `id` int unsigned not null AUTO_INCREMENT,
    `lotName` varchar(50) not null,
    `lat` float not null,
    `lon` float not null,
    `description` text,
    `cost` int,
    `photo` text,
    constraint unique_lotname unique (`lotName`),
    primary key (`id`)
);

/*
 * create the reviews table 
*/
create table if not exists `reviews` (
    `id` int unsigned not null AUTO_INCREMENT,
    `lot_id` int unsigned not null,
    `user_id` int unsigned not null,
    `user` varchar(255) not null,
    `rating` int not null,
    `review` text,
    primary key (`id`) -- ,
    -- foreign key (`lot_id`) references `lots` (`id`) on delete cascade,
    -- foreign key (`user_id`) references `users` (`id`) on delete cascade
);
