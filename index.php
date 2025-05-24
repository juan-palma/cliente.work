<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport"
        content="width=device-width, initial-scale=1, viewport-fit=cover" />
  <title>Preview Card</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 2rem;
      max-width: 600px;
      margin: auto;
    }
    .input-group {
      display: flex;
      margin-bottom: 1rem;
    }
    .input-group input {
      flex: 1;
      padding: 0.5rem;
      font-size: 1rem;
      border: 1px solid #ccc;
      border-radius: 4px 0 0 4px;
      outline: none;
    }
    .input-group button {
      padding: 0.5rem 1rem;
      font-size: 1rem;
      border: 1px solid #28a745;
      background: #28a745;
      color: white;
      border-radius: 0 4px 4px 0;
      cursor: pointer;
    }
    .input-group button:disabled {
      background: #aaa;
      border-color: #aaa;
      cursor: not-allowed;
    }
    .card {
      display: flex;
      border: 1px solid #ddd;
      border-radius: 8px;
      overflow: hidden;
      text-decoration: none;
      color: inherit;
      margin-top: 1rem;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
    .card img {
      width: 120px;
      object-fit: cover;
      flex-shrink: 0;
    }
    .card .info {
      padding: 0.75rem;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }
    .card .info h3 {
      margin: 0 0 0.5rem;
      font-size: 1.1rem;
    }
    .card .info p {
      margin: 0;
      font-size: 0.9rem;
      color: #555;
    }
    .error {
      color: #c00;
      margin-top: 1rem;
    }
  </style>
</head>
<body>

  <h1>Generar Tarjeta de Vista Previa</h1>

  <div class="input-group">
    <input id="url-input"
           type="url"
           placeholder="https://ejemplo.com/pagina"
           autocomplete="off" />
    <button id="go-btn">Mostrar Preview</button>
  </div>

  <div id="preview-container"></div>
  <div id="error-msg" class="error"></div>

  <script>
    const input = document.getElementById('url-input');
    const btn   = document.getElementById('go-btn');
    const box   = document.getElementById('preview-container');
    const err   = document.getElementById('error-msg');

    async function mostrarPreview(link) {
      // limpia
      box.innerHTML = '';
      err.textContent = '';
      btn.disabled = true;

      try {
        const res = await fetch('/preview.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ url: link })
        });

        if (!res.ok) {
          const { error } = await res.json();
          throw new Error(error || 'Error desconocido');
        }

        const { title, description, image, url } = await res.json();

        // construye la tarjeta
        const a = document.createElement('a');
        a.href          = url;
        a.target        = '_blank';
        a.rel           = 'noopener';
        a.className     = 'card';
        a.innerHTML = `
          <img src="${image || 'https://via.placeholder.com/120x90?text=No+Image'}"
               alt="${title}"/>
          <div class="info">
            <h3>${title || 'Sin título'}</h3>
            <p>${description || 'Sin descripción disponible.'}</p>
          </div>
        `;
        box.appendChild(a);

      } catch (e) {
        console.error(e);
        err.textContent = e.message;
      } finally {
        btn.disabled = false;
      }
    }

    btn.addEventListener('click', () => {
      const url = input.value.trim();
      if (url) mostrarPreview(url);
    });

    // También puedes disparar con Enter
    input.addEventListener('keydown', e => {
      if (e.key === 'Enter') btn.click();
    });
  </script>

</body>
</html>
