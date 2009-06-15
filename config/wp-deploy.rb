# see http://www.madebymany.co.uk/using-capistrano-with-php-specifically-wordpress-0087

set :app_symlinks, ["wp-content/avatars","wp-content/uploads","wp-content/cache"]

namespace :wordpress do
  namespace :symlinks do

    desc "Setup application symlinks in the public"
    task :setup, :roles => [:web] do
      if app_symlinks
      app_symlinks.each { |link| run "mkdir -p #{shared_path}/public/#{link}" }
    end
    
  end

  desc "Link public directories to shared location."
  task :update, :roles => [:web] do
    if app_symlinks
      app_symlinks.each { |link| run "ln -nfs #{shared_path}/public/#{link} #{current_path}/public/#{link}" }
    end
    send(run_method, "rm -f #{current_path}/public/wp-config.php")
    send(run_method, "ln -nfs #{shared_path}/public/wp-config.php #{current_path}/public/wp-config.php")
    end
  end


  set :wp_config_template, "wp-config.php.erb"

  task :wp_config_php, :roles => [:web] do
    file = File.join(File.dirname(__FILE__), "templates", wp_config_template)
    template = File.read(file)
    buffer = ERB.new(template).result(binding)
    put buffer, "#{shared_path}/public/wp-config.php", :mode => 0444
  end


end

set :wp_db_name, "ourblog_wp"
set :wp_db_user, "ourblog"
set :wp_db_password, "pa55w0rd"
set :wp_db_host, "localhost"
set :wp_db_charset, "utf8"



set :apache_server_name, "madebymany.co.uk"
set :application, "ourblog"
set :domain, "madebymany.co.uk"
set :apache_server_aliases, []
set :apache_ctl, "/etc/init.d/apache2"
set :vhost_template, "wp_apache_vhost.erb"

namespace :apache do

task :vhost, :roles => [:web] do
set :apache_vhost_aconf, "/etc/apache2/sites-available/#{application}"
set :apache_vhost_econf, "/etc/apache2/sites-enabled/#{application}"

server_aliases = []
server_aliases << "www.#{apache_server_name}"
server_aliases.concat apache_server_aliases
set :apache_server_aliases_array, server_aliases

file = File.join(File.dirname(__FILE__), "templates", vhost_template)
template = File.read(file)
buffer = ERB.new(template).result(binding)
put buffer, "#{shared_path}/httpd.conf", :mode => 0444
send(run_method, "cp #{shared_path}/httpd.conf #{apache_vhost_aconf}")
send(run_method, "rm -f #{shared_path}/httpd.conf")
send(run_method, "ln -nfs #{apache_vhost_aconf} #{apache_vhost_econf}")
end

desc "Start Apache "
task :start, :roles => :web do
sudo "#{apache_ctl} start"
end

desc "Restart Apache "
task :restart, :roles => :web do
sudo "#{apache_ctl} restart"
end

desc "Stop Apache "
task :stop, :roles => :web do
sudo "#{apache_ctl} stop"
end
end



namespace :config do

desc "Configure new wordpress install"
task :default, :roles => [:web] do
wordpress.wp_config_php
apache.vhost
end
end

after   'deploy:setup', 'wordpress:config'
before  'deploy:update_code', 'wordpress:symlinks:setup'
after   'deploy:symlink', 'wordpress:symlinks:update'



default_run_options[:pty] = true
set :keep_releases, 3
set :use_sudo, true
set :user, "deploy"
set :repository,  "svn+ssh://#{user}@madebymany.co.uk/var/svn/wpprojects/ourblog/trunk"
set :deploy_to, "/var/www/apps/#{application}"
set :deploy_via, :export

role :app, "madebymany.co.uk"
role :web, "madebymany.co.uk"
role :db,  "madebymany.co.uk", :primary => true

namespace :deploy do
task :restart, :roles => :app do
# Do nothing or restart apache
# apache.restart
end
end

after   :deploy,'deploy:cleanup'
