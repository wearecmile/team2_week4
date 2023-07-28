<!DOCTYPE html>
<html>

<head>
    <title>Book Shelf</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/style.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row offset-md-4 col-md-4 bg-light border-radius mt-5 p-2">
            <h2 class="d-block m-auto text-color" style="color: #10ac84;">Composite Design Pattern</h2>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="height-auto">
                    <h1 class="text-color" style="font-family: 'Bebas Neue', sans-serif;">Book Shelf</h1>
                    <?php
                    include_once('./composite.php');

                    if (isset($_SESSION['books']) && $_SESSION['books']->getBookCount() >= 5) { ?>
                        <!-- Bookshelf is full after adding the fifth book -->
                        <h3 class="text-center text-danger mb-3" style="font-family: 'Bebas Neue', sans-serif;">Book Shelf is Full!</h3>
                        <!-- Reset button to start a new bookshelf -->
                        <form method='post' action="" class="text-center">
                            <input type='submit' name="reset" class="btn btn-lg btn-primary" value='Start a New Bookshelf'>
                        </form>
                    <?php } else { ?>
                        <!--Display the form to enter book details one by one -->
                        <form method="post" action="">
                            <div class="form-group">
                                <label for="title">Title:</label>
                                <input type="text" name="title" id="title" class="form-control" pattern="[a-zA-Z0-9\s_-]+" title="Please enter a valid book name (letters, numbers, spaces, hyphens, and underscores only)." required>
                            </div>
                            <div class="form-group">
                                <label for="author">Author:</label>
                                <input type="text" name="author" id="author" class="form-control" pattern="[a-zA-Z\s']+" title="Please enter a valid author's name (letters, spaces, and apostrophes only)." required>
                            </div>
                            <div class="text-center">
                                <input type="submit" class="btn btn-lg btn-primary btn-block" name="add_book" value="Add Book">
                            </div>
                        </form>
                    <?php } ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="height-auto">
                    <!-- Display the bookshelf contents if there are any books -->
                    <h1 class="text-center text-color" style="font-family: 'Bebas Neue', sans-serif;">Book Shelf Contents</h1>
                    <div class='bookshelf'>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">Book</th>
                                    <th scope="col" class="text-center">Author</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (isset($_SESSION['books']) && $_SESSION['books']->getBookCount() > 0) { ?>
                                <?php for ($i = 1; $i <= $_SESSION['books']->getBookCount(); $i++) {
                                        echo $_SESSION['books']->getBookInfo($i);
                                    }
                                } else {
                                    echo '<tr><td class="text-center" colspan="2">Book Shelf is Empty</td></tr>';
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>