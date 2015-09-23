def read_users(cursor):
	print("Reading in users.txt")
	users_file = list(open("users.txt"))

	for user_list in users_file:
		user = [x.strip().lower() for x in user_list.split(',')]
		username = user[0] + "_" + user[1]
		password = "userbot"
		user.insert(2, username)
		user.insert(3, password)
		query = 	"""
					INSERT INTO users 
					(first, last, username, password, gender, age, email, state, county, city)
					VALUES 
					(%s,%s,%s,%s, %s, %s,%s,%s,%s,%s);
					"""
		cursor.execute(query, user)


def read_votes(cursor):
	pass

def read_opinions(cursor):
	print("Reading in opinions.txt")
	opin_file = list(open("opinions.txt"))

	for opinion in opin_file:
		opinion = opinion.split(',')
		opinion[1] = opinion[1].strip()

		query = 	"""
					INSERT INTO opinions
					(opin_name,opin_descrip) 
					values (%s,%s);
					"""

		cursor.execute(query, opinion)

def read_user_opin(cursor):
	pass	 
	
def read_polls(cursor):
	print("Reading in polls.txt")
	polls = list(open("polls.txt"))

	for poll in polls:
		poll = poll.split(',')
		poll[1] = poll[1].strip()

		query =		"""
					INSERT INTO polls
					(author, question)
					VALUES
					(%s,%s);
					"""
		cursor.execute(query,poll)

def read_poll_results(cursor):
	pass


def read_states(cursor):
	print("Reading in states.txt...")
	states = list(open("states.txt"))

	url = "http://10.171.204.135/?forum=forum/"

	for state in states:
		state = state.strip().lower()
		query = "INSERT INTO states (name) VALUES (%s);"
		#query = "INSERT INTO states (name, url) VALUES (%s,%s);"
		#data = (state, url + state)
		data = (state,)
		cursor.execute(query, data)

def read_counties(cursor):
	print("Reading in counties.txt...")
	counties_file = list(open("counties.txt"))

	for county_list in counties_file:
		county_list = county_list.split(',')
		state = county_list[0].strip().lower()

		query = ("SELECT id FROM states where name= %s;")
		cursor.execute(query, (state,))
		state_id = cursor.fetchall()[0][0]

		for county in county_list[1::]:
			county = county.strip().lower()
			query = "INSERT INTO counties (name, state_id) VALUES (%s, %s);"
			cursor.execute(query, (county, state_id))

def read_cities(cursor):
	print("Reading in cities.txt...")
	cities_file = list(open("cities.txt"))

	for city_list in cities_file:
		city_list = city_list.split(',')
		state = city_list[0].strip().lower()
		county = city_list[1].strip().lower()

		query = 	"""
					select counties.id,counties.name
					from counties
					join states
					on states.id = counties.state_id
					where states.name = %s
					and counties.name = %s;
					"""
		cursor.execute(query, (state,county,))
		county_id = cursor.fetchall()[0][0]

		for city in city_list[1::]:
			city = city.strip().lower()
			query = "INSERT INTO cities (name, county_id) VALUES (%s, %s);"
			cursor.execute(query, (city, county_id))

def read_clubs(cursor):
	print("Reading in clubs.txt...")
	clubs_file = list(open("clubs.txt"))

	for clubs_list in clubs_file:
		clubs_list = clubs_list.split(',')
		query = "INSERT INTO clubs (user_id, nra, green_energy, aca, common_core) VALUES (%s,%s,%s,%s,%s);"
		cursor.execute(query, clubs_list)

def read_recent_news(cursor):
	pass

def read_posts(cursor):
	print("Reading in posts.txt")
	posts = list(open("posts.txt"))

	n = 6

	for i in range((len(posts) / n)):
		author = posts[(i * n) + 0]
		title = posts[(i * n) + 1].strip()
		content = posts[(i * n) + 2].strip()
		state = posts[(i * n) + 3]
		county = posts[(i * n) + 4]
		city = posts[(i * n) + 5]

		query = "INSERT INTO posts (author, title, content, state, county, city) VALUES (%s,%s,%s,%s,%s,%s);"
		cursor.execute(query, (author,title,content,state,county,city))

def read_replies(cursor):
	pass

def read_news(cursor):
	pass