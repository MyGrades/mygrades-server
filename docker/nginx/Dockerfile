FROM nginx:stable

COPY ./site.conf /etc/nginx/conf.d/default.conf

# todo: currently hardcoded uid:gid

RUN touch /var/run/nginx.pid && \
  chown -R 1002:999 /var/run/nginx.pid && \
  chown -R 1002:999 /var/cache/nginx

USER 1002

VOLUME /var/www/html