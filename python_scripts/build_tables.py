import read_files as rf

tables = {
		'users' :	"""
					create table if not exists users (
					id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
					first VARCHAR (30) NOT NULL,
					last VARCHAR (30) NOT NULL,
					username VARCHAR (30) NOT NULL,
					age INT (3) NOT NULL,
					email VARCHAR (30) NOT NULL,
					gender CHAR (1) NOT NULL,
					state VARCHAR (20) NOT NULL,
					county VARCHAR (30) NOT NULL,
					city VARCHAR (30) NOT NULL
					)
					""",
		'votes' : 	"""
					create table if not exists votes (
					id INT (6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
					poll_id INT (6) UNSIGNED NOT NULL,
					user_id INT (6) UNSIGNED NOT NULL,
					vote CHAR (1) NOT NULL
					)
					""",
		'polls' :	"""
					create table if not exists polls (
					id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
					question VARCHAR (200) NOT NULL,
					yes INT (5),
					no INT (5),
					neutral INT (5)
					)
					""",
		'states':	"""
					create table if not exists states (
					id INT(2) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
					name VARCHAR(25) NOT NULL,
					url VARCHAR (100) NOT NULL
					)
					""",
		'counties' :"""
					create table if not exists counties (
					id INT(3) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
					name VARCHAR(40) NOT NULL,
					state_id INT (2) NOT NULL
					)
					""",
		'cities' :	"""
					create table if not exists cities (
					id INT(3) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
					name VARCHAR (40) NOT NULL,
					county_id INT(3) NOT NULL
					)
					""",
		'clubs' :	"""
					create table if not exists clubs (
					id INT(3) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
					user_id INT(6) NOT NULL,
					nra CHAR (1) DEFAULT 'N',
					green_energy CHAR (1) DEFAULT 'N',
					aca CHAR (1) DEFAULT 'N',
					common_core CHAR (1) DEFAULT 'N'
					)
					""",
		'news':		"""
					create table if not exists news (
					id INT(3) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
					title VARCHAR (100) NOT NULL,
					url VARCHAR (200) NOT NULL,
					descrip VARCHAR (1000) DEFAULT "",
					img_url VARCHAR (200) NOT NULL
					)
					""",
		'posts' :	"""
					create table if not exists posts (
					id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
					author INT (6) NOT NULL,
					title VARCHAR (200) NOT NULL,
					content VARCHAR (1000) NOT NULL,
					views INT (6) NOT NULL DEFAULT 0,
					replies INT (6) NOT NULL DEFAULT 0,
					ts TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
					last_post TIMESTAMP,
					state INT(2) NOT NULL,
					county INT(3) NOT NULL DEFAULT -1,
					city INT (5) NOT NULL DEFAULT -1,
					url VARCHAR (50) NOT NULL
					)
					""",
		'replies' : """
					create table if not exists replies (
					id INT (6) AUTO_INCREMENT PRIMARY KEY,
					author VARCHAR(20) NOT NULL,
					ts TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
					state_id INT(2) NOT NULL,
					county_id INT(5) NOT NULL,
					city_id INT(10) NOT NULL,
					url VARCHAR (50) NOT NULL
					)
					"""
}


def build_tables(table_list, cursor):
	for table in table_list:
		print("Building " + table + " table...")
		cursor.execute(tables[table])
		method = getattr(rf, 'read_' + table)(cursor)

def build_all(cursor):
	for table in tables:
		print("Building " + table + " table...")
		cursor.execute(tables[table])
		if table != 'states' and table != 'counties' and table != 'cities':
			method = getattr(rf, 'read_' + table)(cursor)

	rf.read_states(cursor)
	rf.read_counties(cursor)
	rf.read_cities(cursor)
		