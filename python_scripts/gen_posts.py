import os, random
from get_connection import data_path
import markov as mk


def start(conn, n):
	#email = emails[random.randint(0, len(emails) - 1)]
	cursor = conn.cursor()

	mg = mk.MarkovGenerator()
	with open(data_path + "posts.txt", 'w+') as f_out:
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


			f_out.write(str(user[0]) + "\n")
			f_out.write(title + "\n")
			f_out.write(content + "\n")
			f_out.write(str(state) + "\n")
			f_out.write(str(county) + "\n")
			f_out.write(str(city) + "\n")