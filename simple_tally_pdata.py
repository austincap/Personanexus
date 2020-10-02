import pymongo
import operator
import sys
from pymongo import MongoClient
client = MongoClient(host='mongodb://austincapobianco:fucksluts10@ds037244.mongolab.com:37244/personanexus', port=37244)
db = client['personanexus']
collection = db['rawVoteData']

import MySQLdb
db=MySQLdb.connect(host="localhost", user="root", passwd="", db="test", port=3306)
mysqlcursor = db.cursor()


#get all personas and persona groups
mysqlcursor.execute("""SELECT * FROM plsql;""")
pl_list = mysqlcursor.fetchall()
mysqlcursor.execute("""SELECT * FROM pglsql;""")
pgl_list = mysqlcursor.fetchall()


#two inputs
#personaID and groupID (fire from group 1 and the directions group)
initialQueryPID = int(sys.argv[1])
queryGID = int(sys.argv[2])


#get all personaIDs associated with queryGID
mysqlcursor.execute("""SELECT personaID FROM plsql WHERE groupID = %s;""", (queryGID,))
PIDsInGID = [item[0] for item in mysqlcursor.fetchall()]
#print(PIDsInGID)

PIDdict = {}
newPIDdict = {}
#for each PID in queriedGID find the yesvotes/totalvotes with respect to the initial queryPID
for PID in PIDsInGID:
	cursor = collection.find({"$and": [{"personacombo":initialQueryPID},{"personacombo":PID}] }, projection={'yesvotes':1,'totalvotes':1})
	for document in cursor:
		ratio = document['yesvotes']/document['totalvotes']
		totalvotes = document['totalvotes']
		PIDdict[PID] = (ratio, totalvotes)
		newPIDdict[PID] = ratio*(totalvotes+1)
		#print(str(PID) + ':' + str(ratio))
		#print(document['yesvotes'])
#print(str(pl_list[initialQueryPID-1][1]) + " has a (ratio, totalvotes) with these personas in group: " + str(pgl_list[queryGID-1][1]) + " " + str(PIDdict))
#print(str(pl_list[initialQueryPID-1][1]) + " has a modified ratio with  these personas in group: " + str(pgl_list[queryGID-1][1]) + " " + str(newPIDdict))
if any(newPIDdict) == False: #check if dict is empty first
	print("sorry bro not enough data")
#dict.item instead of dict.iteritems cause python 3
else:
	print("this persona from the group '" + pgl_list[queryGID-1][1] + "' has the max affinity with " + str(pl_list[initialQueryPID-1][1]) +":")
	max_val = max(newPIDdict.values())
	keys = (k for k, v in newPIDdict.items() if v == max_val)
	print("<b>")
	[print(pl_list[int(key)-1][1]) for key in keys]
	print("</b>")
#print(max(PIDdict.items(), key=operator.itemgetter(1))[0])
	
