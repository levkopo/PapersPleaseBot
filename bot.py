from flask import Flask, request, json
import vk

session = vk.Session()
api = vk.API(session, v=5.0)

token = 'ab37EghD5gfE5fg54'
confirmation_token = 'ebe11f1b'

def send_message(user_id, token, message, attachment=""):
    api.messages.send(access_token=token, user_id=str(user_id), message=message, attachment=attachment)

@app.route('/bots/papers_please', methods=['POST'])
def mainRoute():
    data = json.loads(request.data)
    if 'type' not in data.keys():
        return 'not vk'
    if data['type'] == 'confirmation':
        return confirmation_token
    elif data['type'] == 'message_new':
        session = vk.Session()
        api = vk.API(session, v=5.0)
        user_id = data['object']['user_id']
        api.messages.send(access_token=token, user_id=str(user_id), message='test')
        return 'ok'