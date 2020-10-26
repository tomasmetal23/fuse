FROM node:12.16.1-buster as build

COPY ["package.json", "/app/"]

WORKDIR /app

RUN npm install -g @angular/cli

RUN npm install

COPY [".", "/app/"]

RUN npm  --max-old-space-size=1024 run build

FROM nginx:1.17.8-alpine

RUN rm -rf /usr/share/nginx/html/*

COPY --from=build /app/dist /usr/share/nginx/html

COPY default.conf /etc/nginx/conf.d/default.conf
COPY default2.conf /etc/nginx/conf.d/default2.conf

ENTRYPOINT ["nginx", "-g", "daemon off;"]
