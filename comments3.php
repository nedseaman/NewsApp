<!DOCTYPE html>
<html lang="en">
    <?php
        session_start();
        require 'database.php';
    ?>
    <head>
        <title>Simple News Site</title>
        <link rel="stylesheet" href="styles.css"/>
    </head>

    <body>
        <h1>Comments</h1>
        <table>
            <tbody>
            <?php
            
            //querying of comment_id, author, comment from comments table where the story_id is from the previous home page; this is so we can't just post a random comment that is for all stories/for no stories
            $stmt = $mysqli->prepare("select comment_id, author, comment from comments where story_id=?");
            if(!$stmt){
                printf("Query Prep Failed: %s\n", $mysqli->error);
                exit;
            }
        
            //story_id is an int!
            $stmt->bind_param('i', $_GET['story_id']);
            $stmt->execute();
            $stmt->bind_result($comment_id, $author, $comment);
            //binding results into variables that we can use to display the comments

            while($stmt->fetch()){
            ?>
                <!-- displaying the comments -->
                <tr><h3><?= htmlentities((String)"Author: ".$author); ?></h3></tr>
                <tr><p><?= htmlentities((String)$comment); ?></p></tr>
                <!-- if you are logged in, then you can see the edit comment and delete comment buttons on your own comments, but not for anyone else's comments -->
                <?php
                if(isset($_SESSION['username']) && $author == $_SESSION['username']) {
                ?>
                <tr>
                    <!-- these forms take you to separate pages to edit or delete comments; passes on hidden variables as well to use later -->
                    <form action="edit_comment3.php" method="GET">
                        <input type="hidden" name="comment_id" value=<?= $comment_id; ?>/>
                        <input type="submit" value="Edit Comment"/>
                    </form>
                    <form action="delete_comment3.php" method="POST">
                        <input type="hidden" name="comment_id" value=<?= $comment_id; ?>/>
                        <input type="hidden" name="token" value="<?= $_SESSION['token']; ?>" />
                        <input type="submit" value="Delete Comment"/>
                    </form>
                </tr>
                <?php
                }
                ?>
            <?php
            }

            $stmt->close();
            ?>
            </tbody>
        </table>
    </body>
</html>