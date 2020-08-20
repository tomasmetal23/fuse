FROM postgres:12

ENV POSTGIS_MAJOR 2.5
ENV POSTGIS_VERSION 2.5.5+dfsg-1.pgdg100+1

RUN apt-get update \
      && apt-cache showpkg postgresql-$PG_MAJOR-postgis-$POSTGIS_MAJOR \
      && apt-get install -y --no-install-recommends \
           postgresql-$PG_MAJOR-postgis-$POSTGIS_MAJOR=$POSTGIS_VERSION \
           postgresql-$PG_MAJOR-postgis-$POSTGIS_MAJOR-scripts=$POSTGIS_VERSION \
      && rm -rf /var/lib/apt/lists/*

COPY ["./initdb-postgis.sh", "/docker-entrypoint-initdb.d/postgis.sh"]
COPY ["./update-postgis.sh", "/usr/local/bin"]

EXPOSE 5432

RUN chmod -x ./docker-entrypoint-initdb.d/postgis.sh