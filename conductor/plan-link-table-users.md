# Plano de Implementação: Cadastro de Usuário Cliente com Tabela de Vínculo

Este plano descreve a reestruturação do sistema para permitir que um único usuário (login) possa estar vinculado a múltiplos clientes, facilitando a gestão por representantes ou gestores de frotas.

## 1. Alterações no Banco de Dados (Migration)

Criar a migration `20260414100000_create_client_users_system.php`:

- **Tabela `usuarios_clientes`**:
    - `idUsuariosClientes` (INT, PK, AI)
    - `nome` (VARCHAR 255)
    - `email` (VARCHAR 100, UNIQUE)
    - `senha` (VARCHAR 200)
    - `situacao` (TINYINT 1, DEFAULT 1)
    - `dataCadastro` (DATETIME)
- **Tabela `vinculos_usuarios_clientes`**:
    - `idVinculo` (INT, PK, AI)
    - `usuarios_clientes_id` (INT, FK -> usuarios_clientes.idUsuariosClientes)
    - `clientes_id` (INT, FK -> clientes.idClientes)
    - `tipo` (VARCHAR 20, DEFAULT 'admin')

## 2. Novos Models e Ajustes

### 2.1. `Usuarios_clientes_model.php` (Novo)
- Métodos: `getById()`, `getByEmail()`, `add()`, `edit()`, `delete()`, `checkCredentials()`.

### 2.2. `Clientes_model.php` (Ajustes)
- Adicionar métodos para gerenciar vínculos: `addVinculo()`, `removeVinculo()`, `getUsuariosVinculados($cliente_id)`, `getClientesVinculados($usuario_id)`.

## 3. Controller `Clientes.php`

### 3.1. Método `adicionar()`
- Modificar a lógica de persistência:
    - Verificar se o e-mail do cliente já possui um registro em `usuarios_clientes`.
    - Se sim, criar apenas o vínculo na tabela `vinculos_usuarios_clientes`.
    - Se não, criar o registro em `usuarios_clientes` e o vínculo.
    - Manter compatibilidade com a tabela `clientes` (campo senha/email) se necessário, ou migrar gradualmente.

### 3.2. Novo Método `pesquisarUsuariosAjax()`
- Para alimentar o autocomplete na view de adição de cliente.

## 4. Alterações nas Views

### 4.1. `application/views/clientes/adicionarCliente.php`
- Adicionar um campo de busca de usuário (Select2/Autocomplete).
- Lógica de interface: Ao selecionar um usuário existente, os campos de senha são ocultados/desabilitados.

### 4.2. `application/views/clientes/editarCliente.php`
- Adicionar uma aba ou seção "Usuários com Acesso" para gerenciar os vínculos (adicionar/remover outros usuários que podem ver este cliente).

## 5. Fluxo de Autenticação (Portal do Cliente)

- Atualizar o `Login.php` (ou controller responsável pelo portal do cliente) para:
    1. Autenticar contra `usuarios_clientes`.
    2. Verificar quantos clientes estão vinculados.
    3. Se > 1, exibir tela de seleção de cliente.
    4. Definir na sessão qual `cliente_id` está "ativo" no momento.

## 6. Verificação e Testes

- Validar criação de cliente com novo usuário.
- Validar criação de cliente vinculado a usuário existente.
- Validar login no portal com usuário vinculado a múltiplos clientes.
