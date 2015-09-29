import mysql.connector
from mysql.connector import errorcode

def get_raw_data():
	try:
		cnx = mysql.connector.connect(user='root', password='popdoxasd', database='wordpress')
		cursor = cnx.cursor()
		query = ("select post_name,ID,post_parent from wp_posts where post_type = 'forum'")

		cursor.execute(query)

		state_list = list(cursor)

		#cursor.close()
		#cnx.close()

		return state_list
		
	except mysql.connector.Error as err:
		print("Here")
		print(err)

def get_states(raw_state_list):
	state_dict = {}
	for state in raw_state_list:
		if state[2] == 30:
			state_dict[state[1]] = (str(state[0]), str("10.171.204.135/?forum=forum/" + str(state[0])))

	return state_dict

def get_cities(raw_state_list, state_dict):
	city_dict = {}
	for city in raw_state_list:
		if city[2] in state_dict:
			city_dict[city[1]] = (str(city[0]), 
				str("10.171.204.135/?forum=forum/" + state_dict[city[2]][0] + "/" + str(city[0])))

	return city_dict

def something():
	state_list = sorted(state_dict.keys())
	city_list = sorted(city_dict.keys())

	for state_id in state_list:
		print(state_dict[state_id])

	for city_id in city_list:
		print(city_dict[city_id])

def main():
	raw_state_list = get_raw_data()

	states_dict = get_states(raw_state_list)
	cities_dict = get_cities(raw_state_list, states_dict)

	states_list = states_dict.values()

	cities_list = cities_dict.values()

	for state in states_list:
		print(state)

	print()

	for city in cities_list:
		print(city)

main()