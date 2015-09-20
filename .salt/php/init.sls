{%- set pkgphp = pillar['pkgs']['php'] %}

include:
  - php.composer

php5.6:
  pkgrepo.managed:
    - ppa: ondrej/php5-5.6
  pkg:
    # - latest # Use this to update
    - installed
    - name: php5
    - refresh: True

php-cli:
  pkg.installed:
    - name: {{ pkgphp.cli_pkg }}

php-curl:
  pkg.installed:
    - name: {{ pkgphp.curl_pkg }}

php-dev:
  pkg.installed:
    - name: {{ pkgphp.dev_pkg }}

php-pdo:
  pkg.installed:
    - name: {{ pkgphp.mysql_pkg }}

php-fpm:
  pkg.installed:
    - name: {{ pkgphp.fpm_pkg }}
  service.running:
    - name: {{ pkgphp.fpm_service }}
    - enable: True

php-intl:
  pkg.installed:
    - name: {{ pkgphp.intl_pkg }}

php-json:
  pkg.installed:
    - name: {{ pkgphp.json_pkg }}

php-mbstring:
  pkg.installed:
    - name: {{ pkgphp.mbstring_pkg }}

php-mcrypt:
  pkg.installed:
    - name: {{ pkgphp.mcrypt_pkg }}

php-ssh2:
  pkg.installed:
    - name: {{ pkgphp.ssh2_pkg }}
