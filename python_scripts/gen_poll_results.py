import os, random, mysql.connector
from mysql.connector import errorcode

def get_users():
	login_info = [e.strip() for e in list(open("/home/christopher/login.txt"))]
	cnx = mysql.connector.connect(user=login_info[1], password=login_info[2], database = login_info[3])
	cursor = cnx.cursor()

	query = """
	SELECT id, state, county, city from users;
	"""

	cursor.execute(query)
	users = cursor.fetchall()

	return users

def get_polls():
	login_info = [e.strip() for e in list(open("/home/christopher/login.txt"))]
	cnx = mysql.connector.connect(user=login_info[1], password=login_info[2], database = login_info[3])
	cursor = cnx.cursor()

	query = """
	SELECT id, state, county, city from polls;
	"""

	cursor.execute(query)
	polls = cursor.fetchall()

	return polls

def gen_poll_results(users, polls):
	for user in users:
		for poll in polls:
			if user[1] == poll[1] or user[2] == poll[2] or user[3] == poll[3]:
				to_vote = random.randint(0, 1)

				if to_vote == 1:
					output = str(user[0]) + ',' + str(poll[0]) + ','
					vote = random.randint(0, 2)

					if vote == 1:
						output += 'y'
					elif vote == 2:
						output += 'n'
					else:
						output += 'u'

					print output
					


	# for i in range(1, 1001):

	# 	for j in range(1, 4):
	# 		output = str(i) + ',' + str(j) + ','

	# 		c = random.randint(0, 3)

	# 		if c == 1:
	# 			output += 'y'
	# 		elif c == 2:
	# 			output += 'n'
	# 		else:
	# 			output += 'u'

	# 		#print(output)

def main():
	os.chdir("/home/christopher/popdoxa/PopDoxa/data")
	users = get_users()
	polls = get_polls()
	gen_poll_results(users, polls)

main()