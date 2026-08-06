# Roteiro de Testes — Sistema de Precificação NUPSC
**Ambiente:** homologação (precificacaotreina.df.senai.br)
**Baseado em:** demonstração do sistema (04/08/2026)
**Objetivo:** achar bugs funcionais + vulnerabilidades básicas (pentest autorizado)

Marque cada caso como ✅ Passou / ❌ Falhou / ⚠️ Comportamento estranho (anote print + passos).

---

## Como testar (lembrete rápido)

Todo caso de teste tem 3 partes:
1. **Passos** — o que você clica/preenche
2. **Esperado** — o que deveria acontecer
3. **Real** — o que aconteceu de fato

---

## Módulo 1 — Plano de Curso

| # | Caso | Esperado |
|---|------|----------|
| 1.1 | Abrir a tela e ver a lista de planos puxados do SIG | Lista carrega, sem erro |
| 1.2 | Selecionar um plano que **não precisa** de insumos | Sistema não força cadastro de insumo |
| 1.3 | Selecionar um plano que precisa de insumos (ex: técnico) | Abre tela de gestão de insumos |
| 1.4 | Buscar insumo pelo campo de pesquisa (integração MXM) | Confirmar se ainda está com bug (não estava puxando na demo) |
| 1.5 | Adicionar insumo com quantidade e ver cálculo do valor | Valor unitário vem do MXM e multiplica certo |
| 1.6 | Clicar em **"Salvar lista"** | Mantém editável depois |
| 1.7 | Clicar em **"Enviar para precificação"** | Bloqueia edição depois — tentar editar de novo pra confirmar que não deixa |
| 1.8 | Clicar no ícone de "olho" (timeline) | Mostra status: DEP → Compras → Precificação corretamente |
| 1.9 | Verificar cálculo da "média" (valor hora-aula) | Bate com o cruzamento SIG + RH dos últimos 12 meses |
| 1.10 | Botões de sincronizar (só perfil admin) | Só aparecem/funcionam pra admin — testar com outro perfil |

---

## Módulo 2 — Gestão de Insumos

| # | Caso | Esperado |
|---|------|----------|
| 2.1 | Cadastrar novo insumo manual (empresa, URL, valor, data cotação) | Salva e fica disponível pra lista básica |
| 2.2 | Deixar campo obrigatório em branco (ex: valor) | Dá erro claro, não salva "quebrado" |
| 2.3 | Colar uma URL inválida no campo de link | Ver se valida ou aceita qualquer string |
| 2.4 | Editar um insumo que **já foi usado** numa cotação/plano | Confirmar regra: alterar valor não deveria afetar precificação já feita |
| 2.5 | Excluir insumo já usado em movimentação | Ver se bloqueia ou deixa (checar se gera inconsistência) |
| 2.6 | Filtrar/pesquisar/exportar a lista de insumos | Funciona sem erro |
| 2.7 | Buscar serviço no MXM por código | Traz o serviço certo e adiciona à lista isolada |
| 2.8 | Botão de sincronizar geral com MXM | Confirmar se ainda dá "sucesso" mas não traz nada (bug relatado na demo) |

---

## Módulo 3 — Solicitação de Insumo (DEP → Compras)

| # | Caso | Esperado |
|---|------|----------|
| 3.1 | Preencher formulário de solicitação (o quê + motivo) | Salva e aparece pro perfil Compras |
| 3.2 | Enviar formulário vazio/incompleto | Valida campos obrigatórios |
| 3.3 | Logar como perfil Compras e ver se a solicitação chegou | Aparece na fila de cotação |

---

## Módulo 4 — Fila de Cotação (perfil Compras)

| # | Caso | Esperado |
|---|------|----------|
| 4.1 | Ver "itens pendentes" (faltando preço/código MXM) | Lista correta dos itens com dado faltando |
| 4.2 | Ver "itens vencidos" (cotação com +365 dias) | Aparecem os itens realmente vencidos |
| 4.3 | Ver "itens solicitados" (vindos da DEP) | Bate com o que foi enviado no módulo 3 |
| 4.4 | Enviar 1 item pro MXM (checkbox único) | Processa e retorna status |
| 4.5 | Enviar **todos** de uma vez | Processa em lote sem travar |
| 4.6 | Forçar erro (ex: item com dado incompleto) e ver mensagem retornada | Mensagem de erro aparece, mesmo que "melhorável" |

---

## Módulo 5 — Precificação

| # | Caso | Esperado |
|---|------|----------|
| 5.1 | Selecionar um plano com status "pronto pra precificação" | Abre pré-cálculo automático |
| 5.2 | Alterar quantidade de alunos (padrão 30) | Recalcula o valor por aluno corretamente |
| 5.3 | Editar incidências manualmente (ex: IPCA) | Aceita edição manual mesmo vindo automático |
| 5.4 | Conferir fórmula final: (mão de obra direta + indireta) | Bate com a lógica da planilha original |
| 5.5 | Concluir precificação | Muda status "precificando" → "concluída" |
| 5.6 | Gerar PDF | Gera certo, com todos os valores, pronto pra importar no SEI |
| 5.7 | Filtrar planos por status | Filtro funciona, não quebra a lista |

---

## Módulo 6 — Auditoria

| # | Caso | Esperado |
|---|------|----------|
| 6.1 | Fazer uma ação (ex: mudar status) e checar se aparece no log | Log registra corretamente (de/para) |
| 6.2 | Pesquisar/filtrar na auditoria | Encontra o registro certo |

---

## Módulo 7 — Administração

| # | Caso | Esperado |
|---|------|----------|
| 7.1 | Criar novo usuário | Salva e permite login |
| 7.2 | Ativar/desativar usuário | Usuário desativado não consegue logar |
| 7.3 | Testar matriz de permissões: dar/tirar permissão de um perfil | Perfil sem permissão não vê/faz a ação no sistema |
| 7.4 | Alterar parâmetro global (ex: IPCA) e gerar nova precificação | Novo valor é aplicado na nova precificação, sem afetar as antigas |
| 7.5 | Trocar senha no primeiro acesso | Sistema exige e aceita a troca |

---

## Teste exploratório (sugerido pelo Felipe na reunião)

Ideia: tentar "quebrar" a aplicação com dados fora do esperado.

- [ ] Campo numérico (quantidade, valor): colocar número gigante (ex: 200000000)
- [ ] Campo de texto (nome do insumo, empresa): colar texto enorme (500+ caracteres)
- [ ] Campo de valor: tentar letras, negativo, zero
- [ ] Campo de URL: colar algo que não é URL
- [ ] Deixar campos obrigatórios vazios em todos os formulários
- [ ] Duplo clique rápido em botões de salvar/enviar (evita duplicar registro?)
- [ ] Voltar o navegador (botão "voltar") no meio de um fluxo e ver se quebra o estado

---

## Checklist de segurança básica (nível iniciante)

Como o pentest foi autorizado formalmente, dá pra ir além do funcional — mas comece pelo básico, sem ferramenta pesada.

### Controle de acesso entre perfis
- [ ] Logar com perfil "fraco" (ex: DEP) e tentar acessar telas exclusivas de outro perfil (ex: Compras, Admin) **digitando a URL direto** (não só pelo menu)
- [ ] Ver se o backend também bloqueia (não só esconde o botão no front)
- [ ] Um usuário consegue ver/editar dados de outro que não deveria?

### Autenticação e senha
- [ ] O sistema realmente força trocar a senha padrão no primeiro login?
- [ ] Dá pra colocar senha fraca (ex: "1234") na troca? Deveria ter regra mínima
- [ ] Tem limite de tentativas de login (proteção contra força bruta)?
- [ ] A sessão expira depois de um tempo parado?

### Validação de entrada (Injeção / XSS básico)
- [ ] Em campos de texto (nome do insumo, empresa, motivo da solicitação), colar algo como `<script>alert(1)</script>` e ver se aparece um popup ao reabrir a tela (se aparecer = vulnerabilidade de XSS)
- [ ] Em campos de busca/filtro, colar caracteres especiais (`' OR '1'='1`, `--`, `;`) e ver se o sistema quebra ou retorna erro de banco na tela (sinal de possível SQL injection — não precisa ir além disso, só reportar)

### Exposição de dados
- [ ] Erros do sistema mostram detalhes técnicos demais (stack trace, nome de tabela, query SQL) pro usuário comum?
- [ ] O PDF gerado ou export tem algum dado que não deveria estar visível pro perfil que gerou?

### Geral
- [ ] Testar em navegadores diferentes (Chrome, Firefox, Edge) — mesmo comportamento?
- [ ] Testar responsividade em tablet (já é sabido que não é responsivo em celular — reportar apenas se quebrar feio)

---

## Como reportar cada achado

Pra cada ❌ ou ⚠️:
1. Módulo e número do caso
2. Passo a passo pra reproduzir
3. O que era esperado x o que aconteceu
4. Print/vídeo se possível
5. Perfil usado no teste (Admin, DEP, Compras, etc.)
