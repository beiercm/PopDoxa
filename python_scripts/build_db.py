import os
import mysql.connector, sys
from mysql.connector import errorcode
import build_tables as bt
import backup_db as bu



def get_login_info():
	return [e.strip() for e in list(open("/home/christopher/login.txt"))]

def create_db(login_info):
	cnx = mysql.connector.connect(user=login_info[1], password=login_info[2])
	query = "create database if not exists cbpopdoxa;"
	cnx.cursor().execute(query)

def get_connec(tables, login_info):
	"""Connect to database and calls build_tables"""
	try:
		create_db(login_info)
		cnx = mysql.connector.connect(user=login_info[1], password=login_info[2], database=login_info[3])
		if tables == "all":
			bt.build_all(cnx.cursor())
		else:
			for table in tables:
				if table != 'build':
					kill_table(table, cnx.cursor())
			bt.build_tables(tables, cnx.cursor())
		cnx.commit()
		
	except mysql.connector.Error as err:
		print(err)



def kill_database(confirm, login_info):
	if confirm != "Yes":
		confirm = raw_input("This will drop the entire database, 'Yes' to continue\n")
	if confirm == "Yes":
		cnx = mysql.connector.connect(user=login_info[1], password=login_info[2])
		cursor = cnx.cursor()
		query = "drop database cbpopdoxa;"
		cursor.execute(query)
		print("Database successfully dropped\n")

def kill_table(table, cursor):
	query = "drop table " + table + ";"
	cursor.execute(query)
	print(table + " table successfully dropped")


def parse_args(tables, login_info):
	valid_tables = bt.tables.keys()

	if "help" in tables or len(tables) < 1:
		help_screen()
		return

	if "backup" in tables:
		cnx = mysql.connector.connect(user=login_info[1], password=login_info[2], database=login_info[3])
		bu.backup_database(cnx.cursor())
		return

	if "rebuild" in tables:
		create_db(login_info)	
		kill_database("Yes", login_info)
		create_db(login_info)
		cnx = mysql.connector.connect(user=login_info[1], password=login_info[2], database=login_info[3])
		bt.build_all(cnx.cursor())
		cnx.commit()
		return

	if "drop" in tables and "all" in tables:
		kill_database("NO", login_info)

		return

	tables = tables[1:]

	for table in tables:
		if table not in valid_tables:
			print(table + " is not a valid table")
			print("\nValid tables: ")
			for table in valid_tables:
					print table
			return False

	print("Successfully parsed input tables\n")
	return True
	

def help_screen():
	print(	"""
			'drop all' to wipe database
			'build all' to build entire database, requires there to be no tables
			'build <valid table>'' to build a table (users, votes, etc)
			"""
		)

def main(*args):	
	login_info = get_login_info()
	os.chdir("/home/christopher/popdoxa//PopDoxa/data")
	#os.chdir("../data")
	
	if len(args) >= 1:
		if not parse_args(args[0][1::], login_info):
			return
		else:
			get_connec(args[0][1::], login_info)
	else:
		print("Please add arguments or add 'help'")

main(sys.argv)
