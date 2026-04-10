# matheusquirino.com — Portfólio Full-Stack

Portfólio pessoal com frontend estático em **Next.js 16** e backend em **Laravel 12**, servidos na mesma hospedagem. O painel administrativo é construído com **Filament v3** e o banco de dados é **SQLite**.

---

## Stack

| Camada | Tecnologia |
|---|---|
| Frontend | Next.js 16 (static export), Tailwind CSS v4, shadcn/ui |
| Backend / API | Laravel 12 (PHP 8.2+) |
| Banco de dados | SQLite |
| Admin panel | Filament v3 |
| Gerenciador de pacotes JS | pnpm |
| Gerenciador de pacotes PHP | Composer 2 |

---

## Estrutura de diretórios

```
matheusquirino.com/          ← raiz Laravel
├── app/
│   ├── Filament/
│   │   ├── Pages/           ← SEO, Sitemap, Configurações do site
│   │   ├── Resources/       ← Projects, Stacks (CRUD)
│   │   └── Widgets/         ← Dashboard stats + gráfico de acessos
│   ├── Http/
│   │   ├── Controllers/Api/ ← ProjectController, SiteConfigController, ContactController
│   │   └── Middleware/      ← TrackPageView
│   └── Models/              ← Project, Stack, Setting, PageView, User
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── database.sqlite      ← banco de dados SQLite
├── frontend/                ← projeto Next.js
│   ├── app/
│   ├── components/
│   ├── hooks/
│   │   └── use-site-config.ts  ← hook que busca settings do Laravel
│   ├── lib/
│   ├── public/
│   ├── next.config.mjs      ← output: export, basePath: /frontend
│   ├── package.json         ← postbuild copia out/ → ../public/frontend/
│   └── copy-build.js        ← script de cópia pós-build
├── public/
│   ├── frontend/            ← build estático do Next.js (gerado pelo build)
│   ├── storage/             ← symlink → storage/app/public
│   └── .htaccess            ← configuração Apache
├── routes/
│   ├── api.php              ← /api/projects, /api/site-config, /api/contact
│   └── web.php              ← serve o frontend estático + rastreamento
└── storage/
    └── app/public/
        ├── seo/             ← imagens OG e Twitter
        ├── profile/         ← foto de perfil
        └── projects/        ← imagens e anexos dos projetos
```

---

## Configuração local (desenvolvimento)

### Pré-requisitos

- PHP 8.2+ com extensões: `ext-intl`, `ext-sqlite3`, `ext-zip`, `ext-pdo`
- Composer 2.x
- Node.js 18+ e pnpm

### 1. Clonar e instalar dependências PHP

```bash
git clone <repo-url> matheusquirino.com
cd matheusquirino.com
composer install
```

### 2. Configurar variáveis de ambiente

```bash
cp .env.example .env
php artisan key:generate
```

Editar `.env` conforme necessário (o SQLite já vem configurado por padrão):

```env
APP_NAME="Matheus Quirino"
APP_URL=http://127.0.0.1:8000
DB_CONNECTION=sqlite
```

### 3. Criar e popular o banco de dados

```bash
php artisan migrate
php artisan db:seed
```

Isso cria:
- Usuário admin (`admin@admin.com` / `admin`)
- 4 projetos de exemplo
- 12 stacks de tecnologia
- Todas as configurações padrão do site

### 4. Criar link simbólico do storage

```bash
php artisan storage:link
```

### 5. Instalar dependências do frontend e fazer o build

```bash
cd frontend
pnpm install
pnpm build
cd ..
```

O comando `pnpm build` executa automaticamente o `postbuild` que copia os arquivos de `frontend/out/` para `public/frontend/`.

### 6. Iniciar o servidor de desenvolvimento

```bash
php artisan serve
```

Acesse:
- **Site**: http://127.0.0.1:8000 → redireciona para http://127.0.0.1:8000/frontend
- **Admin**: http://127.0.0.1:8000/admin
- **API**: http://127.0.0.1:8000/api/projects

---

## Painel Administrativo

| Página | URL | Descrição |
|---|---|---|
| Dashboard | `/admin` | Acessos diários/mensais com gráficos e comparativo |
| Projetos | `/admin/projects` | CRUD com editor rich text, upload de imagem |
| Stacks | `/admin/stacks` | Gerenciar tecnologias do portfólio |
| SEO | `/admin/seo-settings` | Meta tags, OG, Twitter Card, Analytics, JSON-LD |
| Sitemap | `/admin/sitemap-page` | Gerador de sitemap.xml |
| Configurações | `/admin/site-settings` | Cores, textos, contato, redes sociais, SMTP |

**Login:** `admin@admin.com` / **Senha:** `admin`

> ⚠️ Troque a senha imediatamente após o primeiro acesso em produção.

---

## API Endpoints

| Método | Rota | Descrição |
|---|---|---|
| `GET` | `/api/projects` | Listar projetos |
| `POST` | `/api/projects` | Criar projeto |
| `GET` | `/api/projects/{slug}` | Buscar projeto por slug |
| `PUT` | `/api/projects/{slug}` | Atualizar projeto |
| `DELETE` | `/api/projects/{slug}` | Remover projeto |
| `GET` | `/api/site-config` | Configurações públicas (settings + stacks) |
| `POST` | `/api/contact` | Enviar mensagem de contato (usa SMTP configurado) |

---

## Deploy em hospedagem compartilhada (Apache/cPanel)

### Requisitos do servidor

- PHP 8.2+ com: `intl`, `sqlite3`, `pdo_sqlite`, `zip`, `mbstring`, `openssl`, `tokenizer`, `bcmath`
- Composer disponível via SSH
- Acesso SSH

### Passo a passo

#### 1. Fazer upload dos arquivos

Faça upload de todos os arquivos para o diretório do domínio (ex: `public_html/` ou pasta do subdomínio), **exceto**:
- `frontend/node_modules/`
- `vendor/` (será instalado via Composer no servidor)

#### 2. Instalar dependências PHP no servidor

```bash
composer install --optimize-autoloader --no-dev
```

#### 3. Configurar o `.env` para produção

```bash
cp .env.example .env
```

Editar `.env`:

```env
APP_NAME="Matheus Quirino"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://seudominio.com

DB_CONNECTION=sqlite
# DB_DATABASE=database/database.sqlite  ← caminho padrão, já funciona
```

#### 4. Gerar a chave da aplicação

```bash
php artisan key:generate
```

#### 5. Executar migrations e seeders

```bash
php artisan migrate --force
php artisan db:seed --force
```

#### 6. Criar o link simbólico do storage

```bash
php artisan storage:link
```

> Se o cPanel não suportar symlinks via `artisan`, crie manualmente:
> `public/storage` → `storage/app/public`

#### 7. Apontar o DocumentRoot para a pasta `public/`

No cPanel, configure o domínio para apontar para `public/` (não para a raiz do projeto). Isso é feito em:
- **cPanel → Domínios → Document Root**: defina como `public_html/public` ou use subdomínio.

Alternativamente, adicione um `.htaccess` na raiz do domínio redirecionando para `public/`:

```apache
RewriteEngine On
RewriteRule ^(.*)$ public/$1 [L]
```

#### 8. Permissões de diretórios

```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

#### 9. Fazer o build do frontend (se pnpm disponível no servidor)

```bash
cd frontend
pnpm install --frozen-lockfile
pnpm build
```

Caso pnpm não esteja disponível, **faça o build localmente** e faça upload da pasta `public/frontend/` gerada.

#### 10. Otimizações para produção

```bash
php artisan optimize
php artisan view:cache
php artisan route:cache
php artisan config:cache
php artisan event:cache
```

---

## Comandos úteis de referência

| Comando | Descrição |
|---|---|
| `php artisan serve` | Servidor de desenvolvimento |
| `php artisan migrate` | Executar migrations pendentes |
| `php artisan migrate:fresh --seed` | Recriar banco do zero com seeders |
| `php artisan db:seed` | Popular banco com dados padrão |
| `php artisan storage:link` | Criar symlink public/storage |
| `php artisan optimize:clear` | Limpar todos os caches |
| `php artisan optimize` | Recompilar todos os caches |
| `php artisan route:list` | Listar todas as rotas |
| `cd frontend && pnpm build` | Build do Next.js + cópia para public/frontend |
| `cd frontend && pnpm dev` | Dev server do Next.js (porta 3000) |

---

## Configuração do SMTP (formulário de contato)

O formulário de contato do site envia e-mails via Laravel, usando as configurações salvas no painel admin em **Configurações → SMTP**.

Exemplo com Gmail:

| Campo | Valor |
|---|---|
| Host | `smtp.gmail.com` |
| Porta | `587` |
| Usuário | `seuemail@gmail.com` |
| Senha | Senha de app ([gerar aqui](https://myaccount.google.com/apppasswords)) |
| Criptografia | `tls` |
| Nome de envio | `Matheus Quirino` |

> Para Gmail, é necessário usar uma **Senha de Aplicativo** (não a senha normal da conta).

---

## Build do frontend após mudanças

Sempre que alterar arquivos dentro de `frontend/`, faça o rebuild:

```bash
cd frontend
pnpm build
```

O script `copy-build.js` (executado automaticamente no `postbuild`) limpa `public/frontend/` e copia os novos arquivos.

**Não é necessário rebuildar** para mudanças feitas no painel admin (textos, cores, projetos, etc.) — essas são carregadas dinamicamente via `/api/site-config`.

---

## Estrutura das Settings (banco de dados)

| Grupo | Chaves principais |
|---|---|
| `general` | `site.logo_text`, `site.hero_name`, `site.hero_title`, `site.hero_description`, `site.profile_photo` |
| `contact` | `contact.email`, `contact.phone`, `contact.location` |
| `social` | `social.github`, `social.linkedin`, `social.email` |
| `colors` | `colors.primary`, `colors.secondary`, `colors.accent`, `colors.background`, `colors.surface`, `colors.text` |
| `seo` | `seo.home_title`, `seo.home_description`, `seo.og_image`, `seo.twitter_card`, `seo.google_analytics`, `seo.schema_name`, ... |
| `smtp` | `smtp.host`, `smtp.port`, `smtp.username`, `smtp.password`, `smtp.encryption` |

---

## Segurança em produção

- [ ] Trocar senha do admin (`admin@admin.com`) no painel ou via `php artisan tinker`
- [ ] Definir `APP_DEBUG=false` no `.env`
- [ ] Definir `APP_ENV=production` no `.env`
- [ ] Usar HTTPS (certificado SSL)
- [ ] Restringir permissões do arquivo `database/database.sqlite` (chmod 640)
- [ ] Não expor o `.env` publicamente (verificar `.htaccess`)
- [ ] Configurar backup automático do SQLite

---

## Licença

Uso pessoal. Todos os direitos reservados — Matheus Quirino.
