<?php

namespace app;
use PDO;

class Database
{
  public $pdo = null;
  public $dsn = 'mysql:host=localhost;port=80;dbname=products_crud';
  public static Database $db;

  public function __construct()
  {
    $this->pdo = new PDO($this->dsn, 'root', '');
    $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    self::$db = $this;
  }

  public function getProducts($search = '') {
    if ($search) {
      $statement = $this->pdo->prepare('SELECT * FROM products WHERE title LIKE :title ORDER BY create_date DESC');
      $statement->bindValue(':title', "%$search%");
    } else {
      $statement = $this->pdo->prepare('SELECT * FROM products ORDER BY create_date DESC');
    }

    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getProductById($id) {
    $query = 'SELECT * FROM products WHERE id = ' . $id;
    $statement = $this->pdo->prepare($query);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
  }

  public function createProduct(models\Product $product) {
    $statement = $this->pdo->prepare("
        INSERT INTO products (title, image, description, price, create_date)
        VALUES (:title, :image, :description, :price, :date)
      ");

    $statement->bindValue(':title', $product->title);
    $statement->bindValue(':image', $product->imagePath);
    $statement->bindValue(':description', $product->description);
    $statement->bindValue(':price', $product->price);
    $statement->bindValue(':date', date('Y-m-d H:i:s'));

    $statement->execute();

  }

  public function updateProduct(models\Product $product) {
    $updateQuery = "
      UPDATE products
      SET
      title = :title,
      image = :image,
      description = :description,
      price = :price
      WHERE id = :id
    ";

    $statement = $this->pdo->prepare($updateQuery);

    $statement->bindValue(':title', $product->title);
    $statement->bindValue(':image', $product->imagePath);
    $statement->bindValue(':description', $product->description);
    $statement->bindValue(':price', $product->price);
    $statement->bindValue(':id', $product->id);

    $statement->execute();
  }

  public function deleteProduct($id) {
    $query = 'DELETE FROM products WHERE id = :id';
    $statement = $this->pdo->prepare($query);
    $statement->bindValue(':id', $id);
    $statement->execute();
  }

}