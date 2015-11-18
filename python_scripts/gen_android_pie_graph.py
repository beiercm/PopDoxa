#from pylab import *
import get_connection as gc

conn = gc.connection()
cursor = conn.cursor()

# make a square figure and axes
def get_results(poll_id):
	query = """
	SELECT vote, count(vote) 
	FROM poll_results 
	WHERE vote = 'y' 
	AND poll_id = """ + str(poll_id) + """
	UNION
	SELECT vote, count(vote) 
	FROM poll_results 
	WHERE vote = 'n' 
	AND poll_id = """ + str(poll_id) + """
	UNION
	SELECT vote, count(vote) 
	FROM poll_results 
	WHERE vote = 'u' 
	AND poll_id = """ + str(poll_id) + """;
	"""

	cursor.execute(query)

	yes_results = cursor.fetchall()

	print yes_results
	

def main():
	

	get_results(1)

main()	