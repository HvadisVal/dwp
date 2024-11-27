
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Screenings</title>
    <link rel="stylesheet" href="/dwp/admin/screenings/screenings.css" />
</head>
<body>

<h1>Manage Screenings</h1>

<!-- Add Screening Section -->
<h2>Add New Screening</h2>
<form method="POST" class="screening-card">
    <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">

    <label for="cinemahall_id">Cinema Hall:</label>
    <select name="cinemahall_id" required>
        <option value="">Select Cinema Hall</option>
        <?php foreach ($cinemaHalls as $hall): ?>
            <option value="<?php echo $hall['CinemaHall_ID']; ?>"><?php echo htmlspecialchars($hall['Name']); ?></option>
        <?php endforeach; ?>
    </select>

    <label for="movie_id">Movie:</label>
    <select name="movie_id" required>
        <option value="">Select Movie</option>
        <?php foreach ($movies as $movie): ?>
            <option value="<?php echo $movie['Movie_ID']; ?>"><?php echo htmlspecialchars($movie['Title']); ?></option>
        <?php endforeach; ?>
    </select>

    <label for="showtime">Show Time:</label>
    <input type="datetime-local" name="showtime" required>

    <button type="submit" name="add_screening" class="add-button">Add Screening</button>
</form>

<!-- Existing Screenings Section -->
<h2>Existing Screenings</h2>
<div id="screeningContainer">
    <?php foreach ($screenings as $screening): ?>
        <div class="screening-card">
            <form method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                <input type="hidden" name="screening_id" value="<?php echo $screening['Screening_ID']; ?>">

                <label for="cinemahall_id">Cinema Hall:</label>
                <select name="cinemahall_id" required>
                    <?php foreach ($cinemaHalls as $hall): ?>
                        <option value="<?php echo $hall['CinemaHall_ID']; ?>" <?php echo $hall['CinemaHall_ID'] == $screening['CinemaHall_ID'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($hall['Name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="movie_id">Movie:</label>
                <select name="movie_id" required>
                    <?php foreach ($movies as $movie): ?>
                        <option value="<?php echo $movie['Movie_ID']; ?>" <?php echo $movie['Movie_ID'] == $screening['Movie_ID'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($movie['Title']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="showtime">Show Time:</label>
                <input type="datetime-local" name="showtime" value="<?php echo date('Y-m-d\TH:i', strtotime($screening['ShowDate'] . ' ' . $screening['ShowTime'])); ?>" required>

                <button type="submit" name="edit_screening" class="edit-button">Edit Screening</button>
                <button type="submit" name="delete_screening" class="delete-button">Delete Screening</button>
            </form>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>