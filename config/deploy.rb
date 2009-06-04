# generated from capify cmd
set :application, "short_urls"
set :repository, "svn+ssh://svn.dev.pjkix.com/home/svn/short-urls"

# If you aren't deploying to /u/apps/#{application} on the target
# servers (which is the default), you can specify the actual location
# via the :deploy_to variable:
set :deploy_to, "/var/www/#{application}"

# If you aren't using Subversion to manage your source code, specify
# your SCM below:
# set :scm, :subversion

role :app, "pjkix.com"
role :web, "pjkix.com.com"
role :db, "pjkix.com", :primary => true
# same as writing ... 
# server "pjkix.com", :app, :web, :db, :primary => true


# some sammple deploy stuff from ... http://www.capify.org/getting-started/from-the-beginning/

# run cmds as this user
set :user, "pjkix"

# run scm cmds as this user
set :scm_username, "pjkix"

# don't try and use sudo for some commands
set :use_sudo, false


# deploy:update

# This will copy your source code to the server, and update the “current”
# symlink to point to it, but it doesn’t actually try to start your application
# layer.


# tunneling through a gateway server
# set :gateway, "net.pjkix.com"

# servers to run cmds on
role :dev, "pjkix@dev.pjkix.com"
role :prod, "www.pjkix.com", "pjkix@dev.pjkix.com"

# tasks

task :search_libs, :roles => :dev do
  run "ls -x1 /usr/lib | grep -i xml"
end

task :count_libs, :roles => :prod do
  run "ls -x1 /usr/lib | wc -l"
end

task :show_free_space, :roles => :dev do
  run "df -h /"
end

task :where_am_i, :roles => :dev do
  run "pwd"
end



