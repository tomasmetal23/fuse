FROM node:12.16.1-buster

COPY ["package.json", "package-lock.json", "/app/"]

WORKDIR /app

RUN npm install -g @angular/cli

RUN npm install

COPY [".", "/app/"]

EXPOSE 3000

CMD ["ng", "serve"]