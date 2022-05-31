from tkinter import *
from tkinter import messagebox
import bcrypt
from database import Database
from displayWindow import DisplayWindow
db = Database()

class Login:
    def __init__(self):
        self.loginWindow = Tk()
        self.loginWindow.title("Sign Your ADU in")
        self.loginWindow.geometry('360x360')
        self.label = Label(self.loginWindow,text='ADU Sign In')
        self.label.place(x=120,y=10)
        
        self.usernameS = StringVar()
        self.passwordS = StringVar()
        
        self.adu_nameL = Label(self.loginWindow,text='ADU Name')
        self.adu_nameL.place(x=70,y=50)

        self.usernameE = Entry(self.loginWindow,relief=FLAT,textvariable = self.usernameS)
        self.usernameE.place(x=70,y=80)
      
        self.passwordL = Label(self.loginWindow,text='ADU Name')
        self.passwordL.place(x=70,y=110)

        self.passwordE = Entry(self.loginWindow,show='*',relief=FLAT,textvariable=self.passwordS)
        self.passwordE.place(x=70,y=130)

        self.username = self.usernameS.get()
        self.password= self.passwordS.get()
        
        self.submit = Button(self.loginWindow, text = "Submit",pady=5,padx=20,command=self.validate)
        self.submit.place(x=70,y=160)

    def validate(self):
        
        adu_name = self.usernameE.get()
        adu_password = self.passwordE.get()
        
        try:
            if(db.validateData(adu_name,adu_password)):
                adu_id = db.validateData(adu_name,adu_password)
                displayWindow = DisplayWindow(adu_id)
                displayWindow.run()
            else:
                messagebox.showerror("Error","Wrong Credentials")
        except IndexError:
            messagebox.showerror("Error","No ADU With Given Credentials")

    def run(self):
        self.loginWindow.mainloop()

