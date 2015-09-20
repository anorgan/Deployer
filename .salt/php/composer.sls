include:
  - php

{%- set pkgphp = pillar['pkgs']['php'] %}
{%- set install_file = pkgphp.local_bin + '/' + pkgphp.composer_bin %}

get-composer:
  file.managed:
    - name: {{ pkgphp.temp_dir }}/installer
    - mode: 0755
    - unless: test -f {{ install_file }}
    - source: https://getcomposer.org/installer
    - source_hash: {{ pkgphp.composer_hash }}
    - require:
      - pkg: php5

install-composer:
  cmd.wait:
    - name: {{ pkgphp.temp_dir }}/installer --filename={{ pkgphp.composer_bin }} --install-dir={{ pkgphp.local_bin }}
    - watch:
      - file: get-composer

# Get COMPOSER_DEV_WARNING_TIME from the installed composer, and if that time has passed
# then it's time to run `composer selfupdate`
#
# It would be nice if composer had a command line switch to get this, but it doesn't,
# and so we just grep for it.
#
update-composer:
  cmd.run:
    - name: "{{ install_file }} selfupdate"
    - unless: test $(grep --text COMPOSER_DEV_WARNING_TIME {{ install_file }} | egrep '^\s*define' | sed -e 's,[^[:digit:]],,g') \> $(php -r 'echo time();')
    - cwd: {{ pkgphp.local_bin }}
    - require:
      - cmd: install-composer