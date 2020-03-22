<?php

require_once '../vendor/autoload.php';
// require_once '../src/init.php';
require_once '../bootstrap.php';
// TODO внимание, вопрос: почему через закомментированную строку не работает,
// хотя там то же самое?


use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

try {
	DB::schema()->dropIfExists('categories');
	DB::schema()->create('categories', function (Blueprint $table) {
		$table->bigIncrements('id')->unsigned();
		$table->string('name', 100)->nullable(false)->unique();
		$table->text('description');
		$table->timestamps();
	});
	echo "Таблица categories создана\n";

	DB::schema()->dropIfExists('products');
	DB::schema()->create('products', function (Blueprint $table) {
		$table->bigIncrements('id')->unsigned();
		$table->unsignedBigInteger('category_id');
		$table->foreign('category_id')->references('id')->on('categories');

		$table->string('name', 1000)->nullable(false);
		$table->tinyInteger('price')->nullable(false);
		$table->text('photo');
		$table->text('description');
		$table->timestamps();
	});
	echo "Таблица products создана\n";
	echo "Миграции прошли успешно\n";
} catch (\Exception $exception) {
	echo "Ошибка при миграции. {$exception->getMessage()}\n";
}



