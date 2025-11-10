<?php
// public/gerar.php
function e($v) {
  return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8');
}

$nome = e($_POST['nome'] ?? '');
$data_nasc = e($_POST['data_nascimento'] ?? '');
$idade = e($_POST['idade'] ?? '');
$resumo = nl2br(e($_POST['resumo'] ?? ''));
$habilidades = e($_POST['habilidades'] ?? '');

// Experiências: enviadas como arrays
$exp_titulo = $_POST['exp_titulo'] ?? [];
$exp_empresa = $_POST['exp_empresa'] ?? [];
$exp_periodo = $_POST['exp_periodo'] ?? [];
$exp_descricao = $_POST['exp_descricao'] ?? [];

// Referências
$ref_nome = $_POST['ref_nome'] ?? [];
$ref_contato = $_POST['ref_contato'] ?? [];

?><!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Currículo de <?php echo $nome; ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body{padding:20px;font-family:Arial,Helvetica,sans-serif;color:#222;}
    .header{display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;}
    .name{font-size:26px;font-weight:700;}
    .section{margin-top:14px;}
    .muted{color:#666;font-size:14px;}
    @media print {
      .no-print{display:none;}
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <div>
        <div class="name"><?php echo $nome; ?></div>
        <div class="muted">Data de nascimento: <?php echo $data_nasc; ?> • Idade: <?php echo $idade; ?></div>
      </div>
      <div class="text-end">
        <div class="muted">Gerado em <?php echo date('d/m/Y'); ?></div>
      </div>
    </div>

    <?php if($resumo): ?>
      <div class="section">
        <h5>Resumo</h5>
        <div><?php echo $resumo; ?></div>
      </div>
    <?php endif; ?>

    <?php if(count($exp_titulo)): ?>
      <div class="section">
        <h5>Experiência profissional</h5>
        <?php for($i=0;$i<count($exp_titulo);$i++): 
          $t = htmlspecialchars($exp_titulo[$i] ?? '', ENT_QUOTES, 'UTF-8');
          $c = htmlspecialchars($exp_empresa[$i] ?? '', ENT_QUOTES, 'UTF-8');
          $p = htmlspecialchars($exp_periodo[$i] ?? '', ENT_QUOTES, 'UTF-8');
          $d = nl2br(htmlspecialchars($exp_descricao[$i] ?? '', ENT_QUOTES, 'UTF-8'));
        ?>
          <div class="mb-3">
            <strong><?php echo $t; ?></strong> — <span class="muted"><?php echo $c; ?> | <?php echo $p; ?></span>
            <div><?php echo $d; ?></div>
          </div>
        <?php endfor; ?>
      </div>
    <?php endif; ?>

    <?php if(trim($habilidades) !== ''): ?>
      <div class="section">
        <h5>Habilidades</h5>
        <div><?php
          $h = array_filter(array_map('trim', explode(',', $habilidades)));
          echo implode(' • ', array_map('htmlspecialchars', $h));
        ?></div>
      </div>
    <?php endif; ?>

    <?php if(count($ref_nome)): ?>
      <div class="section">
        <h5>Referências</h5>
        <?php for($i=0;$i<count($ref_nome);$i++):
          $rn = htmlspecialchars($ref_nome[$i] ?? '', ENT_QUOTES, 'UTF-8');
          $rc = htmlspecialchars($ref_contato[$i] ?? '', ENT_QUOTES, 'UTF-8');
        ?>
          <div class="mb-2"><?php echo $rn; ?> — <span class="muted"><?php echo $rc; ?></span></div>
        <?php endfor; ?>
      </div>
    <?php endif; ?>

    <div class="mt-4 no-print">
      <button onclick="window.print()" class="btn btn-primary">Imprimir / Salvar como PDF</button>
    </div>
  </div>
</body>
</html>