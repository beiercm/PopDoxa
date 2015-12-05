import os, random
import get_connection as gc
import markov as mk

conn = gc.connection()
cursor = conn.cursor()

def start(n):
	#email = emails[random.randint(0, len(emails) - 1)]

	query = "SELECT id, state, county, city from users"
	cursor.execute(query)
	users = cursor.fetchall()

	print users

	# for i in range(n):
	# 	post_id = random.randint(0, 1000)

	# 	query = "SELECT state, county, city from posts where id = " + str(post_id)
	# 	cursor.execute(query)

	# 	results = cursor.fetchall()

	# 	print results

		# user_id = random.randint(0, 1000)



		# content = mk.generate_sentence(random.randint(2, 5))

		# print(user_id)
		# print(post_id)
		# print(content)

start(100)