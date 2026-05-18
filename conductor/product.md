# Initial Concept
Map-OS is an open-source management system for service assistance and workshops.

# Product Definition: Map-OS

## Vision
Map-OS is an open-source management system designed to empower technical assistance workshops, service providers, and small businesses. Our mission is to streamline operational processes, provide comprehensive financial control, and maintain a simple, accessible interface that remains free for the community.

## Target Audience
- **Assistências Técnicas & Oficinas:** Specialized workshops for automotive, electronics, and appliance repair.
- **Prestadores de Serviços:** Independent technicians like electricians, plumbers, and HVAC specialists.
- **Pequenas Empresas:** Small businesses requiring structured control over service orders, inventory, and clients.

## Core Value Proposition
- **Operational Optimization:** Centralized management of service orders (OS), customers, and products to eliminate paperwork and human error.
- **Financial Empowerment:** Integrated billing, multi-gateway payment support (PIX, Boleto), and real-time financial tracking.
- **Fiscal Compliance:** Built-in support for NF-e, NFC-e, and NFS-e (gov.br) to simplify tax reporting.
- **Community-Driven & Open:** A robust, self-hosted solution that respects user privacy and data ownership under the Apache License.

## Key Features
1. **Service Order Management (OS):** Complete lifecycle tracking from intake to faturamento.
2. **Integrated Billing & Payments:** Support for EFI, Asaas, and Mercado Pago APIs, including automated PIX generation.
3. **Fiscal Module:** Native emission of electronic invoices and integration with gov.br services.
4. **Inventory & Client CRM:** Structured databases for managing stock levels and customer relationships.
5. **Multi-User RBAC:** Role-based access control to ensure team efficiency and data security.

## Strategic Constraints & Principles
- **Legacy Compatibility:** Rigorous adherence to PHP 8.4+ and CodeIgniter 3.1.x architectural patterns.
- **Open Source Integrity:** All core features remain under the Apache License 2.0.
- **Data Security:** Prioritizing SQL injection prevention, input sanitization, and secure audit logs.
- **Simplicity First:** Maintaining the Matrix-Admin theme's usability while modernizing the backend.
