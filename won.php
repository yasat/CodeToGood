<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>won</title>
    <style>
        #background_canvas{
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("places/home.png");
            background-repeat: no-repeat;
            background-size: cover;
        }
        button {
            padding: 10px 20px;
            font-size: 18px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div id="background_canvas">
        <button id="restart">restart!</button>
        <button id="share">share your story!</button>
        <img id="character" src=<?php echo '"' . $_GET['action'] . '"'; ?>>
    </div>

    <script>

        const queryParams = new URLSearchParams(window.location.search);
        const id = queryParams.get("id");

        character.style.position = "absolute";
        character.style.width = "250px";
        character.style.height = "250px";
        character.style.left = "600px";
        character.style.top = "500px";

        const restart = document.getElementById("restart");
        const share = document.getElementById("share");
    
        restart.addEventListener("click", () => {
            window.location.href = 'index.html';
        });

        share.addEventListener("click", () => {
            const textToCopy = "localhost/ctg/run_story.php?id="+id;
            const textarea = document.createElement("textarea");
            textarea.value = textToCopy;
            document.body.appendChild(textarea);

            textarea.select();

            document.execCommand("copy");

            document.body.removeChild(textarea);

            alert("Link copied to clipboard: " + textToCopy);
        });

    </script>
</body>

</html>