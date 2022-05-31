from tkinter import *
from login import Login


class MainWindow:
    def __init__(self):
        self.app = Tk()
        self.app.title("ADU Login")
        self.app.geometry("300x250")
        self.label = Label(self.app, text="Sign your ADU In")
        self.label.place(x=95,y=40)
        self.login = Button(self.app, text="Login",pady =5,padx=20,command=login)
        self.login.place(x=100,y=100)
        

    def run(self):
        self.app.mainloop()

    
def login():
    loginTk =Login()
    loginTk.run()


app = MainWindow()
app.run()
