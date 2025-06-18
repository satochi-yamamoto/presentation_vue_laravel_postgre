# Site de apresentação Alexandre Yamamoto

Este projeto utiliza Vue.js + Laravel + Postgresql, e os dados serão armazenados em um banco Postgree, com API em Laravel e Front Vue.js

Será estruturado em Containers com gerenciamento web do Traefik

## 🚀 Em Inicio de projeto - Breve finalizado

## 🏗️ Estrutura do Projeto

```bash
alex-yamamoto-portfolio/
├── backend/              # Laravel API
│   ├── app/
│   ├── config/
│   ├── database/
│   ├── routes/
│   └── ...
├── frontend/             # Vue.js SPA
│   ├── public/
│   ├── src/
│   │   ├── assets/
│   │   ├── components/
│   │   ├── router/
│   │   ├── views/
│   │   └── ...
│   └── ...
└── README.md
```

## Fluxo de Acesso
Acesso principal: https://laravel.satochi.com.br

Frontend Vue.js

Todas as requisições para /api serão direcionadas para o backend

API diretamente: https://api.laravel.satochi.com.br

Backend Laravel

Acesso direto à API RESTful

Dashboard Traefik: http://laravel.satochi.com.br:8080 (protegido)

Monitoramento e gerenciamento do proxy reverso

Acesso ao banco de dados é restrito a API, bloqueado pelo Traefik permitindo somente o acesso do Container do Laravel.
