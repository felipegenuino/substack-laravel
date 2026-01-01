# feat(editor): editor Markdown com preview e autosave

Este PR agrupa as mudanças iniciais da Phase 1 — Writing Experience:

## Principais mudanças

- Editor Markdown com preview em tempo real (com fallback) — componente Livewire `Editor`.
- Autosave de rascunhos com debounce (`wire:model.debounce.2000ms`) e indicador visual.
- Agendamento de publicações: campo `publish_at` no editor; conteúdos agendados salvos como `draft` e publicados por comando `contents:publish-scheduled`.
- Scheduler adicionado (`app/Console/Kernel.php`) executando `contents:publish-scheduled` a cada minuto.
- Fluxo Notes‑first: componente Livewire `QuickNote`, rota `/notes/new` e view.

## Testes

- Testes Pest/Livewire adicionados para: renderização do editor, preview, salvar rascunho, autosave, agendamento (save + comando), QuickNote.
- Testes de integração: validação do agendamento no `Kernel` e presença do link no `dashboard`.

## Arquivos importantes

- `app/Http/Livewire/Editor.php`
- `app/Http/Livewire/QuickNote.php`
- `database/migrations/2025_12_31_235959_create_contents_table.php`
- `app/Console/Commands/PublishScheduledContents.php`
- `app/Console/Kernel.php` (scheduler)
- `resources/views/livewire/editor.blade.php`
- `resources/views/livewire/quick-note.blade.php`
- `resources/views/notes/new.blade.php`
- `resources/views/dashboard.blade.php` (atalho 'Nova Note')

## Como testar localmente

```bash
composer install
php artisan migrate
php artisan test
php artisan serve
```

## Notas

- Esta PR é intencionalmente maior — inclui editor + autosave + agendamento + notes-first para manter o fluxo de escrita consistente na base do MVP.
- Se preferir PRs menores, eu posso separar a migration/Editor e as mudanças do scheduler/Notes‑first em PRs separados.
