VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
  # Configure The Box
  config.vm.box = "laravel/homestead"
  config.vm.hostname = "logboek"
  config.vm.box_version = '0.2.0'

  # Configure A Private Network IP
  config.vm.network :private_network, ip: "192.168.10.10"

  # Configure A Few VirtualBox Settings
  config.vm.provider "virtualbox" do |vb|
    vb.name = 'logboek'
    vb.customize ["modifyvm", :id, "--memory", "512"]
    vb.customize ["modifyvm", :id, "--cpus", "1"]
    vb.customize ["modifyvm", :id, "--natdnsproxy1", "on"]
    vb.customize ["modifyvm", :id, "--natdnshostresolver1", "on"]
    vb.customize ["modifyvm", :id, "--ostype", "Ubuntu_64"]
  end

  # Configure Port Forwarding To The Box
  config.vm.network :forwarded_port, guest: 80, host: 8000
  config.vm.network :forwarded_port, guest: 443, host: 44300
  config.vm.network :forwarded_port, guest: 3306, host: 33060
  config.vm.network :forwarded_port, guest: 5432, host: 54320

  public_key = File.expand_path '~/.ssh/id_rsa.pub'
  # Configure The Public Key For SSH Access
  if File.exists? public_key then
    config.vm.provision "shell" do |s|
      s.inline = "echo $1 | tee -a /home/vagrant/.ssh/authorized_keys"
      s.args = [File.read(public_key)]
    end
  end

  # Sync this	folder
  config.vm.synced_folder File.expand_path('.'), '/home/vagrant/logboek'

  config.vm.provision "shell" do |s|
    s.inline = "bash /vagrant/scripts/serve.sh $1 $2"
    s.args = ['logboek.dev', '/home/vagrant/logboek/public']
  end

  config.vm.provision "shell" do |s|
    s.path = "./scripts/create-mysql.sh"
    s.args = ['logboek']
  end

  # Configure All Of The Server Environment Variables
  config.vm.provision "shell" do |s|
    s.inline = "echo \"\nenv[$1] = '$2'\" >> /etc/php5/fpm/php-fpm.conf"
    s.args = ['APP_ENV', 'local']
  end

  config.vm.provision "shell", inline: "service php5-fpm restart"

  # Update Composer On Every Provision
  config.vm.provision "shell", inline: "/usr/local/bin/composer self-update"

  # Perform application database and secret key setup
  config.vm.provision "shell" do |s|
    s.path = "./scripts/setup.sh"
  end
end
