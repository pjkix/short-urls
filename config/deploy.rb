# some sammple deploy stuff from ... http://www.capify.org/getting-started/from-the-beginning/

set :application, "short_urls"

set :repository, "svn+ssh://svn.dev.pjkix.com/home/svn/short-urls"

# if you are not using svn ... 
# set :scm, :git

set :deploy_to, "/var/www"

role :app, "pjkix.com"
role :web, "pjkix.com.com"
role :db, "pjkix.com", :primary => true

# same as writing ... 
server "pjkix.com", :app, :web, :db, :primary => true

# run cmds as this user
set :user, "pjkix"

# run scm cmds as this user
set :scm_username, "pjkix"

# don't try and use sudo for some commands
set :use_sudo, false


