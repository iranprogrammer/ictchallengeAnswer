import sqlite3
import time

class Database:
    def __init__(self, db_gift='GiftCode.db', db_users='Users.db'):
        self.db_gift = db_gift
        self.db_users = db_users
        self.create_gift_table()
        self.create_users_table()

    def create_gift_table(self):
        with sqlite3.connect(self.db_gift) as conn:
            cursor = conn.cursor()
            cursor.execute('''CREATE TABLE IF NOT EXISTS codes(id INTEGER PRIMARY KEY, code_id TEXT, date_set TEXT, username TEXT, expiration INTEGER)''')
            conn.commit()
    
    def create_users_table(self):
        with sqlite3.connect(self.db_users) as conn:
            cursor = conn.cursor()
            cursor.execute('''CREATE TABLE IF NOT EXISTS users(id INTEGER PRIMARY KEY, username TEXT, password TEXT)''')
            conn.commit()

    def generate_GiftCode(self, code_id, username, percent):
        with sqlite3.connect(self.db_gift) as conn:
            cursor = conn.cursor()
            cursor.execute('''INSERT INTO codes(code_id, date_set, username, expiration, percent) VALUES (?, ?, ?, ?, ?)''', (code_id, time.time(), username, time.time + (3 * 24 * 60 * 60), percent))
            conn.commit()
    
    def del_GiftCode(self, code_id):
        with sqlite3.connect(self.db_gift) as conn:
            cursor = conn.cursor()
            cursor.execute('''DELETE FROM codes WHERE code_id = ?''', (code_id,))
            conn.commit()
    
    def check_GiftCode(self, code_id):
        with sqlite3.connect(self.db_gift) as conn:
            cursor = conn.cursor()
            cursor.execute('''SELECT * FROM codes WHERE code_id = ?''', (code_id,))
            result = cursor.fetchone()
            if result:
                return result

# 
  
    def user_exists(self, username):
        with sqlite3.connect(self.db_users) as conn:
            cursor = conn.cursor()
            cursor.execute('''SELECT * FROM users WHERE username = ?''', (username,))
            result = cursor.fetchone()
            if result:
                return True
            else:
                return False

    def check_user(self, username, password):
        with sqlite3.connect(self.db_users) as conn:
            cursor = conn.cursor()
            cursor.execute(''' SELECT * FROM users WHERE username = ? AND password = ?''', (username, password))
            result = cursor.fetchone()
            if result:
                return True
            else:
                return False
            
    def create_account(self, username, password):
        with sqlite3.connect(self.db_users) as conn:
            cursor = conn.cursor()
            cursor.execute('''INSERT INTO users(username, password) VALUES (?, ?)''', (username, password))
            conn.commit()