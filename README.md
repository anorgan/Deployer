# Deployer

CLI tool for deployment on remote servers

[![Dependency Status](https://www.versioneye.com/user/projects/5609422e5a262f0022000200/badge.svg?style=flat)](https://www.versioneye.com/user/projects/5609422e5a262f0022000200)

## Instalation

```bash
$ wget http://bit.ly/deployer-cli -O deployer.phar
```

## Usage

```bash
$ php deployer.phar deploy production
```

## Configuration

```bash
$ php deployer.phar init
```

Creates something like:

```yaml
# Environments
production:
  servers:
    app1:
      type: ssh # local or webhook
      host: app1.domain.com
      user: deployer
      path: /var/www/domain.com

  steps:
    Tests:
      commands:
        - bin/phpspec run -fpretty

  success:
    - echo "send email with output"
    - echo "send notification on Slack"

  # Run after any failure to deploy to destination (optional)
  fail:
    - echo "weep"
```

## Requirements

PHP 5.4.0 or above 

## Licence

Deployer is licensed under the MIT License - see the LICENSE file for details
