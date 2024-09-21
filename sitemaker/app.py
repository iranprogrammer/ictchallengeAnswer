from flask import Flask, request, jsonify, render_template
import os
import json
import requests


app = Flask(__name__)

@app.route('/getInfo', methods=['POST'])
def get_info():
    data = request.get_json()
    username = data.get('username')
    sitename = data.get('sitename')
    index_html  = data.get('index_html')

    if not username or not sitename:
        return jsonify({'message': 'Error: Username and sitename are required!'}), 400
    
    folder_path = os.path.join(os.getcwd(), username)
    try:
        os.makedirs(folder_path, exist_ok=True)
        file_path = os.path.join(folder_path, 'data.json')
        index_path = os.path.join(folder_path, 'index.html')
        
        with open(file_path, 'w') as json_file:
            json.dump({'sitename': sitename}, json_file)
        
        # Create a basic index.html file
        with open(index_path, 'w') as index_file:
            if not index_html:
                template = render_template("clone.html").replace("APPNAMEHOLDER",sitename)
                index_file.write(template)
            else:
                index_file.write(index_html)
        
        return render_template('clone.html')
    except Exception as e:
        return jsonify({'message': f'An error occurred: {str(e)}'}), 500

@app.route('/renderIndex', methods=['GET'])
def render_index():
    username = request.args.get('username')
    if not username:
        return jsonify({'message': 'Error: Username is required!'}), 400
    
    folder_path = os.path.join(os.getcwd(), username)
    index_path = os.path.join(folder_path, 'index.html')
    
    if not os.path.exists(index_path):
        return jsonify({'message': f'Error: Index file for user {username} does not exist!'}), 404
    
    with open(index_path, 'r') as index_file:
        content = index_file.read()
    
    return content, 200, {'Content-Type': 'text/html'}


