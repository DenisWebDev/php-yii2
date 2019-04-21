Installation

~~~
/config/db_local.php
~~~

~~~
composer install
~~~

~~~
php yii migrate --migrationPath=@yii/rbac/migrations
~~~

~~~
php yii rbac/init
~~~

~~~
php yii migrate
~~~

Send notifications
~~~
php yii notification/send [-d={Y-m-d}] [-l={limit}] [-e={email}]
~~~