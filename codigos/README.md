Projeto: Construtor de Currículos simples (frontend em HTML/CSS/JS com Bootstrap; backend em PHP). Objetivo: permitir que o usuário preencha dados pessoais, adicione experiências e referências dinamicamente, visualizar e gerar um currículo imprimível/baixável em PDF via navegador.

Estrutura de diretórios (visão rápida)
- assets/ — arquivos estáticos
- css/style.css — estilos customizados leves
- js/app.js — lógica de interação e manipulação do formulário (idade, adicionar/remover campos, preview, imprimir)
- img/ — imagens/ícones (opcional)
- public/ — ponto de entrada (document root)
- index.php — formulário de criação do currículo; usa Bootstrap; HTML gerado/embutido via PHP; envia POST para gerar.php; fornece preview cliente
- gerar.php — recebe POST, formata e escapa os dados em HTML pronto para impressão/PDF
- src/ (opcional) — templates ou códigos auxiliares
- vendor/ (opcional) — dependências externas se usadas
- README.md — este arquivo com resumo e instruções

Resumo dos arquivos principais
- public/index.php
- Renderiza o formulário de entrada com campos: nome, data de nascimento, idade (somente leitura), resumo, habilidades.
- Contém áreas dinâmicas para Experiências Profissionais e Referências Pessoais onde o usuário adiciona múltiplos blocos.
- Botões principais: Pré-visualizar, Gerar currículo (abre nova aba).
- Carrega Bootstrap via CDN e o arquivo JS/CSS locais.
- public/gerar.php
- Recebe dados via POST.
- Função utilitária e() para escapar strings (htmlspecialchars).
- Processa arrays de experiências e referências, aplica nl2br quando necessário, monta HTML final do currículo.
- Inclui botão que chama window.print() para imprimir ou salvar como PDF pelo navegador.
- Aplica estilos inline básicos para garantir boa impressão.
- assets/js/app.js
- Calcula automaticamente a idade a partir de data de nascimento (ouve change).
- Funções para adicionar/remover blocos de experiência e referência dinamicamente (inserção DOM).
- Gera uma pré-visualização no cliente montando um HTML simplificado com os dados do formulário.
- Função escapeHtml para sanitizar conteúdo exibido na pré-visualização.
- Handler que aciona window.print() quando o usuário deseja baixar o currículo.
- assets/css/style.css
- Estilos mínimos para fundo, cartões e área de preview.
- Mantém aparência limpa e leve sobre Bootstrap.

Como executar localmente (passos essenciais)
- Coloque a pasta do projeto em um servidor com PHP (ex.: Apache, Nginx + PHP-FPM) ou use um servidor PHP embutido:
- Na raiz do projeto (onde está public/): php -S localhost:8000 -t public
- Acesse http://localhost:8000 (ou porta configurada).
- Preencha o formulário em index.php, adicione experiências/referências via botão “+”, clique em Gerar currículo para abrir o resultado em nova aba e usar Imprimir / Salvar como PDF.

Observações técnicas e recomendações
- Segurança: já existe escaping básico em gerar.php; adicionar validações servidor-side, sanitização mais robusta e proteção CSRF antes de produção.
- Persistência: atualmente os dados são enviados via POST e não são salvos; para salvar currículos, integrar banco de dados (MySQL) e endpoints CRUD.
- Templates: adicionar múltiplos templates HTML/CSS em src/templates e permitir seleção no index.php.
- Geração de PDF no servidor: para controle total do layout de PDF, integrar biblioteca como DOMPDF ou wkhtmltopdf.
- Acessibilidade e impressão: gerar.php já inclui regras para ocultar elementos não imprimíveis (classe .no-print); testar que o PDF resultante mantenha estrutura sem imagens rompidas.


