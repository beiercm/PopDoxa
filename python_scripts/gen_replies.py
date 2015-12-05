import os, random
import get_connection as gc
import markov as mk

conn = gc.connection()
cursor = conn.cursor()

def start(n):
	#email = emails[random.randint(0, len(emails) - 1)]

	reply_count = 0

	query = "SELECT id, state, county, city from users"
	cursor.execute(query)
	users = cursor.fetchall()

	print users

	query = "SELECT id, state, county, city from posts"
	cursor.execute(query)
	posts = cursor.fetchall()

	print posts

	while reply_count < n:
		post = posts[random.randint(0, len(posts) - 1)]

		for user in users:
			#if user[1] == post[1] or user[2] == post[2] or user[3] == post[3]:
			if user[2] == post[2]:
				print user, post
				break

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