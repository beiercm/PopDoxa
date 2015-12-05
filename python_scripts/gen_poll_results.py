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

					to_vote = random.randint(0, 2)

					if to_vote == 1:
						output = str(user[0]) + ',' + str(poll[0]) + ','
						
						yes_vote = random.randint(0, 1000)
						no_vote = random.randint(0, 1000)
						u_vote = random.randint(0, 1000)

						total_vote = yes_vote + no_vote + u_vote

						
						vote = random.randint(0, total_vote)
						
						if vote >= 0 and vote < yes_vote:
							output += 'y'							
						elif vote >= yes_vote and vote < no_vote:
							output += 'n'
						else vote >= no_vote and vote < total_vote:
							output += 'u'							

						f_out.write(output + "\n")
