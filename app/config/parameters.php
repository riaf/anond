<?php

$databaseUrl = getenv('DATABASE_URL') ?: 'mysql://root@localhost/anond';
$databaseParam = parse_url($databaseUrl);
$getDatabaseParam = function($key) use($databaseParam) {
    return isset($databaseParam[$key]) ? $databaseParam[$key] : null;
};

$databaseDriver = 'pdo_' . $databaseParam['scheme'];

switch ($databaseParam['scheme']) {
    case 'postgres':
        $databaseDriver = 'pdo_pgsql';
        break;
}

$container->setParameter('database_driver', $databaseDriver);
$container->setParameter('database_host', $getDatabaseParam('host'));
$container->setParameter('database_port', $getDatabaseParam('port'));
$container->setParameter('database_user', $getDatabaseParam('user'));
$container->setParameter('database_password', $getDatabaseParam('pass'));
$container->setParameter('database_name', substr($getDatabaseParam('path'), 1));

$container->setParameter('mailer_transport', 'smtp');
$container->setParameter('mailer_host', '127.0.0.1');
$container->setParameter('mailer_user', null);
$container->setParameter('mailer_password', null);

$container->setParameter('locale', 'ja');
$container->setParameter('secret', sha1($databaseUrl));

