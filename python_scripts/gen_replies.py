import os, random
from get_connection import data_path, connection
import markov as mk

conn = connection()
cursor = conn.cursor()

def start(n):
	mg = mk.MarkovGenerator()
	#email = emails[random.randint(0, len(emails) - 1)]
	with open(data_path + "replies.txt", 'w+') as f_out:
		total_replies = 0

		query = "SELECT id, state, county, city from users"
		cursor.execute(query)
		users = cursor.fetchall()

		query = "SELECT id, state, county, city from posts"
		cursor.execute(query)
		posts = cursor.fetchall()

		while total_replies < n:
			post = posts[random.randint(0, len(posts) - 1)]
			reply_count = 0
			for user in users:
				if user[1] == post[1] or user[2] == post[2] or user[3] == post[3]:

					if random.randint(0, 2) == 1:

						content = mg.generate_sentence(random.randint(2, 5))
						f_out.write(str(user[0]) + "\n")
						f_out.write(str(post[0]) + "\n")
						f_out.write(content + "\n")
						total_replies += 1
						reply_count += 1

						if reply_count == 10:
							break
