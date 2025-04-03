<?php

require_once 'Model.php';

class Book extends Model{
    protected static $table = 'books';

    public $id;
    public $sku;
    public $title;
    public $author;
    public $genre;
    public $year_published;
    public $price;
    public $currency;
    public $stock;
    public $created_at;

    public function __construct(array $data = []){
        foreach($data as $key => $value){
            if(property_exists($this, $key)){
                $this->$key = $value;
            }
        }
    }

    public static function all(){
        $results = parent::all();

        return $results
            ? array_map(fn($book) => new self($book), $results)
            : null;
    }

    public static function find($id){
        $result = parent::find($id);

        return $result 
            ? new self($result)
            : null;
    }

    public static function create(array $data){
        $result = parent::create($data);

        return $result 
            ? new self($result)
            : null;
    }

    public function update(array $data){
        $result = parent::updateById($this->id, $data);

        if($result){
            foreach($data as $key => $value){
                if(property_exists($this, $key)){
                    $this->$key = $value;
                }
            }
            return true;
        }
        else{
            return false;
        }
    }

    public function save(){
        $data = [
            'sku' => $this->sku,
            'title' => $this->title,
            'author' => $this->author,
            'genre' => $this->genre,
            'year_published' => $this->year_published,
            'price' => $this->price,
            'currency' => $this->currency,
            'stock' => $this->stock,
            'created_at' => $this->created_at,
        ];
        $this->update($data);
    }

    public function delete(){
        $result = parent::deleteById($this->id);

        if($result){
            foreach($this as $key => $value){
                if(property_exists($this, $key)){
                    unset($this->$key);
                }
            }
            return true;
        }
        else{
            return false;
        }
    }

    public function getBooks() {
        $books = self::All();

        if (empty($books)) {
            http_response_code(404);
            echo "<h1 style='text-align: center; 
                            font-size: 50px; 
                            font-family: Verdana, sans-serif; 
                            margin-top: 250px; 
                            background: -webkit-linear-gradient(rgb(88, 10, 10),rgb(182, 98, 98)); 
                            -webkit-background-clip: text;  
                            -webkit-text-fill-color: transparent;'>    
                    Empty library! Sorry!
                    <br>  ｡°(°.◜ᯅ◝°)°｡  
                </h1>";
            exit();
        }
        return $books;
    }

    public static function findBySku($sku) {
        $sql = "SELECT * FROM " . static::$table . " WHERE sku = ?";
        $stmt = mysqli_prepare(self::$conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $sku);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $data = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
        return $data ? new self($data) : null;
    }

    public static function countAllBooks() {
        return self::countAll();
    }

    public static function countNewBooks($startDate, $endDate) {
        return self::countNew($startDate, $endDate);
    }

}