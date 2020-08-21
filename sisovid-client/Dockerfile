FROM node:12.16.1-buster

COPY ["package.json", "/app/"]

WORKDIR /app

RUN npm install -g @angular/cli

RUN npm install

COPY [".", "/app/"]

EXPOSE 4200

CMD ["npm", "start"]