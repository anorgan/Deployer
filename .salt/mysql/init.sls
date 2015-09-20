mysql_setup:
  debconf.set:
    - name: mysql-server
    - data:
        'mysql-server/root_password': {'type': 'string', 'value': '{{ salt["pillar.get"]("mysql:root_password") }}'}
        'mysql-server/root_password_again': {'type': 'string', 'value': '{{ salt["pillar.get"]("mysql:root_password") }}'}

mysql-python:
  pkg.installed:
    - name: python-mysqldb

mysql-server:
  pkg.installed:
    - name: mysql-server
    - require:
      - debconf: mysql_setup

  file.managed:
    - name: /etc/mysql/my.cnf
    - source: salt://mysql/my.cnf
    - user: root
    - group: root
    - mode: 644
    - require:
      - pkg: mysql-server

  service:
    - name: mysql
    - running
    - enable: True
    - restart: True
    - require:
      - pkg: mysql-server
    - watch:
      - pkg: mysql-server
      - file: /etc/mysql/my.cnf

mysql-root-user-remote:
  mysql_user.present:
    - name: root
    - host: '%'
    - password: {{ salt["pillar.get"]("mysql:root_password") }}
    - connection_user: root
    - connection_pass: {{ salt["pillar.get"]("mysql:root_password") }}
    - connection_charset: utf8
    - require:
      - pkg: mysql-python
      - service: mysql-server
  mysql_grants.present:
    - grant: all privileges
    - database: '*.*'
    - user: root
    - host: '%'
    - connection_user: root
    - connection_pass: {{ salt["pillar.get"]("mysql:root_password") }}
    - connection_charset: utf8
    - require:
      - pkg: mysql-python
      - service: mysql-server

# Or if this fails:
# update mysql.user set host=’%’ where user=’root’;
# GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' WITH GRANT OPTION;
# flush privileges;