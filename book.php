<?php

require_once "Database.php";

class Book
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // Create (Add Book)
    public function addBook($title, $author, $year)
    {
        $stmt = $this->db->conn->prepare("INSERT INTO books (title, author, published_year) VALUES (?, ?, ?)");
        return $stmt->execute([$title, $author, $year]);
    }

    // Read (Get All Books)
    public function getBooks()
    {
        $stmt = $this->db->conn->prepare("SELECT * FROM books ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get Single Book by ID
    public function getBookById($id)
    {
        $stmt = $this->db->conn->prepare("SELECT * FROM books WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update (Edit Book)
    public function updateBook($id, $title, $author, $year)
    {
        $stmt = $this->db->conn->prepare("UPDATE books SET title = ?, author = ?, published_year = ? WHERE id = ?");
        return $stmt->execute([$title, $author, $year, $id]);
    }

    // Delete (Remove Book)
    public function deleteBook($id)
    {
        $stmt = $this->db->conn->prepare("DELETE FROM books WHERE id = ?");
        return $stmt->execute([$id]);
    }

        public function searchBooks($keyword) {
        $stmt = $this->db->conn->prepare("SELECT * FROM books 
                                      WHERE title LIKE ? 
                                         OR author LIKE ? 
                                         OR published_year LIKE ?
                                      ORDER BY id DESC");
        $search = "%$keyword%";
        $stmt->execute([$search, $search, $search]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


}

