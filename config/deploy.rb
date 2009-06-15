# generated from capify cmd

set :application, "short_urls"
set :repository, "http://svn.dev.pjkix.com/short-urls/trunk"

# If you aren't deploying to /u/apps/#{application} on the target
# servers (which is the default), you can specify the actual location
# via the :deploy_to variable:
set :deploy_to, "/var/www/vhosts/#{application}"
set :document_root, "/var/www/vhosts"

# If you aren't using Subversion to manage your source code, specify
# your SCM below:
# set :scm, :subversion

# Server Roles
#
# role :app, "dev.pjkix.com"
# role :web, "dev.pjkix.com"
# role :db, "dev.pjkix.com", :primary => true
# same as writing ... 
server "dev.pjkix.com", :app, :web, :db, :primary => true

# some sammple deploy stuff from ... http://www.capify.org/getting-started/from-the-beginning/

# Source Control Settings
# 
set :scm_username, "pjkix" #if http
# set :scm_password, "foo" #if http
# set :scm_checkout, "export"

# SSH Settings
# 
# set :user, "pjkix"
# set :password, "sl4ck3r"
set :use_sudo, false # don't try and use sudo for some commands
set :ssh_options, {:forward_agent => true}


# deploy:update

# This will copy your source code to the server, and update the “current”
# symlink to point to it, but it doesn’t actually try to start your application
# layer.


# tunneling through a gateway server
# set :gateway, "net.pjkix.com"

# servers to run cmds on
role :dev, "dev.pjkix.com"
# role :prod, "www.pjkix.com", "dev.pjkix.com"

# tasks

desc "Search Libs on dev"
task :search_libs, :roles => :dev do 
  run "ls -x1 /usr/lib | grep -i xml"
end

task :count_libs, :roles => :dev do
  run "ls -x1 /usr/lib | wc -l"
end

task :show_free_space, :roles => :dev do
  run "df -h /"
end

task :where_am_i, :roles => :dev do
  run "pwd"
end


# see http://www.claytonlz.com/index.php/2008/08/php-deployment-with-capistrano/
# override some rails defaults in favor of php
# 
namespace :deploy do

  desc  "overide update and do our tasks wrapped in transaction"
	task :update do
		transaction do
			update_code
			symlink
		end
	end

  desc  "set permissions after update"
	task :finalize_update do
		transaction do
			run "chmod -R g+w #{releases_path}/#{release_name}"
		end
	end

  desc  "create symlinks"
	task :symlink do
		transaction do
			run "ln -nfs #{current_release} #{deploy_to}/#{current_dir}"
			run "ln -nfs #{deploy_to}/#{current_dir} #{document_root}"
		end
	end

  desc "overided default rails action do nothing for php"
	task :migrate do
		# nothing
	end

  desc "overided default rails action do nothing for php"
	task :restart do
		# nothing
	end

  desc  "link some static assets ... "
	task :after_symlink do
		transaction do
			run "ln -nsf #{shared_path}/images #{document_root}/images"
		end
	end
	
end


# after 'deploy:update_code', 'deploy:symlink_shared'

