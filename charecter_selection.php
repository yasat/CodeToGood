<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create your own story</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        select {
            margin-bottom: 10px;
        }

        .button-row {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .action-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        button {
            background-color: #0074d9;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Select a Character</h1>
    <form id="selection-form" action="story_selection.php" method="post">
        <label for="character">Select a Character:</label>
        <select id="character" name="character">
        <?php
            $charactersDirectory = 'charecters';

            $contents = scandir($charactersDirectory);
            
            $charecters = array_filter($contents, function ($item) {
                return !in_array($item, ['.', '..']);
            });

            foreach ($charecters as $charecter) {
                echo "<option value='$charecter'>$charecter</option>";
                
            }
        ?>
            <!-- <option value="Penguin">Penguin</option> -->
        </select>
        
        <button type="submit">Create Story</button>
    </form>
</body>
</html>