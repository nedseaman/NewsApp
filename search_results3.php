<!DOCTYPE html>
<html lang="en">
    <?php
        session_start();
        require 'database.php';
        $query = "%".(String)$_GET['query']."%";
        $type = (String)$_GET['type'];
    ?>
    <head>
        <title>Simple News Site</title>
        <link rel="stylesheet" href="styles.css"/>
    </head>

    <body>
        <h1>Search Results</h1>
        <table>
            <tbody>
            <!-- we are going to display all the stories that match the keywords of the chosen type-->
            <?php
            //select the story based on the column that the user chose
            if($type == 'author'){
                $stmt = $mysqli->prepare("select * from stories where author like ?");
            } else if($type == 'title') {
                $stmt = $mysqli->prepare("select * from stories where title like ?");
            } else if($type == 'body') {
                $stmt = $mysqli->prepare("select * from stories where body like ?");
            } else if($type == 'link') {
                $stmt = $mysqli->prepare("select * from stories where link like ?");
            }

            if(!$stmt){
                printf("Query Prep Failed: %s\n", $mysqli->error);
                exit;
            }
        
            $stmt->bind_param('s', $query);
            $stmt->execute();

            //binding results to variables so that we can display them
            $stmt->bind_result($id, $author, $title, $body, $link);

            while($stmt->fetch()){
            ?>
                <!-- listing out all the results of the search/query -->
                <tr><h2><?= htmlentities($title); ?></h2></tr>
                <tr><p><?= htmlentities("Author: ".$author); ?></p></tr>
                <tr><p><?= htmlentities($body); ?></p></tr>
                <tr><a href=<?= htmlspecialchars($link) ?>><?= $link ?></a></tr>
                <br><br>
                <tr>
                    <form action="comment3.php" method="GET">
                        <input type="hidden" name="story_id" value=<?= $id; ?>/>
                        <input type="submit" value="Comment"/>
                    </form>
                    <form action="comments3.php" method="GET">
                        <input type="hidden" name="story_id" value=<?= $id; ?>/>
                        <input type="submit" value="View Comments"/>
                    </form>
                </tr>
            <!-- if you're logged in, you can edit or delete your story; search is useful since you can just search you username and access all the stories you've posted. -->
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