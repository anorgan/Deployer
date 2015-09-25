# TODO

$ deployer deploy [production] [commit|branch]
    - reads ./deploy.yaml
    - fires services that do tasks within "production" key

# DONE
$ deployer init
    - creates ./deploy.yaml

$ deployer info
    - lists destinations
    - reads ./deploy.yaml
    - shows what is available to deploy

# Deployer architecture

## Web App

* holds deploy config for each environment
	* production
	* staging
	* ...
* holds servers configuration
* holds stages configuration:
	* stages have name, commands, options
	* options can include "allow failure", servers on which to run (default: all)
* creates deployer.yml config
	* symfony options resolver helps here
* creates release dir
* uploads deployer.yml to release dir
* runs deployer there
* symlink release to path
* purges configurable number of oldest releases after deployer.yml is processed with success

Web deployer.yml:
```yaml
production:
	servers:
	  app1:
		host: app1.domain.com
	  app2:
		host: app2.domain.com

	stages:
	  Install dependencies:
	    commands:
	      - composer install --no-dev
	  Run tests:
		servers:
		  - app2
	    commands:
	      - bin/phpspec run -fpretty
```

## Deployer-cli

* Reads deployer.yml
* runs stages commands
* can be used as a standalone
* Web App prepares configuration for single, localhost server, with stages only for that server

Release deployer.yml for **app1**

```yaml
production:
  server: localhost
  stages:
    Install Dependencies:
    servers: localhost
    commands:
      - composer install --no-dev
```

## Tools
https://github.com/Nayjest/Builder
https://github.com/Herzult/php-ssh
https://github.com/symfony/OptionsResolver
