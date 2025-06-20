FROM node:18-alpine as builder

WORKDIR /app

# Primeiro copia apenas os arquivos de dependências
COPY package.json package-lock.json* ./

# Instala as dependências
RUN npm install

# Copia todo o resto do código fonte
COPY . .

# Constrói a aplicação
RUN npm run build

FROM nginx:alpine

# Copia os arquivos construídos para o Nginx
COPY --from=builder /app/dist /usr/share/nginx/html

# Copia a configuração do Nginx
COPY nginx.conf /etc/nginx/conf.d/default.conf

EXPOSE 8080
CMD ["nginx", "-g", "daemon off;"]