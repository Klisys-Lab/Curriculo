// assets/js/app.js
document.addEventListener('DOMContentLoaded', function () {
  const dataNasc = document.getElementById('data_nascimento');
  const idadeInput = document.getElementById('idade');
  const addExpBtn = document.getElementById('addExperience');
  const experiencesList = document.getElementById('experiencesList');
  const addRefBtn = document.getElementById('addReference');
  const referencesList = document.getElementById('referencesList');
  const previewBtn = document.getElementById('previewBtn');
  const previewArea = document.getElementById('previewArea');
  const previewContent = document.getElementById('previewContent');
  const printPreview = document.getElementById('printPreview');

  function calcularIdade(dateString) {
    if(!dateString) return '';
    const hoje = new Date();
    const nasc = new Date(dateString);
    let anos = hoje.getFullYear() - nasc.getFullYear();
    const m = hoje.getMonth() - nasc.getMonth();
    if (m < 0 || (m === 0 && hoje.getDate() < nasc.getDate())) anos--;
    return anos;
  }

  dataNasc?.addEventListener('change', function () {
    idadeInput.value = calcularIdade(this.value);
  });

  let expIndex = 0;
  function addExperience(data = {}) {
    const idx = expIndex++;
    const wrapper = document.createElement('div');
    wrapper.className = 'mb-3 border p-3 rounded';
    wrapper.innerHTML = `
      <div class="mb-2 d-flex justify-content-between">
        <strong>Experiência</strong>
        <div><button type="button" class="btn btn-sm btn-outline-danger remove-exp">Remover</button></div>
      </div>
      <div class="row g-2">
        <div class="col-md-4"><input name="exp_titulo[]" value="${data.titulo||''}" placeholder="Cargo" class="form-control"></div>
        <div class="col-md-4"><input name="exp_empresa[]" value="${data.empresa||''}" placeholder="Empresa" class="form-control"></div>
        <div class="col-md-4"><input name="exp_periodo[]" value="${data.periodo||''}" placeholder="Período" class="form-control"></div>
        <div class="col-12 mt-2"><textarea name="exp_descricao[]" placeholder="Descrição" class="form-control" rows="2">${data.descricao||''}</textarea></div>
      </div>
    `;
    experiencesList.appendChild(wrapper);
    wrapper.querySelector('.remove-exp').addEventListener('click', ()=> wrapper.remove());
  }

  let refIndex = 0;
  function addReference(data = {}) {
    const idx = refIndex++;
    const wrapper = document.createElement('div');
    wrapper.className = 'mb-2 d-flex gap-2 align-items-center';
    wrapper.innerHTML = `
      <input name="ref_nome[]" value="${data.nome||''}" placeholder="Nome" class="form-control">
      <input name="ref_contato[]" value="${data.contato||''}" placeholder="Contato (tel/email)" class="form-control">
      <button type="button" class="btn btn-outline-danger remove-ref">Remover</button>
    `;
    referencesList.appendChild(wrapper);
    wrapper.querySelector('.remove-ref').addEventListener('click', ()=> wrapper.remove());
  }

  addExpBtn?.addEventListener('click', ()=> addExperience());
  addRefBtn?.addEventListener('click', ()=> addReference());

  // Adiciona um bloco inicial por usabilidade
  if (experiencesList.children.length === 0) addExperience();
  if (referencesList.children.length === 0) addReference();

  previewBtn?.addEventListener('click', function () {
    // Gera uma mini pré-visualização simples no cliente sem salvar no servidor
    const form = document.getElementById('cvForm');
    const formData = new FormData(form);
    const nome = formData.get('nome') || '';
    const data_n = formData.get('data_nascimento') || '';
    const idade = formData.get('idade') || '';
    const resumo = formData.get('resumo') || '';
    const habilidades = formData.get('habilidades') || '';

    // experiências
    const exps = [];
    formData.getAll('exp_titulo[]').forEach((t,i)=>{
      const titulo = t;
      const empresa = formData.getAll('exp_empresa[]')[i] || '';
      const periodo = formData.getAll('exp_periodo[]')[i] || '';
      const desc = formData.getAll('exp_descricao[]')[i] || '';
      if(t || empresa || periodo || desc) exps.push({titulo, empresa, periodo, desc});
    });

    // referências
    const refs = [];
    formData.getAll('ref_nome[]').forEach((n,i)=>{
      const nomeRef = n;
      const contato = formData.getAll('ref_contato[]')[i] || '';
      if(nomeRef || contato) refs.push({nome: nomeRef, contato});
    });

    // monta HTML simples
    let html = `<div><h3>${escapeHtml(nome)}</h3><div class="text-muted">Nascimento: ${escapeHtml(data_n)} • Idade: ${escapeHtml(idade)}</div></div>`;
    if(resumo) html += `<div class="mt-3"><h5>Resumo</h5><div>${escapeHtml(resumo)}</div></div>`;
    if(exps.length){
      html += `<div class="mt-3"><h5>Experiências</h5>`;
      exps.forEach(e=>{
        html += `<div class="mb-2"><strong>${escapeHtml(e.titulo)}</strong> — <span class="text-muted">${escapeHtml(e.empresa)} | ${escapeHtml(e.periodo)}</span><div>${escapeHtml(e.desc)}</div></div>`;
      });
      html += `</div>`;
    }
    if(habilidades){
      html += `<div class="mt-3"><h5>Habilidades</h5><div>${escapeHtml(habilidades)}</div></div>`;
    }
    if(refs.length){
      html += `<div class="mt-3"><h5>Referências</h5>`;
      refs.forEach(r=>{
        html += `<div>${escapeHtml(r.nome)} — <span class="text-muted">${escapeHtml(r.contato)}</span></div>`;
      });
      html += `</div>`;
    }

    previewContent.innerHTML = html;
    previewArea.style.display = 'block';
    previewArea.scrollIntoView({behavior:'smooth'});
  });

  printPreview?.addEventListener('click', function(){
    // imprime a área de preview (pode imprimir toda a página)
    window.print();
  });

  function escapeHtml(text) {
    if(!text) return '';
    return text
      .replaceAll('&', '&amp;')
      .replaceAll('<', '&lt;')
      .replaceAll('>', '&gt;')
      .replaceAll('"', '&quot;')
      .replaceAll("'", '&#039;')
      .replaceAll("\n", '<br>');
  }
});