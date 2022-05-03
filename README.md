<h1 align="center">Desafio Pigz - API CRUD</h1>
<strong>Server: localhost:8000</strong>

<h2>GET /client</h2>
<p>Get a list of all clients</p>

<h2>GET /client/{id}</h2>
<p>Get a client</p>

<h2>POST /client</h2>
<p>Create a new client</p>
<p>Body JSON Format:</p>
<code>
  [
    {
        "nome": "",
        "cpf": "",
        "nascimento": "dd/mm/aaaa",
        "telefones": [
            {
                "ddd": "000",
                "numero": 000000000,
                "operadora_id": 0
            }
        ]
    }
]
</code>

<h2>PUT /client/{id}</h2>
<p>Update data from an existent client</p>
<p>Body JSON Format</p>
<code>
  [
    {
        "nome": "",
        "cpf": "",
        "nascimento": "dd/mm/aaaa",
        "telefones": [
            {
                "ddd": "000",
                "numero": 000000000,
                "operadora_id": 0
            }
        ]
    }
]
</code>

<h2>DELETE /client/{id}</h2>
<p>Delete a client</p>
