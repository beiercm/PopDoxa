import os, random
import get_connection as gc
import markov as mk

conn = gc.connection()
cursor = conn.cursor()

def start(n):
	#email = emails[random.randint(0, len(emails) - 1)]
	with open("replies.txt", 'w+') as f_out:
		reply_count = 0

		query = "SELECT id, state, county, city from users"
		cursor.execute(query)
		users = cursor.fetchall()

		query = "SELECT id, state, county, city from posts"
		cursor.execute(query)
		posts = cursor.fetchall()

		while reply_count < n:
			post = posts[random.randint(0, len(posts) - 1)]

			for user in users:
				if user[1] == post[1] or user[2] == post[2] or user[3] == post[3]:

					content = mk.generate_sentence(random.randint(2, 5))
					f_out.write(user[0])
					f_out.write(post_id[0])
					f_out.write(content)

start(100)