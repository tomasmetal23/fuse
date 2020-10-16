FROM node:12.16.1-buster as build

COPY ["package.json", "/app/"]

WORKDIR /app

RUN npm install -g @angular/cli

RUN npm install

COPY [".", "/app/"]

RUN npm run build

FROM nginx:1.17.8-alpine

RUN rm -rf /usr/share/nginx/html/*

COPY --from=build /app/dist /usr/share/nginx/html

COPY ./nginx/nginx.conf /etc/nginx/nginx.conf

ENTRYPOINT ["nginx", "-g", "daemon off;"]

