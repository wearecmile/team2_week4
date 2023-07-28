<?php

session_start();

abstract class OnTheBookShelf
{
    abstract function getBookInfo($bookToGet);
    abstract function getBookCount();
    abstract function setBookCount($new_count);
    abstract function addBook($oneBook);
    abstract function removeBook($oneBook);
}

class OneBook extends OnTheBookShelf
{
    private $title;
    private $author;

    function __construct($title, $author)
    {
        $this->title = $title;
        $this->author = $author;
    }

    function getBookInfo($bookToGet)
    {
        if (1 == $bookToGet) {
        return '<tr>
                    <td class="text-center">' . $this->title . '</td>
                    <td class="text-center">' . $this->author . '</td>
                </tr>';
        } else {
            return FALSE;
        }
    }

    function getBookCount()
    {
        return 1;
    }

    function setBookCount($newCount)
    {
        return FALSE;
    }

    function addBook($oneBook)
    {
        return FALSE;
    }

    function removeBook($oneBook)
    {
        return FALSE;
    }
}

class SeveralBooks extends OnTheBookShelf
{
    private $oneBooks = array();
    private $bookCount;

    public function __construct()
    {
        $this->setBookCount(0);
    }

    public function getBookCount()
    {
        return $this->bookCount;
    }

    public function setBookCount($newCount)
    {
        $this->bookCount = $newCount;
    }

    public function getBookInfo($bookToGet)
    {
        if ($bookToGet <= $this->bookCount) {
            return $this->oneBooks[$bookToGet]->getBookInfo(1);
        } else {
            return FALSE;
        }
    }

    public function addBook($oneBook)
    {
        $this->setBookCount($this->getBookCount() + 1);
        $this->oneBooks[$this->getBookCount()] = $oneBook;
        return $this->getBookCount();
    }

    public function removeBook($oneBook)
    {
        $counter = 0;
        while (++$counter <= $this->getBookCount()) {
            if ($oneBook->getBookInfo(1) == $this->oneBooks[$counter]->getBookInfo(1)) {
                for ($x = $counter; $x < $this->getBookCount(); $x++) {
                    $this->oneBooks[$x] = $this->oneBooks[$x + 1];
                }
                $this->setBookCount($this->getBookCount() - 1);
            }
        }
        return $this->getBookCount();
    }
}

// Check if the user clicked the reset button
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset'])) {
    unset($_SESSION['books']);
}

if (!isset($_SESSION['books'])) {
    // Create the SeveralBooks instance if it doesn't exist in the session
    $_SESSION['books'] = new SeveralBooks();
}

// Handle form submission to add a book
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_book'])) {
    // Get the current book count
    $bookCount = $_SESSION['books']->getBookCount();

    // Process the current book's details and add it to the shelf
    $title = $_POST['title'];
    $author = $_POST['author'];
    $newBook = new OneBook($title, $author);
    $_SESSION['books']->addBook($newBook);

    // Increment the book count for the next iteration
    $bookCount++;
    $_SESSION['books']->setBookCount($bookCount);

    // Redirect to a new page to prevent form resubmission
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
