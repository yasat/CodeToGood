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
    <h1>Select Actions</h1>
    <button id="addRowButton">Add Scene</button>
    <form id="selection-form">
        
        <button type="submit">Play the story</button>
    </form>
    <script>

        <?php
            $placesDirectory = 'places';

            $contents = scandir($placesDirectory);
            
            $places = array_filter($contents, function ($item) {
                return !in_array($item, ['.', '..']);
            });

            $js_places = [];

            foreach ($places as $place) {
                $js_places[] = substr($place, 0, -4);
                
            }

            $actionsDirectory = 'charecters/' . $_POST['character'];

            $contents = scandir($actionsDirectory);
            
            $actions = array_filter($contents, function ($item) {
                return !in_array($item, ['.', '..']);
            });

            $js_actions = [];

            foreach ($actions as $action) {
                $action = str_replace($_POST['character']."_", '', $action);
                $js_actions[] = str_replace(".gif", '', $action);
                
            }
        ?>

        const actionOptions = <?php echo json_encode($js_actions); ?>;
        const locationOptions = <?php echo json_encode($js_places); ?>;

        document.addEventListener("DOMContentLoaded", function () {
        const form = document.getElementById("selection-form");
        const addRowButton = document.getElementById("addRowButton");

        addRowButton.addEventListener("click", function (event) {
            event.preventDefault();

            const actionRow = document.createElement("div");
            actionRow.className = "action-row";
            
            const actionSelect = document.createElement("select");
            actionSelect.name = "actions";
           
            actionOptions.forEach(optionText => {
                const option = document.createElement("option");
                option.value = optionText;
                option.text = optionText;
                actionSelect.appendChild(option);
            });

            actionRow.appendChild(actionSelect);

            const locationSelect = document.createElement("select");
            locationSelect.name = "locations";
            locationOptions.forEach(optionText => {
                const option = document.createElement("option");
                option.value = optionText;
                option.text = optionText;
                locationSelect.appendChild(option);
            });

            actionRow.appendChild(locationSelect);

            form.insertBefore(actionRow, form.querySelector("button[type='submit']"));
        });

        form.addEventListener("submit", function (event) {
            event.preventDefault();

            const actionSelects = document.querySelectorAll(".action-row select");

            const selectedCharacter = <?php echo '"' . $_POST["character"] . '"';?>;
            const selectedActions = Array.from(actionSelects).map(select => select.value);
            if(selectedActions.length == 0){
                alert("select atleast one scene");
                return;
            }
            else{
                sendStory(selectedCharacter, selectedActions.join(", "));
            }
            
        });
    });

    function sendStory(charecter, sequence){
        const dataToSend = {
            char: charecter,
            seq: sequence
        };

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "add_story.php", true);
        xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    console.log(xhr.responseText);
                    window.location.href = 'run_story.php?id='+xhr.responseText;
                } else {
                    console.error("Request failed:", xhr.status, xhr.statusText);
                }
            }
        };

        xhr.send(JSON.stringify(dataToSend));
    }
    </script>
</body>
</html>