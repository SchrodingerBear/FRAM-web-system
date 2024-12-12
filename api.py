import requests
import json

API_LINK = "https://frammanagement.site/DATABASE/api.php"


class APIClient:
    def __init__(self, base_url):
        self.base_url = base_url

    def send_request(self, action, table, data=None, conditions=None, columns="*"):
        payload = {"action": action, "table": table}

        if data:
            payload["data"] = json.dumps(data)
        if conditions:
            payload["conditions"] = json.dumps(conditions)
        if action == "select":
            payload["columns"] = columns

        response = requests.post(self.base_url, data=payload)
        try:
            return response.json()
        except ValueError as e:
            print("Error decoding JSON:", e)
            print("Raw Response:", response.text)
            return {"success": False, "message": "Invalid JSON response"}

    def insert_user(self, user_data):
        return self.send_request(action="insert", table="users", data=user_data)

    def delete_user(self, conditions):
        return self.send_request(action="delete", table="users", conditions=conditions)

    def update_user(self, user_data, conditions):
        return self.send_request(
            action="update", table="users", data=user_data, conditions=conditions
        )

    def select_user(self, conditions=None, columns="*"):
        return self.send_request(
            action="select", table="users", conditions=conditions, columns=columns
        )


if __name__ == "__main__":
    client = APIClient(API_LINK)

    new_user = {
        "first_name": "John",
        "middle_name": "A",
        "last_name": "Doe",
        "email": "john.doe@example.com",
        "password": "password123",
        "role": "admin",
    }
    print("Insert User:", client.insert_user(new_user))

    # Select users
    print("Select Users:", client.select_user())

    # Update a user
    # update_data = {"first_name": "Johnny"}
    # conditions = {"id": 1}
    # print("Update User:", client.update_user(update_data, conditions))

    # Delete a user
    # delete_conditions = {"id": 1}
    # print("Delete User:", client.delete_user(delete_conditions))
