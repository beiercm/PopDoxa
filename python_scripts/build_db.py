import mysql.connector, sys
import build_tables as bt
from mysql.connector import errorcode
import os

def get_login_info():
	return [e.strip() for e in list(open("login.txt"))]

def create_db(login_info):
	cnx = mysql.connector.connect(user=login_info[1], password=login_info[2])
	query = "create database if not exists cbpopdoxa;"
	cnx.cursor().execute(query)

def get_connec(tables, login_info):
	"""Connect to database and calls build_tables"""
	try:
		create_db(login_info)
		cnx = mysql.connector.connect(user=login_info[1], password=login_info[2], database=login_info[3])
		tables = check_existing_tables(tables, cnx.cursor())
		if tables == "all":
			bt.build_all(cnx.cursor())
		else:
			bt.build_tables(tables, cnx.cursor())
		cnx.commit()
		
	except mysql.connector.Error as err:
		print(err)

def check_existing_tables(tables, cursor):
	query = "select table_name from information_schema.tables where table_schema='cbpopdoxa';"
	cursor.execute(query)

	table_list = [table[0].encode('ascii', 'ignore') for table in list(cursor)]

	if "all" in tables:
		if len(table_list) > 0:
			confirm = raw_input("There are currently tables in the database\nType 'Y' to drop the database or press any key to skip\n")
			if confirm == "Y":
				kill_database()
				create_db(login_info)
				#bt.build_all_tables(cursor)
				return "all"
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

	if "help" in tables:
		help_screen()
		return

	if "rebuild" in tables:
		kill_database("Yes", login_info)
		create_db(login_info)
		cnx = mysql.connector.connect(user=login_info[1], password=login_info[2], database=login_info[3])
		bt.build_all(cnx.cursor())
		cnx.commit()
		return

	if "drop" in tables and "all" in tables:
		kill_database("NO", login_info)

		return

	for table in tables[1::]:
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
	os.chdir("../data")
	login_info = get_login_info()
	
	if len(args) >= 1:
		if not parse_args(args[0][1::], login_info):
			return
		else:
			get_connec(args[0][1::], login_info)
	else:
		print("Please add arguments or add 'help'")

main(sys.argv)