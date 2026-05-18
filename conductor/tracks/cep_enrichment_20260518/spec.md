# Specification: Implementar Enriquecimento de Dados via CEP

## Objective
Implement a CLI tool to automatically enrich customer address data using external APIs (ViaCEP and ReceitaWS) without overwriting existing data.

## Requirements
- Identify customers with incomplete address fields.
- Use ViaCEP when CEP is available.
- Use ReceitaWS when CNPJ is available but CEP is missing.
- Trigger geocoding after enrichment.
- Adhere to the "only fill if empty" rule.
