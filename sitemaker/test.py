import requests
url = "http://127.0.0.1:5000/renderIndex?username=daradege"

print(requests.get(
    url,
    json={
        "username":"daradege"
    }
    ).text)