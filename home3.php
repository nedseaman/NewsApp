<!DOCTYPE html>
<html lang="en">
    <?php
        //hello
        session_start();
        require 'database.php';
    ?>
    <head>
        <title>Simple News Site</title>
        <link rel="stylesheet" href="styles.css"/>
    </head>

    <body>
        <!-- home page! -->
        <h1>Simple News Site Home</h1>
        <div>
            <!-- if we are logged in, we can see these buttons -->
            <?php if(isset($_SESSION['token'])) { ?>
            <form action="logout3.php">
                <input type="submit" value="Logout"/>
            </form>
            <form action="story3.php">
                <input type="submit" value="Create Post"/>
            </form>
            <!-- if we aren't logged in, then we want to either log in or create a new account -->
            <?php } else { ?>
            <form action="login3.html">
                <input type="submit" value="Login"/>
            </form>
            <?php } ?>
            <form action="create_user3.html">
                <input type="submit" value="Register"/>
            </form>
        </div>
        <div>
            <!-- search bar to search stories based on whatever radio button you choose; this leads to search_results3.php -->
            <form action="search_results3.php" method="GET">
                <input type="text" placeholder="Search here" name="query" required />
                <input type="radio" name="type" value="author" id="author" required/><label for="author">Author</label>
                <input type="radio" name="type" value="title" id="title"/><label for="title">Title</label>
                <input type="radio" name="type" value="body" id="body"/><label for="body">Body</label>
                <input type="radio" name="type" value="link" id="link"/><label for="link">Link</label>
                <input type="submit" value="Search" />
            </form> 
        </div>
        <table>
            <tbody>
            <?php
            
            //querying all info from stories table which is to be displayed
            $stmt = $mysqli->prepare("select * from stories order by story_id asc");
            if(!$stmt){
                printf("Query Prep Failed: %s\n", $mysqli->error);
                exit;
            }
        
            $stmt->execute();
            //binding results into variables for easy use.
            $stmt->bind_result($id, $author, $title, $body, $link);
            
            //formatting/displaying all of the stories while we are still fetching from the table.
            while($stmt->fetch()){
            ?>
                <!-- display the title, author, body, and link -->
                <tr><h2><?= htmlentities($title); ?></h2></tr>
                <tr><p><?= htmlentities("Author: ".$author); ?></p></tr>
                <tr><p><?= htmlentities($body); ?></p></tr>
                <tr><a href=<?= htmlspecialchars($link) ?>><?= $link ?></a></tr>
                <br><br>
                <tr>
                    <!-- buttons for commenting and viewing comments -->
                    <form action="comment3.php" method="GET">
                        <input type="hidden" name="story_id" value=<?= $id; ?>/>
                        <input type="submit" value="Comment"/>
                    </form>
                    <form action="comments3.php" method="GET">
                        <input type="hidden" name="story_id" value=<?= $id; ?>/>
                        <input type="submit" value="View Comments"/>
                    </form>
                </tr>
            <!-- checking to see if you are logged in, and if you are, you will be able to see the buttons below, which enable you to edit and delete your own stories -->
            <?php
                if(isset($_SESSION['username']) && $_SESSION['username'] == $author) {
            ?>
                <br>
                <tr>
                    <form action="edit_story3.php" method="GET">
                        <input type="hidden" name="story_id" value=<?= $id; ?>/>
                        <input type="submit" value="Edit Story"/>
                    </form>
                    <form action="delete_story3.php" method="POST">
                        <input type="hidden" name="story_id" value=<?= $id; ?>/>
                        <input type="hidden" name="token" value="<?= $_SESSION['token']; ?>" />
                        <input type="submit" value="Delete Story"/>
                    </form>
                </tr>
            <?php
                }
            }

            $stmt->close();
            ?>
            </tbody>
        </table>
        <br><br>
    </body>
</html>