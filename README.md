<h1 align="center">Desafio Pigz - API CRUD</h1>
<p align="center"><strong>Server: localhost:8000</strong></p>

<h2>POST /operator</h2>
<p>Create one or more operators</p>
<p>Body JSON Format:</p>
<code>
  [
    {
        "nome": ""
    }
  ]  
</code>

<h2>GET /operator</h2>
<p>Get all operators from database</p>

<h2>GET /operator/{id}</h2>
<p>Get a operator from database by id</p>

<h2>PUT /operator/{id}</h2>
<p>Update a operator from database by id</p>
<p>Body JSON Format:</p>
<code>
  {
    "nome": ""
  } 
</code>

<h2>DELETE /operator/{id}</h2>
<p>Delete a operator from database by id</p>

<hr>

<h2>GET /client</h2>
<p>Get a list of all clients from database</p>

<h2>GET /client/{id}</h2>
<p>Get a client from database by id</p>

<h2>POST /client</h2>
<p>Create a new client on database</p>
<p>Body JSON Format:</p>
<code>
  [
    {
        "nome": "",
        "cpf": 999999,
        "nascimento": "mm/dd/yyyy",
    }
]
</code>

<h2>PUT /client/{id}</h2>
<p>Update client from database by id</p>
<p>Body JSON Format</p>
<code>
  {
    "nome": "",
    "cpf": 999999,
    "nascimento": "mm/dd/yyyy",
  }
</code>

<h2>DELETE /client/{id}</h2>
<p>Delete a client from database by id</p>
