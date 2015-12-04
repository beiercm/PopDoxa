import os
import build_tables as bt
import backup_db as bu
import get_connection as gc

def create_db(cursor):
	query = "create database if not exists cbpopdoxa;"
	cursor.execute(query)

def kill_database(cursor):
		query = "drop database cbpopdoxa;"
		cursor.execute(query)
		print("Database successfully dropped\n")

def rebuild(cursor):
	try:
		kill_database(cursor)
	except Exception as e:
		print e

	create_db(cursor)
	bt.build_all(cursor)

def main(*args):	
	conn = gc.connection()
	os.chdir("/home/christopher/popdoxa/PopDoxa/data")
	
	rebuild(conn.cursor)

	conn.commit()

main()
