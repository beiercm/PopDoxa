import os, random
from get_connection import data_path

def get_users(cursor):
	query = """
	SELECT id, state, county, city from users;
	"""

	cursor.execute(query)
	users = cursor.fetchall()

	return users

def get_polls(cursor):
	query = """
	SELECT id, state, county, city from polls;
	"""

	cursor.execute(query)
	polls = cursor.fetchall()

	return polls

def start(conn):

	cursor = conn.cursor()
	users = get_users(cursor)
	polls = get_polls(cursor)

	with open(data_path + "poll_results.txt", 'w+') as f_out:
		for user in users:
			for poll in polls:
				if user[1] == poll[1] or user[2] == poll[2] or user[3] == poll[3]:

					to_vote = random.randint(0, 10)

					if to_vote > 4:
						output = str(user[0]) + ',' + str(poll[0]) + ','
						

						while True:
							vote = random.randint(0, 1000)
							
							if vote >= 0 and vote <= 432:
								output += 'y'
								break
							elif vote >= 433 and vote <= 698:
								output += 'u'
								break
							elif vote >= 699 and vote <= 912:
								output += 'n'
								break

						f_out.write(output + "\n")
