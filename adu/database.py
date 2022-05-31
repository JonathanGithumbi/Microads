import mysql.connector
import bcrypt
from pprint import pprint
class Database:

    def __init__(self):
        try:
            self.conn = mysql.connector.connect(
                host = "127.0.0.1",
                port = '3308',
                user = "root",
                password="root",
                database ='wbdcmds'
            )
            self.cursor =self.conn.cursor()
        except Exception as e:

            print("Error: "+str(e))

    def validateData(self, adu_name, adu_password):
        
        sql = "select adu_name,adu_password,adu_id from adus where adu_name = %s ; "
        self.cursor.execute(sql,(adu_name,)) 
        result = self.cursor.fetchall()
        adu_nameR = result[0][0]
        adu_id = result[0][2]
        adu_passwordR = bytes(result[0][1],'utf-8')
        adu_password = bytes(adu_password,'utf-8')
        
        if(bcrypt.checkpw(adu_password,adu_passwordR)):
            return adu_id 
        else:
            return False  

    def has_schedule(self, adu_id):
        sql = "select * from queue where adu_id = %s  ;"
        self.cursor.execute(sql,(adu_id,))
        result = self.cursor.fetchall()
        if(self.cursor.rowcount > 0):
            return True
        else:
            return False

    def get_push(self,adu_id):
        sql = "select content,start_date, end_date,start_time,end_time from queue where adu_id = %s and start_date >= curdate() and start_time >= curtime() order by start_date,start_time"
        self.cursor.execute(sql, (adu_id,))
        result = self.cursor.fetchall()
        rc = self.cursor.rowcount
        if rc > 0 :
            
            push = result[0]
            pprint(push)
            return push
        else:
            print(self.cursor.rowcount)
            return False
        


