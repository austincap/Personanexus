import re
import sys
import pymongo
import math
import numpy as np
import pprint
from pymongo import MongoClient
import MySQLdb
pp = pprint.PrettyPrinter(indent=2)

#connect to databases
client = MongoClient(host='mongodb://austincapobianco:fucksluts10@ds037244.mongolab.com:37244/personanexus', port=37244)
db = client['personanexus']
collection = db['rawVoteData']

db=MySQLdb.connect(host="localhost", user="root", passwd="", db="test", port=3306)
mysqlcursor = db.cursor()

#find all PIDs
PIDsTotal = []
mysqlcursor.execute("""SELECT personaID FROM plsql;""")
for item in mysqlcursor.fetchall():
	PIDsTotal += item
#print(PIDsTotal)


#create 2-D matrix where every sample is a feature and the ratio are the raw voting results
#this produces the matrix containing the voting results for each persona combo; every combo not voted on receives a default value of 0.5
#each row depicts that personas raw voted affinity for each other persona; a "persona affinity vector"
def produce_p_affinity_matrix(PIDsTotal):
	persona_affinity_matrix = []
	for PID in PIDsTotal:
		persona_affinity_vector = []
		for checkPID in PIDsTotal:
			if PID!=checkPID:
				cursor = collection.find({'$and': [{'personacombo':int(PID)}, {'personacombo':int(checkPID)}]}).limit(1)
				try:
					if cursor.count()>0: #if a document is found for the combo of PID and checkPID
						for document in cursor: #no way to get around using this little for loop
							persona_affinity_vector += [(document['yesvotes'])/(document['totalvotes'])]
					else: #if no document is found assume a neutral value
						persona_affinity_vector+=[.5]
				except AttributeError:
					persona_affinity_vector+=[.5]
			else: #a persona should always be 100%  like itself
				persona_affinity_vector+=[1.0]
		persona_affinity_matrix += [persona_affinity_vector]
	#pp.pprint(persona_similarity_matrix)
	return persona_affinity_matrix

persona_affinity_matrix = produce_p_affinity_matrix(PIDsTotal)


#couldnt get scipy spatial module to work on python 3
def cosine_similarity(v,w):
	return np.dot(v,w)/math.sqrt(np.dot(v,v)*np.dot(w,w))


#this produces a matrix that compares each "persona affinity vector" with each other "persona affinity vector"
#it enables us to create comparisons between persona combos that have not been explicitly voted on
#comparisons are made between personas in the same group, but this can just be ignored and has no bearing on the rest of the results

def most_similiar_personas_to(PID):
	PID-=1
	persona_similarities = [[cosine_similarity(persona_vector_i, persona_vector_j)
						for persona_vector_j in persona_affinity_matrix]
						for persona_vector_i in persona_affinity_matrix]
	#pp.pprint(persona_similarities)
	pairs = [(other_PID, similarity) 
			for other_PID, similarity in
			enumerate(persona_similarities[PID], 1)]
	return sorted(pairs, key=lambda similarity: similarity[1], reverse=True)



PID_query = int(sys.argv[1])
#find the most similar personas then take the top 6 (including the queried persona)
#then unpack the tuple into PIDs and similarity values
top5, top5_similarity_values = zip(*most_similiar_personas_to(PID_query)[:6])
#pp.pprint(most_similiar_personas_to(PID_query))


AllPIDInfo = []
mysqlcursor.execute("""SELECT * FROM plsql;""")
for item in mysqlcursor.fetchall():
	AllPIDInfo += [item]
#print(AllPIDInfo)

pnamelist = []
for pid in top5:
	#show corresponding pname from AllPIDInfo
	for item in AllPIDInfo:
		if item[0]==pid:
			pnamelist += [item[1]]

print("The top 5 most similar personas to '" +pnamelist[0]+ "' from most to least similar are:")
print("<b>")
[print(pname+"\n") for pname in pnamelist[1:]]
print("</b>")