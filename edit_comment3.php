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
        <!-- query to get the comment to be edited from the databbase -->
        <?php
        $stmt = $mysqli->prepare('select comment from comments where comment_id=?');
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        //making sure the variable type is consistent ('comment_id' is an int)
        $stmt->bind_param('i', $_GET['comment_id']);
        $stmt->execute();
        // bind the result into a variable we can use/display
        $stmt->bind_result($comment);
        $stmt->fetch();
        ?>
        
        <h1>Edit a Comment</h1>
        <!-- textarea will already be loaded in with comment to be edited using the previous $comment variable. will take us to post_edit_comment3.php to avoid having duplicate comments -->
        <form action="post_edit_comment3.php" method="POST">
            <textarea name="comment" maxlength="50" rows="2" cols="25" ><?= htmlentities($comment); ?></textarea>
            <br>
            <input type="hidden" name="comment_id" value=<?= $_GET['comment_id']; ?>/>
            <input type="hidden" name="token" value="<?= $_SESSION['token']; ?>" />
            <input type="submit" value="Edit Comment"/>
        </form>

    </body>
</html>