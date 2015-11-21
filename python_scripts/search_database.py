import get_connection as gc

conn = gc.connection()

cursor = conn.cursor()

def get_titles_and_questions():
	stmt = """
		SELECT id, title
		from posts
		"""

	cursor.execute(stmt)
	results = cursor.fetchall()

	print results

def main():
	get_titles_and_questions()

main()	