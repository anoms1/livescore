<?php
// Trigger an update for real-time refresh
file_put_contents('../viewer/last_update.txt', time());
echo json_encode(['success' => true, 'updated' => time()]);
?>