<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo $csrfToken; ?>">
    <title>Manage Messages</title>
    <link rel="stylesheet" href="/dwp/admin/assets/css/messages.css">
    <script src="/dwp/admin/assets/js/messages.js" defer></script>
</head>
<body>
<div class="container">
    
    <a href="/dwp/admin/dashboard" class="back-to-dashboard"><img src="../images/back-button.png" alt=""></a>

    <header>
        <h1>Manage Contact Messages</h1>
    </header>

    <?php
    if (isset($_SESSION['message'])) {
        echo '<div class="message">' . htmlspecialchars($_SESSION['message']) . '</div>';
        unset($_SESSION['message']);
    }
    ?>

    <section class="messages">
        <h2>Received Messages</h2>
        <table class="messages-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Submitted At</th>
                    <th>Reply</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($messages as $message): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($message['Name']); ?></td>
                        <td><?php echo htmlspecialchars($message['Email']); ?></td>
                        <td><?php echo htmlspecialchars($message['Subject']); ?></td>
                        <td><?php echo htmlspecialchars($message['Message']); ?></td>
                        <td><?php echo htmlspecialchars($message['Submitted_At']); ?></td>
                        <td>
                            <?php if ($message['Reply']): ?>
                                <span class="reply-text">Replied: <?php echo htmlspecialchars($message['Reply']); ?></span>
                            <?php else: ?>
                                <form method="POST" action="/dwp/admin/manage-messages/reply/<?php echo $message['Message_ID']; ?>">
                                    <textarea name="reply" placeholder="Write your reply..." required></textarea>
                                    <button type="submit" class="reply-button">Send Reply</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</div>
</body>
</html>