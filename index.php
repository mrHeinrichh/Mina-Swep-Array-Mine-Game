<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ArraySweeper: Two Player Edition</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        h2, h3, p {
            margin-bottom: 10px;
            text-align: center;
        }
        input[type="number"] {
            width: 200px;
            padding: 5px;
            font-size: 16px;
        }
        form {
            margin-bottom: 20px;
            text-align: center;
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        input[type="text"] {
            padding: 8px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button[type="submit"] {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button[type="submit"]:hover {
            background-color: #45a049;
        }
        p {
            margin-bottom: 10px;
            font-size: 16px;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        // Initialize variables
        $player1 = "";
        $player2 = "";
        $mine1 = "";
        $mine2 = "";
        
        $gameStarted = isset($_POST['submitIndex']) || isset($_POST['submit']);
        $congratsMessage = "";
        $maxAttempts = 3;
        $attemptsLeft = [$maxAttempts, $maxAttempts]; // Attempts left for player 1 and player 2

        if (!$gameStarted) {
            echo "<h2>ArraySweeper: Two Player Edition</h2>";
            ?>
            <form method="post" action="">
                <label>Player 1 Name: <input type="text" name="player1" required></label>
                <label>Player 2 Name: <input type="text" name="player2" required></label>
                <label>Array Index for Player 1 Mine (0-10): <input type="number" name="mine1" min="0" max="10" required></label>
                <label>Array Index for Player 2 Mine (0-10): <input type="number" name="mine2" min="0" max="10" required></label>
                <button type="submit" name="submit">Start Game</button>
            </form>
            <?php
        }

        if (isset($_POST['submitIndex'])) {
            $player1 = $_POST['player1'];
            $player2 = $_POST['player2'];
            $mine1 = $_POST['mine1'];
            $mine2 = $_POST['mine2'];
            $activePlayer = $_POST['activePlayer'];
            $index = $_POST['index'];

            $nextPlayer = $activePlayer == 1 ? 2 : 1;

            if (($activePlayer == 1 && $index != $mine2) || ($activePlayer == 2 && $index != $mine1)) {
                $congratsMessage = "Congratulations! You are still alive.";
            } else {
                echo "<p>BOOM! You're dead!</p>";
                $winner = $activePlayer == 1 ? $player2 : $player1;
                echo "<h3>Congratulations, $winner wins!</h3>";
                exit();
            }

            $attemptsLeft[$nextPlayer - 1]--;

            if ($attemptsLeft[$nextPlayer - 1] == 0) {
                $activePlayer = $nextPlayer;
                $attemptsLeft[$activePlayer - 1] = $maxAttempts;
            }

            if (isset($nextPlayer)) {
                echo "<h3>Player $nextPlayer's Turn (Attempts Left: {$attemptsLeft[$nextPlayer - 1]})</h3>";
            }

            ?>
            <form method="post" action="">
                <label>Enter Index Address to Avoid Player <?php echo $nextPlayer; ?>'s Mine: 
                    <input type="number" name="index" min="0" max="10" required>
                    <input type="hidden" name="activePlayer" value="<?php echo $nextPlayer; ?>">
                    <input type="hidden" name="player1" value="<?php echo $player1; ?>">
                    <input type="hidden" name="player2" value="<?php echo $player2; ?>">
                    <input type="hidden" name="mine1" value="<?php echo $mine1; ?>">
                    <input type="hidden" name="mine2" value="<?php echo $mine2; ?>">
                </label>
                <button type="submit" name="submitIndex">Submit</button>
            </form>
            <?php
        }

        if ($gameStarted) {
            $player1 = $_POST['player1'];
            $player2 = $_POST['player2'];
            $mine1 = $_POST['mine1'];
            $mine2 = $_POST['mine2'];

            $startingPlayer = rand(1, 2);

            if (!$congratsMessage) {
                $activePlayer = $startingPlayer;
                if (isset($nextPlayer)) {
                    echo "<h3>Player $nextPlayer's Turn (Attempts Left: {$attemptsLeft[$nextPlayer - 1]})</h3>";
                }

                ?>
                <form method="post" action="">
                    <label>Enter Index Address to Avoid Player <?php echo $startingPlayer == 1 ? "2" : "1"; ?>'s Mine: 
                        <input type="number" name="index" min="0" max="10" required>
                        <input type="hidden" name="activePlayer" value="<?php echo $startingPlayer; ?>">
                        <input type="hidden" name="player1" value="<?php echo $player1; ?>">
                        <input type="hidden" name="player2" value="<?php echo $player2; ?>">
                        <input type="hidden" name="mine1" value="<?php echo $mine1; ?>">
                        <input type="hidden" name="mine2" value="<?php echo $mine2; ?>">
                    </label>
                    <button type="submit" name="submitIndex">Submit</button>
                </form>
                <?php
            }
        }
        ?>
        <div>
            <h3>Inputted Numbers:</h3>
            <ul>
                <li>Player 1's Mine: <?php echo $mine1; ?></li>
                <li>Player 2's Mine: <?php echo $mine2; ?></li>
            </ul>
        </div>
    </div>
</body>
</html>
