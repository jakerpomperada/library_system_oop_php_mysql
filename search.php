<?php

require_once "Book.php";
$book = new Book();

if (isset($_POST['query'])) {
    $keyword = $_POST['query'];
    $books = $book->searchBooks($keyword);

    if (empty($books)) {
        echo "<tr><td colspan='5' class='text-center'>No books found</td></tr>";
    } else {
        foreach ($books as $b) {
            echo "<tr>
                    <td>{$b['id']}</td>
                    <td>" . htmlspecialchars($b['title']) . "</td>
                    <td>" . htmlspecialchars($b['author']) . "</td>
                    <td>{$b['published_year']}</td>
                    <td>
                        <a href='edit.php?id={$b['id']}' class='btn btn-warning'>Edit</a>
                        <button class='btn btn-danger delete-btn' 
                                data-id='{$b['id']}' 
                                data-title='" . htmlspecialchars($b['title']) . "'
                                data-bs-toggle='modal' 
                                data-bs-target='#deleteModal'>Delete</button>
                    </td>
                  </tr>";
        }
    }
}

