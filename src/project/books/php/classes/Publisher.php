<?php

class Publisher
{
    // public properties for each database column
    public $id;
    public $title;
 
    // private $db property for database connection
    private $db;
 
    public function __construct($data = [])
    {
        // TODO: Get database connection from DB singleton
        // TODO: If $data is not empty, populate properties using null coalescing operator
        $this->db = DB::getInstance()->getConnection();
 
        $this->id = $data['id'] ?? null;
        $this->title = $data['title'] ?? null;
    }

    public static function findAll()
    {
        // TODO: Implement this method
        $db = DB::getInstance()->getConnection();
 
        $stmt = $db->prepare("SELECT * FROM publishers ORDER BY title");
        $stmt->execute();
 
        $publishers = [];
        while ($row = $stmt->fetch()) {
            $publishers[] = new Publisher($row);
        }
 
        return $publishers;
    }
 
    public static function findById($id)
    {
        $db = DB::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM publishers WHERE id = :id");
        $stmt->execute(['id' => $id]);
 
        $row = $stmt->fetch();
        if ($row) {
            return new Publisher($row);
        }
 
        return null;
    }
 
    public static function findByPublisher($publisherId)
    {
        // TODO: Implement this method
        $db = DB::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM publishers WHERE publisher_id = :publisher_id ORDER BY title");
        $stmt->execute(['publisher_id' => $publisherId]);
 
        $publishers = [];
        while ($row = $stmt->fetch()) {
            $publishers[] = new Publisher($row);
        }
 
        return $publishers;
    }
 
    public function save()
    {
        // TODO: Implement this method
        if ($this->id) {
            $stmt = $this->db->prepare("
                UPDATE publishers
                SET title = :title,
                WHERE id = :id
            ");
 
            $params = [
                'title' => $this->title,
                'id'             => $this->id
            ];
        } else {
            $stmt = $this->db->prepare("
                INSERT INTO publishers (title, author, publisher_id, year, isbn, description, cover_filename)
                VALUES (:title, :author, :publisher_id, :year, :isbn, :description, :cover_filename)
            ");
 
            $params = [
                'title' => $this->title,
            ];
        }
       
        $status = $stmt->execute($params);
 
        if (!$status) {
            $error_info = $stmt->errorInfo();
            $message = sprintf(
                "SQLSTATE error code: %s; error message: %s",
                $error_info[0],
                $error_info[2]
            );
            throw new Exception($message);
        }
 
        if ($stmt->rowCount() !== 1) {
            throw new Exception("Failed to save publisher.");
        }
 
        if ($this->id === null) {
            $this->id = $this->db->lastInsertId();
        }
    }
 
    public function delete()
    {
        // TODO: Implement this method
        if (!$this->id) {
            return false;
        }
 
        $stmt = $this->db->prepare("DELETE FROM publishers WHERE id = :id");
        return $stmt->execute(['id' => $this->id]);
    }
 
    public function toArray()
    {
        // TODO: Implement this method
            return [
            'id' => $this->id,
            'title'  => $this->title,
        ];
    }
}
 