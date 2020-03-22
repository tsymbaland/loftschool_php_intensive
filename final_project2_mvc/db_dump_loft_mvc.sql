create schema if not exists loft_5_7 collate utf8mb4_unicode_ci;

create table if not exists categories
(
	id bigint unsigned auto_increment
		primary key,
	name varchar(100) not null,
	description text not null,
	created_at timestamp null,
	updated_at timestamp null,
	constraint categories_name_unique
		unique (name)
);

create table if not exists products
(
	id bigint unsigned auto_increment
		primary key,
	category_id bigint unsigned not null,
	name varchar(1000) not null,
	price tinyint not null,
	photo text not null,
	description text not null,
	created_at timestamp null,
	updated_at timestamp null,
	constraint products_category_id_foreign
		foreign key (category_id) references categories (id)
);

create table if not exists users
(
	id mediumint unsigned auto_increment
		primary key,
	email tinytext not null,
	password tinytext not null,
	name tinytext null,
	avatar text null,
	age tinyint unsigned null,
	created_at datetime default CURRENT_TIMESTAMP not null,
	updated_at datetime default CURRENT_TIMESTAMP not null
);

create table if not exists files
(
	id int auto_increment
		primary key,
	user_id mediumint unsigned not null,
	name text not null,
	created_at datetime default CURRENT_TIMESTAMP not null,
	updated_at datetime default CURRENT_TIMESTAMP not null,
	constraint `files-of-user`
		foreign key (user_id) references users (id)
);

INSERT INTO loft_5_7.files (id, user_id, name, created_at, updated_at) VALUES (1, 6, '\\images\\b05e1b221e3ce457980e1a43f495ea40\\Снимок.PNG', '2020-03-12 19:01:38', '2020-03-12 19:01:38');
INSERT INTO loft_5_7.files (id, user_id, name, created_at, updated_at) VALUES (2, 6, '\\images\\b05e1b221e3ce457980e1a43f495ea40\\starrynight-2880x1800.jpg', '2020-03-12 20:12:02', '2020-03-12 20:12:02');
INSERT INTO loft_5_7.users (id, email, password, name, avatar, age, created_at, updated_at) VALUES (4, 'a@a.ru', 'd4dd1d9388faffe223af5a9bc9a28372fe4707aa', 'a', null, 22, '2020-03-11 21:16:32', '2020-03-11 21:16:32');
INSERT INTO loft_5_7.users (id, email, password, name, avatar, age, created_at, updated_at) VALUES (5, 'b@b.ru', '89a7f2672a5915348efb2cb0d994ea910fa1536a', 'b', null, 14, '2020-03-11 23:02:38', '2020-03-11 23:02:38');
INSERT INTO loft_5_7.users (id, email, password, name, avatar, age, created_at, updated_at) VALUES (6, 'c@c.ru', '9275293d0ab0569181374da4731793de345be387', 'c', '\\images\\b05e1b221e3ce457980e1a43f495ea40\\IMG_9832_2.jpg', 32, '2020-03-11 23:26:36', '2020-03-11 23:26:36');
INSERT INTO loft_5_7.users (id, email, password, name, avatar, age, created_at, updated_at) VALUES (7, 'z@z.ru', 'd501b43a3a33d0a0cb48034817def1740817962f', 'zzz', '\\images\\c80dba0f3b0436aba4e465e5d0987ade\\wergwgw.PNG', 14, '2020-03-22 14:55:12', '2020-03-22 15:02:49');
