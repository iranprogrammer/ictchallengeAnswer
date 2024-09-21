import requests


url = "https://192.168.43.88/genCode"

response = requests.post(url,data="salam")

print(response.status_code)