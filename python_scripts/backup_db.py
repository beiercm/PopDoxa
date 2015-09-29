import datetime, os
from build_tables import tables

def backup_database(cursor):
	print("Backing up database...")
	os.chdir("../../backup_data")
	date = datetime.datetime.today()
	date = "{0}_{1}_{2}.txt".format(date.year, date.month, date.day)

	fout = open(date, 'w+')

	for table in tables:
		query = "SELECT * FROM {0};".format(table)
		cursor.execute(query)
		results = cursor.fetchall()

		# for result in results:
		# 	if type(result) == unicode:
		# 		result = result.encode('ascii', 'ignore')

		fout.write(table + "\n")
		for result in results:
			fout.write(str(result) + "\n")
