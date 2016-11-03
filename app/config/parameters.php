<?php
$container->setParameter('database_driver', getenv('SYMFONY_BD_DRIVER'));
$container->setParameter('database_host', getenv('SYMFONY_BD_HOST'));
$container->setParameter('database_port', getenv('SYMFONY_BD_PORT'));
$container->setParameter('database_name', getenv('SYMFONY_BD_NAME'));
$container->setParameter('database_user', getenv('SYMFONY_BD_USER'));
$container->setParameter('database_password', getenv('SYMFONY_BD_PASS'));
$container->setParameter('secret', getenv('SYMFONY_SECRET'));
$container->setParameter('mailer_transport', getenv('MAILER_TRANSPORT'));
$container->setParameter('mailer_host', getenv('MAILER_HOST'));
$container->setParameter('mailer_user', getenv('MAILER_USER'));
$container->setParameter('mailer_password', getenv('MAILER_PASSWORD'));