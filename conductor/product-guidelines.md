# Product Guidelines: Map-OS

## Voice and Tone
- **Profissional e Objetivo:** Communication should be direct, efficient, and helpful. Avoid fluff. Technical assistance is a high-pressure environment; the system should facilitate speed, not hinder it.
- **Bilingual Context:** While the primary UI is in Portuguese (PT-BR), the codebase, comments, and internal documentation follow standard English software engineering conventions.

## Visual Identity & Branding
- **Matrix-Admin Modernizado:** We respect the legacy Matrix-Admin theme but aim to modernize it by removing bloat and improving whitespace.
- **Clareza e Contraste:** Critical information (OS Status, Financial Balances) must be highly visible with high-contrast color coding (e.g., Red for Overdue, Green for Finalized).
- **Visualização de Dados Eficiente:** Dashboards should prioritize actionable data using charts (Flot/Chart.js) that provide immediate business health insights.

## UX Design Principles
- **Eficiência de Fluxo (Low Click):** Common tasks like "Add Item to OS" or "Change OS Status" must be achievable with minimal clicks. Modal-driven interactions are preferred over full-page reloads for secondary actions.
- **Feedback Instantâneo:** Every user action (save, delete, update) must trigger a clear visual confirmation (e.g., SweetAlert or Gritter notifications).
- **Mobile-First para Técnicos de Campo:** The OS management and checklist features must be fully responsive to allow field technicians to update status on-site.

## Documentation Standards
- **Arquitetural e Técnico:** Documentation focuses on "how things are built" and "why they were built this way."
- **Standardized Comments:** Every controller and model method must have a DocBlock explaining its purpose, parameters, and return types.
- **Track-Based Updates:** All major changes must be reflected in the `historico_implementacoes.md` and appropriate `conductor/` track plans.
