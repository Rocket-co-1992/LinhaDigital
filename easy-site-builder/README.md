# Easy Site Builder

## Objetivo
O Easy Site Builder é uma plataforma projetada para pequenos empreendedores, freelancers, agências e PMEs, permitindo a criação de websites de forma fácil e intuitiva. O sistema é construído com PHP, Symfony, Twig, MySQL e Tailwind CSS, e é compatível com alojamento web partilhado tradicional.

## Requisitos de Alojamento Partilhado
- PHP 8 ou superior
- MySQL ou MariaDB
- Suporte para Composer
- Acesso ao painel cPanel para configuração de cron jobs e upload via FTP/SFTP

## Setup Local
### Pré-requisitos
- Docker e Docker Compose instalados
- Composer instalado
- Node.js e npm instalados

### Instruções
1. Clone o repositório:
   ```
   git clone https://github.com/seu-usuario/easy-site-builder.git
   cd easy-site-builder
   ```

2. Configure o ambiente:
   - Renomeie o arquivo `.env.dist` para `.env` e ajuste as variáveis conforme necessário.

3. Instale as dependências do backend:
   ```
   cd backend
   composer install
   ```

4. Instale as dependências do frontend:
   ```
   cd ../assets
   npm install
   ```

5. Compile os assets:
   ```
   npm run build
   ```

6. Inicie o ambiente de desenvolvimento com Docker:
   ```
   docker-compose up -d
   ```

## Build de Assets e Upload por FTP
Após compilar os assets, você deve enviar as pastas `vendor/` e `build/` para o seu servidor via FTP/SFTP. Certifique-se de que a estrutura de diretórios no servidor corresponda à estrutura local.

## Configuração de .htaccess
O arquivo `.htaccess` em `backend/public/` deve ser configurado para permitir a reescrita de URLs:
```apache
<IfModule mod_rewrite.c>
  RewriteEngine On
  RewriteCond %{REQUEST_FILENAME} !-f
  RewriteRule ^ index.php [QSA,L]
</IfModule>
```

## Cron Jobs
Para configurar tarefas cron no cPanel, adicione o seguinte comando:
```
0 * * * * php /home/usuario/easy-site-builder/backend/bin/console app:expire-demos
```
Adicione outros comandos de limpeza ou notificações conforme necessário.

## Como Criar Demo e Publicar Sites
Para criar uma nova demo, utilize o painel de administração para configurar um novo site e gerar um subdomínio no formato `*.demo.seudominio.com`. As demos podem ser renovadas ou expiradas automaticamente através de cron jobs.

## Contribuições
Contribuições são bem-vindas! Sinta-se à vontade para abrir issues ou pull requests.

## Licença
Este projeto está licenciado sob a MIT License. Veja o arquivo LICENSE para mais detalhes.