import os, random
from get_connection import data_path, connection
import markov as mk

conn = connection()
cursor = conn.cursor()

def start(n):
	mg = mk.MarkovGenerator()
	#email = emails[random.randint(0, len(emails) - 1)]
	with open(data_path + "poll_replies.txt", 'w+') as f_out:
		total_replies = 0

		query = "SELECT id, state, county, city from users"
		cursor.execute(query)
		users = cursor.fetchall()

		query = "SELECT id, state, county, city from polls"
		cursor.execute(query)
		polls = cursor.fetchall()

		while total_replies < n:
			poll = polls[random.randint(0, len(polls) - 1)]
			reply_count = 0
			for user in users:
				if user[1] == poll[1] or user[2] == poll[2] or user[3] == poll[3]:

					if random.randint(0, 2) == 1:

						content = mg.generate_sentence(random.randint(2, 5))
						f_out.write(str(user[0]) + "\n")
						f_out.write(str(poll[0]) + "\n")
						f_out.write(content + "\n")
						total_replies += 1
						reply_count += 1

						if reply_count == 10:
							break
