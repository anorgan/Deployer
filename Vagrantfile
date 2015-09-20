Vagrant.configure(2) do |config|
  config.vm.box = "ubuntu/trusty64"

  config.hostmanager.enabled = true
  config.hostmanager.manage_host = true

  config.hostmanager.aliases = [
    "deployer.dev",
    "www.deployer.dev"
  ]

  # SaltStack
  config.vm.synced_folder ".salt/", "/srv/salt/"

  config.vm.provision :salt do |salt|
    salt.minion_config = ".salt/minion"
    salt.run_highstate = true
    salt.colorize = true
    salt.log_level = "info"
  end

  config.vm.define "app1", primary: true do |app1|
    app1.vm.hostname = 'app1.deployer.dev'
  end

  config.vm.define "app2" do |app2|
    app2.vm.hostname = 'app2.deployer.dev'
  end


end
