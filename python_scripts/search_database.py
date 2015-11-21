import os, sys, json
import get_connection as gc

conn = gc.connection()

cursor = conn.cursor()

def get_titles_and_questions(keyword):
	stmt = "SELECT id, title from posts;"

	to_return = {}

	cursor.execute(stmt)
	if not cursor.rowcount:
		return
	
	for row in cursor:
		if keyword in row[1]:
			to_return[row[0]] = str(row[1])

	print json.dumps(to_return)

def main():
	if len(sys.argv) < 2:
		return

	get_titles_and_questions(sys.argv[1])

main()	