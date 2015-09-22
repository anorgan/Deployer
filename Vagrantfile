Vagrant.configure(2) do |config|
  config.vm.box = "ubuntu/trusty64"

  config.hostmanager.aliases = [
    "deployer.dev",
    "app1.deployer.dev",
    "app2.deployer.dev",
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
    app1.vm.network "private_network", ip: "10.10.0.10"
    app1.hostmanager.enabled = true
    app1.hostmanager.manage_host = true
  end

  config.vm.define "app2" do |app2|
    app2.vm.hostname = 'app2.deployer.dev'
    app2.vm.network "private_network", ip: "10.10.0.20"
    app2.hostmanager.enabled = true
    app2.hostmanager.manage_host = true
  end


end
