import os, random, mysql.connector
from mysql.connector import errorcode
import markov as mk

def normalize_unicode(lists):
	new_list = []
	for some_list in lists:
		some_list = [s.encode('ascii', 'ignore') for s in some_list]
		new_list.append(some_list)

	return new_list

def gen_locations(level, state):
	login_info = [e.strip() for e in list(open("login.txt"))]
	cnx = mysql.connector.connect(user=login_info[1], password=login_info[2], database = login_info[3])
	cursor = cnx.cursor()

	# query = "select states.name from states;"

	# cursor.execute(query)
	# states = normalize_unicode(cursor.fetchall())
	# print(states)
	if level == "COUNTY":
		query = """
				select states.id,counties.id
				from states
				join counties
				on states.id = counties.state_id
				where states.id = %s;
				"""
		cursor.execute(query, (state,))

	elif level == "CITY":
		query = """
				select states.id,counties.id,cities.id
				from states
				join counties
				on states.id = counties.state_id
				join cities
				on counties.id = cities.county_id
				where states.name = 'florida';
				"""
		cursor.execute(query)	

	locations = cursor.fetchall()

	return locations

def gen_post():
	#email = emails[random.randint(0, len(emails) - 1)]
	n = 1000
	COUNTY = False
	CITY = False

	for i in range(n):
		if i > (n/3): 
			COUNTY = True
		if i > (2* n / 3):
			CITY = True

		user_id = random.randint(0, 1000)

		title = mk.generate_sentence(1)

		content = mk.generate_sentence(random.randint(2, 5))

		state = random.randint(1, 51)

		if CITY:
			loc = gen_locations("CITY", state)
			loc = loc[random.randint(0, len(loc)-1)]
			state = -1
			county = -1
			city = loc[2]

		elif COUNTY:
			loc = gen_locations("COUNTY", state)
			loc = loc[random.randint(0, len(loc) - 1)]
			state = -1
			county = loc[1]
			city = -1

		else:
			state = 9
			county = -1
			city = -1




		print(user_id)
		print(title)
		print(content)
		print(state)
		print(county)
		print(city)

def main():
	#gen_post(get_emails())
	gen_post()
	
main()