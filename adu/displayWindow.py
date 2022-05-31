from tkinter import *
from database import Database
from pprint import pprint
import time
import datetime
import schedule
import sched
import sys
from PIL import Image,ImageTk
class DisplayWindow:
    def __init__(self,adu_id):
        self.displayWindow = Tk()
        self.displayWindow.geometry("800x450")
        self.adu_id = adu_id
        self.defaultimage = "defaultimage.png"
        self.canvas = Canvas(self.displayWindow, width = 999,height = 999)
        self.canvas.pack()
        if(self.has_schedule(self.adu_id)):#Has previouly scheduled objects
            try:
                db = Database()
                if db.get_push(self.adu_id):
                    self.push_obj = db.get_push(self.adu_id)#has any upcoming sxheduled objects i.e greater than now() and date()
                    start_time,duration = self.push(self.push_obj)
                    start_time = start_time.timestamp()
                    end_time = start_time+duration
                    s = sched.scheduler(time.time, time.sleep)
                    s.enterabs(start_time,1, self.push, argument = (self.push_obj,))
                    s.run()
                   
                    
                else:
                    self.label = Label(self.displayWindow,text='No Upcoming Pushes')
                    self.label.place(x= 230,y=98)   
                    
            except Exception as e:
                error_type = sys.exc_info()[0]
                self.label = Label(self.displayWindow,text=str(e))
                self.label.place(x= 230,y=98)
        else:
            self.img = ImageTk.PhotoImage(file = "defaultimage.png",master=self.displayWindow)#Hack From https://issue.life/questions/45394885
            self.canvas.create_image(0,0, anchor="nw", image=self.img)
    
    def theloop(self,adu_id):
        #self.displayWindow.destroy()
        displayWindow = DisplayWindow(adu_id)
        displayWindow.run()

    def convert_timedelta(self,duration):
        days, seconds = duration.days, duration.seconds
        hours = days * 24 + seconds // 3600
        minutes = (seconds % 3600) // 60
        seconds = (seconds % 60)
        return hours, minutes, seconds

    def display(self,content):
        self.img = ImageTk.PhotoImage(file = content,master=self.displayWindow)#Hack From https://issue.life/questions/45394885
        self.canvas.create_image(0,0, anchor="nw", image=self.img)        

    def push(self,push_obj):
        content = push_obj[0]
        start_date = push_obj[1]
        end_date = push_obj[2]
        start_time = push_obj[3]
        end_time = push_obj[4]  
        hours,minutes,seconds = self.convert_timedelta(start_time)
        start_time = datetime.time(hours,minutes,seconds)
        hours,minutes,seconds = self.convert_timedelta(end_time)
        end_time = datetime.time(hours,minutes,seconds)
        start_date_time = datetime.datetime.combine (start_date,start_time)
        end_date_time = datetime.datetime.combine (end_date,end_time)
        duration = end_date_time-start_date_time
        duration = abs(duration.total_seconds())
        self.img = ImageTk.PhotoImage(file = content,master=self.displayWindow)#Hack From https://issue.life/questions/45394885
        self.canvas.create_image(0,0, anchor="nw", image=self.img)
        return start_date_time,duration
    def has_schedule(self, adu_id):
        db = Database()
        if(db.has_schedule(adu_id)):
            return True
        else:
            return False
            
        

    def run(self):
        self.displayWindow.mainloop()