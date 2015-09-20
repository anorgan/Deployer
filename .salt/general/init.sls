hr_HR.UTF-8:
  locale.present

git:
  pkg:
    - installed

mailcatcher-dependencies:
  pkg.installed:
    - names:
      - build-essential
      - ruby-dev
      - libsqlite3-dev

mailcatcher-gem:
  gem.installed:
    - name: mailcatcher
    - require:
      - pkg: mailcatcher-dependencies

mailcatcher-kill_smtp:
  service.dead:
    - name: exim4
    - enable: False

mailcatcher:
  file.managed:
    - name: /etc/init.d/mailcatcher
    - mode: 755
    - source: salt://general/init_d.sh
  service.running:
    - enable: True
    - require:
      - gem: mailcatcher-gem
      - file: mailcatcher
      - service: mailcatcher-kill_smtp

mailcatcher-php:
  file.managed:
    - name: /etc/php5/mods-available/mailcatcher.ini
    - mode: 644
    - contents: 'sendmail_path = /usr/local/bin/catchmail -f test@local.dev --smtp-port 25'
    - require:
      - pkg: php5

    - require_in:
      - service: mailcatcher
      - service: nginx

    - watch_in:
      - service: mailcatcher
      - service: nginx
      - service: php-fpm

  cmd.run:
    - name: php5enmod mailcatcher
    - require:
      - file: mailcatcher-php
