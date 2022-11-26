CREATE TABLE cities (
	id SERIAL PRIMARY KEY,
	name VARCHAR NOT NULL
);

CREATE TABLE users (
	id SERIAL PRIMARY KEY,
	city_id INT NOT NULL,
	name VARCHAR NOT NULL,
	email VARCHAR NOT NULL,
	password VARCHAR NOT NULL,
	age INT NOT NULL,
	sex INT NOT NULL,
	telephone INT NOT NULL,
	FOREIGN KEY (city_id) REFERENCES cities(id)	
);

CREATE TABLE hobbies (
	id SERIAL PRIMARY KEY,
	user_id INT NOT NULL,
	name VARCHAR NOT NULL,
	FOREIGN KEY (user_id) REFERENCES users(id)
);

INSERT INTO cities(name) VALUES
('Rio do Sul'),
('Videira'),
('Blumenau'),
('Aurora'),
('Rio do Oeste'),
('Ituporanga'),
('Laurentino');