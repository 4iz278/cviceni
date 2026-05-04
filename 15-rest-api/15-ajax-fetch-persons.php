<!DOCTYPE html>
<html lang="cs">
<head>
  <meta charset="UTF-8">
  <title>Ukázka práce s REST API (fetch)</title>

  <!-- Bootstrap CSS (CDN) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-4">

  <h1 class="mb-4">Seznam osob</h1>

  <button class="btn btn-primary mb-3" onclick="loadPersons()">
    Načíst osoby
  </button>

  <div id="persons" class="list-group"></div>

</div>

<script>
  const API_URL = 'https://eso.vse.cz/~xname/15-api-persons/person';//TODO upravte si URL

  // načtení seznamu osob
  async function loadPersons() {
    try {
      const response = await fetch(API_URL);
      const data = await response.json();
      console.log(data);

      const container = document.getElementById('persons');
      container.innerHTML = '';

      for (const id in data) {
        const person = data[id];

        const item = document.createElement('div');
        item.className = 'list-group-item d-flex justify-content-between align-items-center';

        item.innerHTML = `
          <div>
            <strong>${person.name}</strong><br>
            <small class="text-muted">${person.email}</small>
          </div>
          <button class="btn btn-sm btn-danger" onclick="deletePerson(${person.id})">
            Smazat
          </button>
        `;

        container.appendChild(item);
      }
    } catch (error) {
      console.error('Chyba při načítání:', error);
    }
  }

  // smazání osoby
  async function deletePerson(id) {
    if (!confirm('Opravdu chcete smazat tuto osobu?')) return;

    try {
      const response = await fetch(API_URL + '?id=' + id, {
        method: 'POST',
        headers: {
          'X-HTTP-Method-Override': 'DELETE'
        }
      });

      if (response.ok) {
        loadPersons(); // znovu načteme seznam
      } else {
        console.error('Chyba při mazání');
      }

    } catch (error) {
      console.error('Chyba:', error);
    }
  }

  // automatické načtení po otevření stránky
  loadPersons();
</script>

</body>
</html>