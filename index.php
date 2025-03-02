<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System Using OOP in PHP and MySQL</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
<h2 class="text-center">Library Management System Using OOP in PHP and MySQL</h2>

<!-- Search Form -->
<form class="mb-3 d-flex">
    <input type="text" id="searchInput" class="form-control me-2" placeholder="Search by title, author, or year">
</form>

<a href="add.php" class="btn btn-success mb-3">Add New Book</a>

<table class="table table-bordered">
    <thead>
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Author</th>
        <th>Year</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody id="bookTable">
    <?php
    require_once "Book.php";
    $book = new Book();
    $books = $book->getBooks();

    if (empty($books)): ?>
        <tr>
            <td colspan="5" class="text-center">No books found</td>
        </tr>
    <?php else:
        foreach ($books as $b): ?>
            <tr>
                <td><?= $b['id']; ?></td>
                <td><?= htmlspecialchars($b['title']); ?></td>
                <td><?= htmlspecialchars($b['author']); ?></td>
                <td><?= $b['published_year']; ?></td>
                <td>
                    <a href="edit.php?id=<?= $b['id']; ?>" class="btn btn-warning">Edit</a>
                    <button class="btn btn-danger delete-btn"
                            data-id="<?= $b['id']; ?>"
                            data-title="<?= htmlspecialchars($b['title']); ?>"
                            data-bs-toggle="modal"
                            data-bs-target="#deleteModal">Delete</button>
                </td>
            </tr>
        <?php endforeach;
    endif; ?>
    </tbody>
</table>

<!-- Bootstrap Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong id="bookTitle"></strong>?</p>
            </div>
            <div class="modal-footer">
                <form id="deleteForm" method="POST" action="delete.php">
                    <input type="hidden" name="id" id="deleteBookId">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="text-center p-3 bg-primary text-white mt-5">
    <p>Created By <strong>Dr. Jake Rodriguez Pomperada, PhD.</strong> &copy; 2025</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $("#searchInput").on("keyup", function() {
            let query = $(this).val();
            $.ajax({
                url: "search.php",
                method: "POST",
                data: { query: query },
                success: function(data) {
                    $("#bookTable").html(data);
                }
            });
        });

        // Delete confirmation modal setup
        $(document).on("click", ".delete-btn", function() {
            let bookId = $(this).data("id");
            let bookTitle = $(this).data("title");

            $("#deleteBookId").val(bookId);
            $("#bookTitle").text(bookTitle);
        });
    });
</script>

</body>
</html>
