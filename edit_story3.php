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
        <?php
        //query for the title, body and link from stories table that we are going to edit
        $stmt = $mysqli->prepare("select title, body, link from stories where story_id=?");
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        
        //making sure the variable type is consistent ('story_id' is an int).
        $stmt->bind_param('i', $_GET['story_id']);
        $stmt->execute();
        //bind results into variables that we will use and edit
        $stmt->bind_result($title, $body, $link);
        $stmt->fetch();

        ?>
        
        <h1>Edit a Story</h1>
        <!-- textarea will already be loaded in with story to be edited using the binded variables. we'll be able to change title, body, and link. will take us to post_edit_story3.php to avoid having duplicate stories -->
        <!-- we have to use the php tags for each variable :,) -->
        <form action="post_edit_story3.php" method="POST">
            Title: <input type="text" name="title" maxlength="50" value=<?= "'$title'"; ?> required />
            <br><br>
            <textarea name="body" maxlength="100" rows="4" cols="25" required ><?= htmlentities($body); ?></textarea>
            <br><br>
            Link: <input type="text" name="link" maxlength="100" value=<?= htmlentities($link); ?> required />
            <br><br>
            <input type="hidden" name="story_id" value=<?= $_GET['story_id']; ?>/>
            <input type="hidden" name="token" value="<?= $_SESSION['token'];?>" />
            <input type="submit" value="Post Story"/>
        </form>

    </body>
</html>