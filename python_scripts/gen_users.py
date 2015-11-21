import os, random, mysql.connector
from mysql.connector import errorcode

def get_names(files):
	names = []
	for fin in files:
		fin = list(open(fin))
		fin = fin[0].split(',')
		names.append(fin)

	return names

def gen_locations():

	login_info = [e.strip() for e in list(open("/home/christopher/login.txt"))]
	cnx = mysql.connector.connect(user=login_info[1], password=login_info[2], database = login_info[3])
	cursor = cnx.cursor()

	# query = "select states.name from states;"

	# cursor.execute(query)
	# states = normalize_unicode(cursor.fetchall())
	# print(states)
	query = 	"""
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

def gen_user(names, locations, n):
	users = []
	for i in range(n):
		user = ""
		if random.randint(0,1):
			gender = 'm'
			index = random.randint(0,len(names[1]) - 1)
			first = names[1][index].lower()
		else:
			gender = 'f'
			index = random.randint(0,len(names[2]) - 1)
			first = names[2][index].lower()

		index = random.randint(0,len(names[0]) - 1)
		last = names[0][index].lower()

		age = random.randint(18, 100)

		email = first + last + "@botmail.com"
		state = "florida"

		location = locations[random.randint(0, len(locations) - 1)]

		state = location[0]
		county = location[1]
		city = location[2]

		user = "{},{},{},{},{},{},{},{}".format(first,last,gender,age,email,state,county,city)
		print(user)
		users.append(user)

	for user in users:
		print user

def main():
	os.chdir("/home/christopher/popdoxa/PopDoxa/data")
	names = get_names(['last.txt', 'male_first.txt', 'female_first.txt'])
	locations = gen_locations()

	gen_user(names, locations, 1000)


main()