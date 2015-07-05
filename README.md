# Deployer

CLI tool for deployment on remote servers

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
# Run before any destination (optional)
before:
    - ./vendor/bin/phpspec run
    - notify-send "Preparing to deploy"

production:
    type: ssh
    host: hostname
    commands:
        - cd path/to/app && git fetch origin
        - cd path/to/app && git reset --hard origin/master

    # Run after any successful deploy to destination (optional)
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
