<!DOCTYPE html>
<html lang="en">
    <?php session_start(); ?>
    <head>
        <title>Simple News Site</title>
        <link rel="stylesheet" href="styles.css"/>
    </head>
    <body>
        <h1>Post a Story</h1>
        <!-- form to post a story. we jsut use type=text for the title and link and textarea for the body (more lines!). -->
        <!-- this form will got to post_story3.php so that we can pass along some variables -->
        <form action="post_story3.php" method="POST">
            Title: <input type="text" name="title" maxlength="50" required />
            <br><br>
            <textarea name="body" maxlength="100" rows="4" cols="25" required ></textarea>
            <br><br>
            Link: <input type="text" name="link" maxlength="100" required />
            <br><br>
            <input type="hidden" name="token" value="<?= $_SESSION['token']; ?>" />
            <input type="submit" value="Post Story"/>
        </form>

    </body>
</html>