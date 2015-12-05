import os, random
from get_connection import data_path, connection

conn = connection()
cursor = conn.cursor()

def get_users():
	query = """
	SELECT id, state, county, city from users;
	"""

	cursor.execute(query)
	users = cursor.fetchall()

	return users

def get_polls():
	query = """
	SELECT id, state, county, city from polls;
	"""

	cursor.execute(query)
	polls = cursor.fetchall()

	return polls

def start():

	users = get_users()
	polls = get_polls()

	with open(data_path + "poll_results.txt", 'w+') as f_out:
		for user in users:
			for poll in polls:
				if user[1] == poll[1] or user[2] == poll[2] or user[3] == poll[3]:
					to_vote = random.randint(0, 3)

					if to_vote > 0:
						output = str(user[0]) + ',' + str(poll[0]) + ','
						vote = random.randint(0, 2)

						if vote == 1:
							output += 'y'
						elif vote == 2:
							output += 'u'
						else:
							output += 'n'

						f_out.write(output + "\n")