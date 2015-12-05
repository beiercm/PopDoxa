import os, random
import get_connection as gc
import markov as mk

conn = gc.connection()
cursor = conn.cursor()

def start(n):
	#email = emails[random.randint(0, len(emails) - 1)]

	mg = mk.MarkovGenerator()

	query = "SELECT id, state, county, city from users"
	cursor.execute(query)
	users = cursor.fetchall()

	for i in range(n):
		state = -1
		county = -1
		city = -1

		user = users[random.randint(0, len(users) - 1)]

		title = mg.generate_sentence(1)

		content = mg.generate_sentence(random.randint(2, 5))

		location = random.randint(1, 4)

		if location == 1:
			state = user[1]
		if location == 2:
			county = user[2]
		if location == 3:
			city = user[3]


		print(user_id)
		print(title)
		print(content)
		print(state)
		print(county)
		print(city)

start(1000)