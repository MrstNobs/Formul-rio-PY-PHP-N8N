from flask import Flask, request, jsonify
from flask_cors import CORS
from dotenv import load_dotenv

import requests
import os

load_dotenv()
N8N_WEBHOOK_URL = os.getenv("N8N_WEBHOOK_URL")
API_PHP_URL = os.getenv("API_PHP_URL")
PORTA = os.getenv("PORTA")

app = Flask(__name__)
CORS(app, resources={r"/*" : {"origins" : [API_PHP_URL]}})

@app.route("/EnviarMensagem", methods=['POST', 'OPTIONS'])
def EnviarMensagem():

    data = request.json

    email_dstny = data.get('email_dstny')
    nome_dstny = data.get('nome_dstny')
    msg_dstny = data.get('msg_dstny')

    payload = {
        'email':email_dstny,
        'nome': nome_dstny,
        'mensagem': msg_dstny
    }

    if not N8N_WEBHOOK_URL:
        return jsonify({
            "success": False,
            "message": "Configuração do Serivor Não Encontrada"
        }), 500
    
    try:
        resposta = requests.post(N8N_WEBHOOK_URL, json=payload, timeout=5)

        if 200 <= resposta.status_code < 300:
            return jsonify({
                "success": True,
                "message": "Mensagem Enviada com Sucesso"
            })
        else:
            return jsonify({
                "success": False,
                "message": "Erro ao enviar para N8N"
            }), 502
    except requests.exceptions.Timeout:
        return jsonify({
            "success": False,
            "message": "TimeOut de serviço"
        }), 504
    except requests.exceptions.RequestException as e:
        return jsonify({
            "success": False,
            "message": "Erro communicate"
        }), 502
    except Exception as e:
        return jsonify({
            "success": False,
            "message": f"Error Interno: {str(e)}"
        }), 500

    return

if __name__ == '__main__':
    app.run(port=int(PORTA), debug=True)