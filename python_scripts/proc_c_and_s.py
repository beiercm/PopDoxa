f_in = list(open("c_and_s.txt"))
county_state_dict = {}

for entry in f_in:
	entry = entry.split(',')
	state = entry[1].strip()#.replace(' ', '')
	if state not in county_state_dict:
		county_state_dict[state] = [entry[0]]
	else:
		county_state_dict[state].append(entry[0])

for state in county_state_dict:
	output = state

	for county in county_state_dict[state]:
		output += "," + county

	print(output)
	



