import mysql.connector, sys
import build_tables as bt
from mysql.connector import errorcode
import os

def create_db():
	cnx = mysql.connector.connect(user='root', password='popdoxasd')
	query = "create database if not exists cbpopdoxa;"
	cnx.cursor().execute(query)

def get_connec(tables):
	"""Connect to database and calls build_tables"""
	try:
		create_db()
		cnx = mysql.connector.connect(user='root', password='popdoxasd', database='cbpopdoxa')
		tables = check_existing_tables(tables, cnx.cursor())
		if tables:
			bt.build_tables(tables, cnx.cursor())
		cnx.commit()
		
	except mysql.connector.Error as err:
		print(err)

def check_existing_tables(tables, cursor):
	query = "select table_name from information_schema.tables where table_schema='cbpopdoxa';"
	cursor.execute(query)

	table_list = [str(x[0]).replace("u\'", '') for x in list(cursor)]

	if "all" in tables:
		if len(table_list) > 0:
			confirm = raw_input("There are currently tables in the database\nType 'Y' to drop the database or press any key to skip\n")
			if confirm == "Y":
				kill_database()
				#bt.build_all_tables(cursor)
				bt.build_all(cursor)
			else:
				return
		bt.build_all(cursor)
		return

	for table in tables:
		if table in table_list:
			confirm = raw_input(table +" table already exists, Y to drop and rebuild or N to skip\n")
			
			if confirm == "Y":
				kill_table(table, cursor)
			else:
				tables.remove(table)

	tables.remove("build")

	return tables

def kill_database(confirm = "NO"):
	if confirm != "Yes":
		confirm = raw_input("This will drop the entire database, 'Yes' to continue\n")
	if confirm == "Yes":
		cnx = mysql.connector.connect(user='root', password='popdoxasd')
		cursor = cnx.cursor()
		query = "drop database cbpopdoxa;"
		cursor.execute(query)
		print("Database successfully dropped\n")

def kill_table(table, cursor):
	query = "drop table " + table + ";"
	cursor.execute(query)
	print(table + " table successfully dropped")


def parse_args(tables):
	valid_tables = ['rebuild', 'build', 'all', 'states', 'users', 'votes', 'polls', 'states', 'counties', 
					'cities', 'clubs']

	if "help" in tables:
		help_screen()
		return

	if "rebuild" in tables:
		kill_database("Yes")
		create_db()
		cnx = mysql.connector.connect(user='root', password='popdoxasd', database='cbpopdoxa')
		bt.build_all(cnx.cursor())
		cnx.commit()
		return

	if "drop" in tables and "all" in tables:
		kill_database()

		return

	if "build" in tables or "rebuild" in tables:
		for table in tables:
			if table not in valid_tables:
				print(table + " is not a valid table")
				print("\nValid tables: ")
				for table in valid_tables:
					if table != "rebuild" and table != "build":
						print table
				return False

		print("Successfully parsed input tables\n")
		return True
	else:
		return False

def help_screen():
	print(	"""
			'drop all' to wipe database
			'build all' to build entire database, requires there to be no tables
			'build <valid table>'' to build a table (users, votes, etc)
			"""
		)

def main(*args):	
	os.chdir("../data")
	if len(args) >= 1:
		if not parse_args(args[0][1::]):
			return
		else:
			get_connec(args[0][1::])
	else:
		print("Please add arguments or add 'help'")

main(sys.argv)