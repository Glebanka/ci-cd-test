<?php

namespace console\controllers;

use yii\console\Controller;
use yii\console\ExitCode;

class FileDataBaseController extends Controller
{
    /**
     * Создаёт конфигурационный файл для подключения к БД.
     * @param string $dbname Имя базы данных (по умолчанию db_name).
     * @param string $username Имя пользователя (по умолчанию root).
     * @param string $password Пароль пользователя (по умолчанию пустой).
     * @param string $tablePrefix Префикс таблиц (по умолчанию пустой).
     * @return int
     */
    public function actionCreate(
        $dbname = 'db_name',
        $username = 'root',
        $password = '',
        $tablePrefix = ''
    ) {
        $filePath = \Yii::getAlias('@common/config/db.php');

        // Проверяем, существует ли файл
        if (file_exists($filePath)) {
            echo "Файл '$filePath' уже существует! Перезаписать? (yes/no): ";
            $handle = fopen("php://stdin", "r");
            $line = trim(fgets($handle));
            fclose($handle);

            if ($line !== 'yes') {
                echo "Операция отменена.\n";
                return ExitCode::OK;
            }
        }

        // Если пароль пустой, записываем как пустую строку ''
        $passwordString = $password !== "''" ? "'{$password}'" : "''";
        $tablePrefixString = $tablePrefix !== "''" ? "'{$tablePrefix}'" : "''";

        // Генерируем содержимое файла
        $content = <<<PHP
<?php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname={$dbname}',
    'username' => '{$username}',
    'password' => $passwordString,
    'charset' => 'utf8mb4',
    'tablePrefix' => $tablePrefixString,
];
PHP;

        if (file_put_contents($filePath, $content) !== false) {
            echo "Файл '$filePath' успешно создан.\n";
            return ExitCode::OK;
        } else {
            echo "Ошибка при создании файла '$filePath'.\n";
            return ExitCode::UNSPECIFIED_ERROR;
        }
    }
}
