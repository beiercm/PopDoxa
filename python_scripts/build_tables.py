import read_files as rf

tables = {
		'users' :	"""
					create table if not exists users (
					id INT(6) AUTO_INCREMENT PRIMARY KEY,
					first VARCHAR (30) NOT NULL,
					last VARCHAR (30) NOT NULL,
					username VARCHAR (30) NOT NULL,
					password VARCHAR (100) NOT NULL,
					age INT (3) NOT NULL,
					email VARCHAR (30) NOT NULL,
					gender CHAR (1) NOT NULL,
					state INT (2) NOT NULL,
					county INT (5) NOT NULL,
					city INT (6) NOT NULL,
					last_checked TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
					image VARCHAR (200)
					)
					""",
		'polls' :	"""
					create table if not exists polls (
					id INT(6) AUTO_INCREMENT PRIMARY KEY,
					author INT(6) NOT NULL,
					question VARCHAR (200) NOT NULL,
					votes INT(6) NOT NULL DEFAULT 0,
					views INT (6) NOT NULL DEFAULT 0,
					replies INT (6) NOT NULL DEFAULT 0,
					state INT (2) NOT NULL,
					county INT (5) NOT NULL DEFAULT -1,
					city INT (6) NOT NULL DEFAULT -1,
					ts TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
					last_poll TIMESTAMP,
					post INT(6) NOT NULL,
					approved INT(1) DEFAULT 0
					)
					""",
		'poll_results': """
						create table if not exists poll_results (
						id INT (6) AUTO_INCREMENT PRIMARY KEY,
						poll_id INT (6) NOT NULL,
						user_id INT (6) NOT NULL,
						vote CHAR (1) NOT NULL
						)
					""",
		'poll_replies' : """
					create table if not exists poll_replies (
					id INT (6) AUTO_INCREMENT PRIMARY KEY,
					author INT(6) NOT NULL,
					poll_id INT (6) NOT NULL,
					content VARCHAR(1000) NOT NULL,
					ts TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
					opinion char(1) NOT NULL DEFAULT 'u'
					)
					""",
		'states':	"""
					create table if not exists states (
					id INT(2) AUTO_INCREMENT PRIMARY KEY,
					name VARCHAR(25) NOT NULL,
					url VARCHAR (100) NOT NULL
					)
					""",
		'counties' :"""
					create table if not exists counties (
					id INT(3) AUTO_INCREMENT PRIMARY KEY,
					name VARCHAR(40) NOT NULL,
					state_id INT (2) NOT NULL
					)
					""",
		'cities' :	"""
					create table if not exists cities (
					id INT(3) AUTO_INCREMENT PRIMARY KEY,
					name VARCHAR (40) NOT NULL,
					county_id INT(3) NOT NULL
					)
					""",
		'opinions' :	"""
					create table if not exists opinions (
					id INT(3) AUTO_INCREMENT PRIMARY KEY,
					opin_name VARCHAR (30) NOT NULL,
					opin_descrip VARCHAR (200) NOT NULL,
					abbbr VARCHAR (4) NOT NULL
					)
					""",
		'user_opin': 	"""
					create table if not exists user_opin (
					id INT(6) AUTO_INCREMENT PRIMARY KEY,				
					user_id INT (6) NOT NULL,
					opin_id INT (3) NOT NULL,
					opinion VARCHAR (1) DEFAULT 'u'
					)
					""",
		'news':		"""
					create table if not exists news (
					id INT(3) AUTO_INCREMENT PRIMARY KEY,
					title VARCHAR (100) NOT NULL,
					url VARCHAR (200) NOT NULL,
					descrip VARCHAR (1000),
					img_url VARCHAR (200) NOT NULL
					)
					""",
		'posts' :	"""
					create table if not exists posts (
					id INT(6) AUTO_INCREMENT PRIMARY KEY,
					author INT (6) NOT NULL,
					title VARCHAR (200) NOT NULL,
					content VARCHAR (1000) NOT NULL,
					views INT (6) NOT NULL DEFAULT 0,
					replies INT (6) NOT NULL DEFAULT 0,
					points INT (6) NOT NULL DEFAULT 0,
					ts TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
					last_post TIMESTAMP,
					state INT(2) NOT NULL,
					county INT(3) NOT NULL DEFAULT -1,
					city INT (5) NOT NULL DEFAULT -1,
					url VARCHAR (50) NOT NULL,
					poll INT(3) NOT NULL DEFAULT -1
					)
					""",
		'replies' : """
					create table if not exists replies (
					id INT (6) AUTO_INCREMENT PRIMARY KEY,
					author INT(6) NOT NULL,
					post_id INT (6) NOT NULL,
					content VARCHAR(1000) NOT NULL,
					ts TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
					opinion char(1) NOT NULL DEFAULT 'u'
					)
					""",
		'user_roles':	"""
					create table if not exists user_roles (
						id INT (6) AUTO_INCREMENT PRIMARY KEY,
						user_id INT (6) NOT NULL,
						access_level VARCHAR (20) NOT NULL
						)
					""",
		'feedback': """
					create table if not exists feedback (
						id INT (6) AUTO_INCREMENT PRIMARY KEY,
						user_id INT (6) NOT NULL,
						content VARCHAR (2000) NOT NULL,
						ts TIMESTAMP DEFAULT CURRENT_TIMESTAMP
						)
					"""
}

def build_all(cursor):
	#for tables that either can't be built or need a specific order
	do_not_build = ['poll_replies', 'counties', 'cities', 'build', 'replies']
	for table in tables:
		print("Building " + table + " table...")
		cursor.execute(tables[table])
		if table not in do_not_build:
			method = getattr(rf, 'read_' + table)(cursor)

	rf.read_poll_replies(cursor)
	rf.read_replies(cursor)
	rf.read_counties(cursor)
	rf.read_cities(cursor)
