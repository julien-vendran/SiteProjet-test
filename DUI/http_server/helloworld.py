from bottle import route, run, get, post, request

@route('/')
def index():
    return "Hello World!"

@route('/form')
def form():
    return '''
        <form action="/encode" method="post">
            Mot a encoder: <input name="mot" type="text" />
            <input value="Encode" type="submit" />
        </form>
    '''

@post('/encode') # or @route('/login', method='POST')
def encode():
    mot = request.forms.get('mot')
    #code = encode(mot)
    return mot #ici on peut mettre du code

#cette instruction lance le server
run(host='localhost', port=8080, debug=True)