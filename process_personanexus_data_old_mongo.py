import pymongo
from pymongo import MongoClient
client = MongoClient(host='localhost', port=27017)
db = client['test']
collection = db['rawVoteData']

import MySQLdb
db=MySQLdb.connect(host="localhost", user="root", passwd="", db="test", port=3306)
mysqlcursor = db.cursor()

import operator

#mysqlcursor.execute("""SELECT * FROM plsql;""")
#fetch all personas
#print(mysqlcursor.fetchall())

#mysqlcursor.execute("""SELECT * FROM pglsql;""")
#fetch all persona groups
#print(mysqlcursor.fetchall())

#two inputs
#personaID and groupID (fire from group 1 and the directions group)
initialQueryPID = 9
queryGID = 5

#get all personaIDs associated with queryGID
PIDsInGID = []
mysqlcursor.execute("""SELECT personaID FROM plsql WHERE groupID = %s;""", (queryGID,))
for item in mysqlcursor.fetchall():
    #print(item)
    PIDsInGID += item

PIDdict ={}
#for each one find the yesvotes/totalvotes
for PID in PIDsInGID:
    cursor = collection.find({"$and": [{"personacombo":initialQueryPID},{"personacombo":PID}] }, projection={'yesvotes':1,'totalvotes':1})
    for document in cursor:
        ratio = document['yesvotes']/document['totalvotes']
        PIDdict[PID] = ratio
        #print(str(PID) + ':' + str(ratio))
        #print(document['yesvotes'])
print(PIDdict)
if any(PIDdict) == False: #check if dict is empty first
    print("sorry bro not enough data")
#dict.item instead of dict.iteritems cause python 3
else: print(max(PIDdict.items(), key=operator.itemgetter(1))[0])
    
