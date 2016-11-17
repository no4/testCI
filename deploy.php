<?php
namespace Deployer;
require 'recipe/common.php';

// Configuration

set('repository', 'git@github.com:no4/testCI.git');
//set('shared_files', []);
//set('shared_dirs', []);
//set('writable_dirs', []);

// Servers
server('production', '192.168.1.112')
  ->user('kenlam')
  ->password('LK123qwe')
    //->identityFile()
    ->set('deploy_path', '/var/www/testCI');


// Tasks

task('test',function(){
  writeln('Hello world');
});

task('pwd', function () {
    $result = run('pwd');
    writeln("Current dir: $result");
});


desc('Restart PHP-FPM service');
task('php-fpm:restart', function () {
    // The user must have rights for restart service
    // /etc/sudoers: username ALL=NOPASSWD:/bin/systemctl restart php-fpm.service
    run('sudo systemctl restart php-fpm.service');
});
//after('deploy:symlink', 'php-fpm:restart');

desc('Deploy your project');
task('deploy', [
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:writable',
//    'deploy:vendors',
    'deploy:clean',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
    'success'
]);

after('deploy', 'success');
