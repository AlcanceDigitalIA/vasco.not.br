// Menu mobile
const toggle = document.getElementById('menu-toggle');
const nav    = document.getElementById('nav-principal');
toggle.addEventListener('click', () => nav.classList.toggle('aberto'));

// Fecha menu ao clicar num link
nav.querySelectorAll('a').forEach(a => {
  a.addEventListener('click', () => nav.classList.remove('aberto'));
});

// Destaca link ativo ao rolar
const secoes = document.querySelectorAll('section[id]');
const links  = document.querySelectorAll('nav a[href^="#"]');

window.addEventListener('scroll', () => {
  let atual = '';
  secoes.forEach(s => {
    if (window.scrollY >= s.offsetTop - 120) atual = s.id;
  });
  links.forEach(a => {
    a.classList.toggle('ativo', a.getAttribute('href') === '#' + atual);
  });
}, { passive: true });

// Formulário de contato via Formspree
const form   = document.getElementById('form-contato');
const alerta = document.getElementById('form-alerta');

form.addEventListener('submit', async (e) => {
  e.preventDefault();
  const btn = form.querySelector('button[type=submit]');
  btn.disabled = true;
  btn.textContent = 'Enviando…';
  alerta.className = 'alerta';
  alerta.textContent = '';

  try {
    const res = await fetch(form.action, {
      method: 'POST',
      body: new FormData(form),
      headers: { 'Accept': 'application/json' }
    });

    if (res.ok) {
      alerta.className = 'alerta sucesso';
      alerta.textContent = 'Mensagem enviada com sucesso! Retornaremos em breve.';
      form.reset();
    } else {
      const data = await res.json();
      throw new Error(data?.errors?.[0]?.message || 'Erro ao enviar.');
    }
  } catch (err) {
    alerta.className = 'alerta erro';
    alerta.textContent = err.message || 'Erro ao enviar. Tente pelo telefone.';
  } finally {
    btn.disabled = false;
    btn.textContent = 'Enviar Mensagem';
    alerta.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
  }
});
