# URL Shortener API - Beepay Backend Test

Uma API REST completa desenvolvida em Laravel 11 para encurtar URLs, com dashboard interativo protegido por autenticação e testes automatizados.

## 🚀 Tecnologias Utilizadas

- **PHP 8.3 + PHP-FPM**
- **Laravel 11**
- **Nginx** (Servidor Web)
- **MySQL 8.0**
- **Livewire 3** (Dashboard interativo)
- **TailwindCSS** (Estilização)
- **Docker & Docker Compose**
- **PHPUnit** (Testes automatizados)

## 📋 Funcionalidades

### API REST
- ✅ Criar URLs encurtadas
- ✅ Listar todas as URLs cadastradas
- ✅ Redirecionar para URL original
- ✅ Contador de acessos
- ✅ Rate limiting (60 requisições/minuto por IP)
- ✅ Validação de URLs

### Dashboard Web
- ✅ Interface moderna com Livewire
- ✅ Autenticação de usuário
- ✅ **Formulário para criar URLs encurtadas**
- ✅ **Botão de atualizar com loading**
- ✅ **Copiar URL com um clique**
- ✅ Listagem de URLs com paginação
- ✅ Visualização de estatísticas de acesso
- ✅ Feedback visual com loading states

### Testes
- ✅ Testes unitários
- ✅ Testes de integração
- ✅ Cobertura de funcionalidades principais

## 🐳 Instalação e Execução

### Pré-requisitos
- Docker
- Docker Compose

### Instalação Rápida (Um Comando)

1. **Clone o repositório**
```bash
git clone <repository-url>
cd shortener
```

2. **Inicie tudo com um único comando**
```bash
docker-compose up -d --build
```

**Pronto!** A aplicação estará disponível em alguns segundos.

O comando acima irá automaticamente:
- ✅ Construir a imagem Docker com PHP 8.3-FPM
- ✅ Configurar Nginx como servidor web
- ✅ Iniciar o MySQL 8.0
- ✅ Instalar todas as dependências do Composer
- ✅ Criar o arquivo .env automaticamente
- ✅ Gerar a chave da aplicação
- ✅ Executar as migrations
- ✅ Criar o usuário admin
- ✅ Otimizar a aplicação (cache de config, rotas e views)
- ✅ Iniciar o servidor na porta 8000

### Aguarde a Inicialização

Após executar o comando, aguarde cerca de 30-40 segundos para:
- O MySQL inicializar completamente
- As migrations serem executadas
- O servidor estar pronto

Você pode acompanhar o progresso com:
```bash
docker-compose logs -f app
```

3. **Acesse a aplicação**
- **Dashboard**: http://localhost:8000/dashboard
- **Login**: http://localhost:8000/login
- **API**: http://localhost:8000/api/urls

### Credenciais Padrão
- **Email**: admin@beepayapp.com.br
- **Senha**: admin123456

## 📚 Documentação da API

### Base URL
```
http://localhost:8000/api
```

### Endpoints

#### 1. Criar URL Encurtada

**POST** `/api/urls`

Cria uma nova URL encurtada.

**Request Body:**
```json
{
  "original_url": "https://google.com"
}
```

**Response (201 Created):**
```json
{
  "short_url": "http://localhost:8000/s/abc123",
  "original_url": "https://google.com",
  "short_code": "abc123"
}
```

**Validações:**
- `original_url`: obrigatório, deve ser uma URL válida, máximo 2048 caracteres

**Exemplo com cURL:**
```bash
curl -X POST http://localhost:8000/api/urls \
  -H "Content-Type: application/json" \
  -d '{"original_url": "https://google.com"}'
```

**Exemplo com PowerShell:**
```powershell
Invoke-RestMethod -Uri "http://localhost:8000/api/urls" `
  -Method Post `
  -ContentType "application/json" `
  -Body '{"original_url": "https://google.com"}'
```

---

#### 2. Listar URLs Cadastradas

**GET** `/api/urls`

Retorna todas as URLs encurtadas cadastradas.

**Response (200 OK):**
```json
{
  "data": [
    {
      "id": 1,
      "original_url": "https://google.com",
      "short_url": "http://localhost:8000/s/abc123",
      "short_code": "abc123",
      "access_count": 5,
      "created_at": "2024-01-01T10:00:00Z"
    },
    {
      "id": 2,
      "original_url": "https://github.com",
      "short_url": "http://localhost:8000/s/xyz789",
      "short_code": "xyz789",
      "access_count": 12,
      "created_at": "2024-01-01T11:00:00Z"
    }
  ]
}
```

**Exemplo com cURL:**
```bash
curl http://localhost:8000/api/urls
```

**Exemplo com PowerShell:**
```powershell
Invoke-RestMethod -Uri "http://localhost:8000/api/urls"
```

---

#### 3. Redirecionar para URL Original

**GET** `/s/{code}`

Redireciona para a URL original e incrementa o contador de acessos.

**Parâmetros:**
- `code`: código curto da URL (ex: abc123)

**Response:**
- **302 Redirect**: Redireciona para a URL original
- **404 Not Found**: Código não encontrado

**Exemplo:**
```
http://localhost:8000/s/abc123
```

Ao acessar esta URL no navegador, você será redirecionado para a URL original.

---

### Rate Limiting

Todos os endpoints da API possuem rate limiting de **60 requisições por minuto** baseado no IP de origem.

**Response quando o limite é excedido (429 Too Many Requests):**
```json
{
  "message": "Too Many Attempts."
}
```

---

## 🎨 Dashboard Web

### Acesso
1. Acesse: http://localhost:8000/login
2. Entre com as credenciais:
   - Email: `admin@beepayapp.com.br`
   - Senha: `admin123456`

### Funcionalidades do Dashboard

#### 📝 Criar URLs Encurtadas
- **Formulário integrado** no topo do dashboard
- Digite a URL e clique em "Encurtar"
- **Loading animado** durante o processamento
- **Mensagem de sucesso** com a URL encurtada
- **Botão "Copiar"** para copiar a URL automaticamente
- Validação em tempo real

#### 📊 Visualização de URLs
- Tabela com todas as URLs encurtadas
- **Botão "Atualizar"** com loading spinner
- **Overlay de loading** durante atualizações
- Informações exibidas:
  - URL Original (com truncamento)
  - URL Encurtada (clicável)
  - Quantidade de Acessos (badge colorido)
  - Data de Criação (formato brasileiro)
- Paginação automática (10 itens por página)
- Design responsivo e moderno
- Atualização automática ao criar nova URL

---

## 🧪 Testes Automatizados

### Executar Todos os Testes

```bash
docker-compose exec app php artisan test
```

### Executar Testes Específicos

**Testes de Feature:**
```bash
docker-compose exec app php artisan test --testsuite=Feature
```

**Testes Unitários:**
```bash
docker-compose exec app php artisan test --testsuite=Unit
```

### Cobertura de Testes

Os testes cobrem:
-  Criação de URLs encurtadas
-  Validação de entrada
-  Listagem de URLs
-  Redirecionamento
-  Contador de acessos
-  Rate limiting
-  Autenticação do dashboard
-  Geração de códigos únicos

---

## 🏗️ Arquitetura e Boas Práticas

### Estrutura do Projeto

```
shortener/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Api/
│   │   │   │   └── UrlController.php
│   │   │   ├── Controller.php
│   │   │   └── RedirectController.php
│   │   ├── Requests/
│   │   │   └── CreateUrlRequest.php
│   │   └── Middleware/
│   │       └── Authenticate.php
│   ├── Livewire/
│   │   ├── Dashboard.php (com criação de URLs)
│   │   └── Login.php
│   ├── Models/
│   │   ├── Url.php
│   │   └── User.php
│   └── Providers/
│       └── AppServiceProvider.php
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
│       ├── DatabaseSeeder.php
│       └── UserSeeder.php (com firstOrCreate)
├── nginx/
│   └── default.conf (configuração Nginx)
├── resources/
│   └── views/
│       ├── components/
│       └── livewire/
│           ├── dashboard.blade.php (com formulário)
│           └── login.blade.php
├── routes/
│   ├── api.php
│   ├── web.php
│   └── console.php
├── tests/
│   ├── Feature/
│   │   ├── DashboardTest.php
│   │   └── UrlShortenerTest.php
│   └── Unit/
│       └── UrlModelTest.php
├── docker-compose.yml (3 serviços: app, nginx, db)
├── Dockerfile (PHP 8.3-FPM)
├── docker-entrypoint.sh
└── README.md
```

### Boas Práticas Implementadas

1. **Arquitetura de Produção**
   - **Nginx** como servidor web (não php artisan serve)
   - **PHP-FPM** para processamento PHP
   - Separação de containers (app, nginx, db)
   - Entrypoint script para setup automático

2. **Separação de Responsabilidades**
   - Controllers focados em lógica de requisição/resposta
   - Models com lógica de negócio
   - Form Requests para validação
   - Livewire components para UI interativa

3. **Validação Robusta**
   - Validação de URLs
   - Mensagens de erro personalizadas em português
   - Tratamento de exceções
   - Validação client-side e server-side

4. **Segurança**
   - Rate limiting por IP (60 req/min)
   - Autenticação com hash de senha (bcrypt)
   - CSRF protection
   - Validação de entrada
   - Prevenção de duplicação de usuários

5. **Performance**
   - Índices no banco de dados
   - Códigos curtos únicos e eficientes
   - Cache de config, rotas e views
   - Otimização do autoloader

6. **UX/UI Moderna**
   - Loading states em todas as ações
   - Feedback visual imediato
   - Animações suaves
   - Design responsivo
   - Copiar URL com um clique

7. **Testabilidade**
   - 14 testes automatizados (100% passando)
   - Testes unitários e de integração
   - Factories para dados de teste
   - Ambiente de teste isolado (SQLite in-memory)

8. **Clean Code**
   - Nomenclatura clara e descritiva
   - Métodos pequenos e focados
   - Comentários em pontos-chave
   - PSR-12 code style

---

## 🔧 Comandos Úteis

### Acessar o container
```bash
docker-compose exec app bash
```

### Ver logs
```bash
docker-compose logs -f app
```

### Executar migrations
```bash
docker-compose exec app php artisan migrate
```

### Executar seeders
```bash
docker-compose exec app php artisan db:seed
```

### Limpar cache
```bash
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan route:clear
```

### Parar os containers
```bash
docker-compose down
```

### Parar e remover volumes
```bash
docker-compose down -v
```

---

## 📊 Banco de Dados

### Estrutura da Tabela `urls`

| Campo         | Tipo             | Descrição                    |
|---------------|------------------|------------------------------|
| id            | BIGINT UNSIGNED  | Chave primária               |
| original_url  | TEXT             | URL original                 |
| short_code    | VARCHAR(10)      | Código curto único           |
| access_count  | BIGINT UNSIGNED  | Contador de acessos          |
| created_at    | TIMESTAMP        | Data de criação              |
| updated_at    | TIMESTAMP        | Data de atualização          |

### Índices
- `short_code`: Índice único para busca rápida
- `id`: Chave primária

---

## 🐛 Troubleshooting

### Erro de permissão no storage
```bash
docker-compose exec app chmod -R 777 storage bootstrap/cache
```

### Erro de conexão com banco de dados
Aguarde cerca de 30-40 segundos após o `docker-compose up` para o MySQL inicializar completamente. O script aguarda 10 segundos automaticamente, mas em alguns casos pode precisar de mais tempo.

### Porta 8000 já em uso
Altere a porta no `docker-compose.yml` (serviço nginx):
```yaml
nginx:
  ports:
    - "8080:80"  # Mude 8000 para outra porta
```

### Erro "User already exists" ao reiniciar
Isso é normal! O seeder usa `firstOrCreate` e não tentará criar o usuário novamente.

### Dashboard não carrega
Verifique se todos os containers estão rodando:
```bash
docker-compose ps
```

Verifique os logs:
```bash
docker-compose logs app
docker-compose logs nginx
```

### Reconstruir do zero
Se algo der errado, você pode reconstruir tudo:
```bash
docker-compose down -v
docker-compose up -d --build
```

---

## 📝 Notas Adicionais

### Sobre a Aplicação
- O código curto é gerado aleatoriamente com 6 caracteres alfanuméricos
- Cada código é único no banco de dados
- O contador de acessos é incrementado a cada redirecionamento
- O rate limiting é aplicado apenas nas rotas da API
- O dashboard utiliza Livewire para reatividade sem JavaScript adicional

### Sobre a Infraestrutura
- **Nginx** roda na porta 80 dentro do container, mapeada para 8000 no host
- **PHP-FPM** roda na porta 9000 (comunicação interna entre containers)
- **MySQL** roda na porta 3306 (exposta para debug se necessário)
- Todos os containers estão na mesma rede Docker para comunicação

### Testes
- Todos os 14 testes estão passando 
- Cobertura: API, Dashboard, Models, Autenticação
- Ambiente de teste usa SQLite in-memory (mais rápido)
- Testes podem ser executados sem afetar o banco de dados de desenvolvimento

---

## 📄 Licença

MIT License

---
