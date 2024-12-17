<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Screenings</title>
    <link rel="stylesheet" href="/dwp/admin/assets/css/screenings.css" />
</head>
<body>
    
<a href="/dwp/admin/dashboard" class="back-to-dashboard"><img src="../images/back-button.png" alt=""></a>

<h1>Manage Screenings</h1>
<?php
    if (isset($_SESSION['message'])) {
        echo '<div class="message">' . htmlspecialchars($_SESSION['message'], ENT_QUOTES, 'UTF-8') . '</div>';
        unset($_SESSION['message']);
    }
?>
<h2>Add New Screening</h2>
<form method="POST" class="screening-card">
    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(generate_csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">

    <label for="cinemahall_id">Cinema Hall:</label>
    <select name="cinemahall_id" required>
        <option value="">Select Cinema Hall</option>
        <?php foreach ($cinemaHalls as $hall): ?>
            <option value="<?php echo htmlspecialchars($hall['CinemaHall_ID'], ENT_QUOTES, 'UTF-8'); ?>">
                <?php echo htmlspecialchars_decode($hall['Name'], ENT_QUOTES); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="movie_id">Movie:</label>
    <select name="movie_id" required>
        <option value="">Select Movie</option>
        <?php foreach ($movies as $movie): ?>
            <option value="<?php echo htmlspecialchars($movie['Movie_ID'], ENT_QUOTES, 'UTF-8'); ?>">
                <?php echo htmlspecialchars_decode($movie['Title'], ENT_QUOTES); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="showtime">Show Time:</label>
    <input type="datetime-local" name="showtime" required>

    <button type="submit" name="add_screening" class="add-button">Add Screening</button>
</form>

<h2>Existing Screenings</h2>
<div id="screeningContainer">
    <?php foreach ($screenings as $screening): ?>
        <div class="screening-card">
            <form method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(generate_csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
                <input type="hidden" name="screening_id" value="<?php echo htmlspecialchars($screening['Screening_ID'], ENT_QUOTES, 'UTF-8'); ?>">

                <label for="cinemahall_id">Cinema Hall:</label>
                <select name="cinemahall_id" required>
                    <?php foreach ($cinemaHalls as $hall): ?>
                        <option value="<?php echo htmlspecialchars($hall['CinemaHall_ID'], ENT_QUOTES, 'UTF-8'); ?>" 
                            <?php echo $hall['CinemaHall_ID'] == $screening['CinemaHall_ID'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars_decode($hall['Name'], ENT_QUOTES); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="movie_id">Movie:</label>
                <select name="movie_id" required>
                    <?php foreach ($movies as $movie): ?>
                        <option value="<?php echo htmlspecialchars($movie['Movie_ID'], ENT_QUOTES, 'UTF-8'); ?>" 
                            <?php echo $movie['Movie_ID'] == $screening['Movie_ID'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars_decode($movie['Title'], ENT_QUOTES); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="showtime">Show Time:</label>
                <input type="datetime-local" name="showtime" value="<?php echo htmlspecialchars(date('Y-m-d\TH:i', strtotime($screening['ShowDate'] . ' ' . $screening['ShowTime'])), ENT_QUOTES, 'UTF-8'); ?>" required>

                <button type="submit" name="edit_screening" class="edit-button">Edit Screening</button>
                <button type="submit" name="delete_screening" class="delete-button">Delete Screening</button>
            </form>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>
