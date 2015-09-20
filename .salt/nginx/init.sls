kill-apache:
  service.dead:
    - name: {{ pillar['pkgs']['apache'] }}
    - enable: False

nginx:
  pkgrepo:
    - managed
    - name: deb http://nginx.org/packages/ubuntu/ {{ grains['oscodename'] }} nginx
    - key_url: http://nginx.org/keys/nginx_signing.key

  service:
    - running
    - enable: True
    - restart: True
    - watch:
      - pkg: nginx
      - file: /etc/nginx/nginx.conf
      - file: /etc/nginx/conf.d/*

  pkg:
    - installed
    - require:
      - pkgrepo: nginx

/etc/nginx/nginx.conf:
  file:
    - managed
    - source: salt://nginx/nginx.conf.jinja
    - user: root
    - group: root
    - mode: 644
    - template: jinja
    - require:
      - pkg: nginx

/etc/nginx/conf.d/server.conf:
  file:
    - managed
    - source: salt://nginx/server.conf.jinja
    - user: root
    - group: root
    - mode: 644
    - template: jinja
    - require:
      - pkg: nginx