from flask import Flask, render_template, request, session, jsonify
from database import Database
import string
import random

app = Flask(__name__)

db = Database()

# @app.route
@app.route('/genCode', methods=['POST'])
def genCode():
    data = request.get_json()
    username = data['service']
    code_id = data['code']
    percent = data['percent']

    db.generate_GiftCode(code_id, username, percent)
    return jsonify(
        {
            "code":200,
            "result":True,
        }
    )

@app.route('/delCode', methods=['POST'])
def delCode():
    data = request.get_json()
    code_id = data['code']
    username = data['username']
    if db.check_GiftCode(code_id)[3] == username:
        db.del_GiftCode(code_id)
        return jsonify(
            {
                "code":200,
                "result":True,
            }
        )

@app.route('/isUserIn', methods=['POST'])
def isUserIn():
    data = request.get_json()
    username = data['username']
    password = data['password']
    answer = db.check_user(username, password)
    return jsonify(
        {
            "code":200,
            "result":answer,
        }
    )

@app.route('/createAccount', methods=['POST'])
def createAccount():
    data = request.get_json()
    username = data['username']
    password = data['password']
    if not db.user_exists(username):
        db.create_account(username, password)
        return jsonify(
        {
            "code":200,
            "result":True,
        }
    )

# if __name__ == '__main__':
#     app.run()