# Changelog

## 2025-01-02 — Dashboard Keyboard Navigation e Tema (Phase 1)

- Implementada landing page inspirada em newsletters.ai com tema claro/escuro.
- Adicionado seletor de tema (claro/escuro/automático) sincronizado com `flux.appearance`.
- Criado componente `ContentList` com navegação por teclado:
  - `j`/`k` para navegar entre itens
  - `Enter` para abrir conteúdo selecionado
  - `Delete` para excluir
- Dashboard redesenhado com cards de estatísticas (total, publicados, rascunhos).
- Criada página de edição de conteúdo (`content/{id}/edit`) com:
  - Editor limpo com título e corpo
  - Configurações de status, visibilidade e agendamento
  - Atalhos de teclado (`⌘S` para salvar, `Esc` para voltar)
  - Cálculo de tempo de leitura
- Filtros por status (Todos/Publicados/Rascunhos) no dashboard.

## 2025-12-31 — Editor Markdown e Autosave (Phase 1)

- Adicionado componente Livewire `Editor` com preview em tempo real e toolbar básica.
- Implementado autosave com debounce (2s) e indicador visual "Salvando.../Último salvamento".
- Criada migration `contents`, model `Content` e `ContentFactory`.
- Adicionados testes Pest/Livewire: render, preview, save, autosave.
- Atualizado `docs/roadmap.md` marcando "Better markdown editor" e "Autosave drafts" como concluídos.
- Adicionado agendamento no `app/Console/Kernel.php` para executar `contents:publish-scheduled` periodicamente (everyMinute).
- Implementado Notes-first UX: componente `QuickNote`, rota `/notes/new`, view e testes.
