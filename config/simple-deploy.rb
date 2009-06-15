set :application, "doitdoit.com"
role  :app,   application
role  :web,   application
role  :db,    application, :primary =>true 

set :user, "deploy"
set :deploy_to, "/var/www/apps/#{application}"
set :deploy_via,  :remote_cache
set :use_sudo, false

set :scm, "git"
set :repository, "git://github.com/pjkix/short-urls.git"
set :branch, "master"

namespace :deploy do
  
  desc  "tell passenger to restart the app"
  task  :restart  do
    run "touch #{current_path}/tmp/restart.txt"
  end
  
  desc  "symlink shared configs and folders on each release"
  task :symlink_shared  do
    run "ln -nfs #{shared_path}/config/database.yml #{release_path}/config/database.yml" 
    run "ln -nfs #{shared_path}/assets #{release_path}/public/assets" 
  end
  
  desc  "sync the public/assets dir manually"
  task  :assets do
    system "rsync -vr --exclude='.DS_Store' public/assets #{user}@#{application}:#{shared_path}/"
  end
  
end

after 'deploy:update_code', 'deploy:symlink_shared'
