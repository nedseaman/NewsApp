<!DOCTYPE html>
<html lang="en">
    <?php session_start(); ?>
    <head>
        <title>Simple News Site</title>
        <link rel="stylesheet" href="styles.css"/>
    </head>
    <body>
        <h1>Leave a Comment</h1>
        <!-- comment form which leads to post_comment3.php; we have hidden tokens to pass on our session and form variables so we can query the database properly -->

        <!-- here we use textarea vs input type="text" for more lines and also because it looks better (maxlength=50 characters)-->
        <form action="post_comment3.php" method="POST">
            <textarea class="text-area" name="comment" maxlength="50" rows="2" cols="25" required></textarea>
            <input type="hidden" name="token" value="<?= $_SESSION['token']; ?>" />
            <input type="hidden" name="story_id" value=<?= $_GET['story_id']; ?>/>
            <br>
            <input class="submit-input" type="submit" value="Post Comment"/>
        </form>

    </body>
</html>