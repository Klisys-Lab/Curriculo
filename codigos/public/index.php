<?php
// public/index.php
// Exibe o formulário (HTML "escapado" em PHP)
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Construtor de Currículo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="/assets/css/style.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-5">
    <div class="card shadow-sm">
      <div class="card-body">
        <h2 class="card-title mb-4">Criar Currículo</h2>
        <form id="cvForm" action="/public/gerar.php" method="post" target="_blank">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Nome completo</label>
              <input name="nome" type="text" class="form-control" required>
            </div>
            <div class="col-md-3">
              <label class="form-label">Data de nascimento</label>
              <input id="data_nascimento" name="data_nascimento" type="date" class="form-control" required>
            </div>
            <div class="col-md-3">
              <label class="form-label">Idade</label>
              <input id="idade" name="idade" type="number" class="form-control" readonly>
            </div>

            <div class="col-12">
              <label class="form-label">Resumo profissional</label>
              <textarea name="resumo" class="form-control" rows="3"></textarea>
            </div>

            <div class="col-12">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <label class="form-label mb-0">Experiências profissionais</label>
                <button id="addExperience" type="button" class="btn btn-sm btn-outline-primary">+ adicionar</button>
              </div>
              <div id="experiencesList">
                <!-- templates de experiência serão inseridos aqui via JS -->
              </div>
            </div>

            <div class="col-12">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <label class="form-label mb-0">Referências pessoais</label>
                <button id="addReference" type="button" class="btn btn-sm btn-outline-primary">+ adicionar</button>
              </div>
              <div id="referencesList"></div>
            </div>

            <div class="col-12">
              <label class="form-label">Habilidades (separadas por vírgula)</label>
              <input name="habilidades" type="text" class="form-control" placeholder="Ex.: PHP, JavaScript, Git">
            </div>

            <div class="col-12 d-flex gap-2">
              <button id="previewBtn" type="button" class="btn btn-secondary">Pré-visualizar</button>
              <button type="submit" class="btn btn-primary">Gerar currículo (nova aba)</button>
            </div>
          </div>
        </form>

        <hr class="my-4">

        <div id="previewArea" class="border p-3 bg-white" style="display:none;">
          <h4 class="mb-3">Pré-visualização</h4>
          <div id="previewContent"></div>
          <div class="mt-3">
            <button id="printPreview" class="btn btn-success">Baixar / Imprimir</button>
          </div>
        </div>

      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="/assets/js/app.js"></script>
</body>
</html>