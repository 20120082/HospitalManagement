<?php
// Chỉ render phần tbody cho AJAX
if (empty($medicines)) {
    echo '<tr><td colspan="10" class="text-center">No medicines found</td></tr>';
} else {
    foreach ($medicines as $medicine) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($medicine->id) . '</td>';
        echo '<td>' . htmlspecialchars($medicine->code) . '</td>';
        echo '<td>' . htmlspecialchars($medicine->name) . '</td>';
        echo '<td>' . htmlspecialchars($medicine->category) . '</td>';
        echo '<td>' . htmlspecialchars($medicine->description) . '</td>';
        echo '<td>' . htmlspecialchars($medicine->unit) . '</td>';
        echo '<td>' . htmlspecialchars($medicine->price) . '</td>';
        echo '<td>' . htmlspecialchars($medicine->quantity) . '</td>';
        echo '<td>' . htmlspecialchars($medicine->manufacturer) . '</td>';
        echo '<td>' . htmlspecialchars($medicine->expiryDate) . '</td>';
        echo '<td>';
        echo '<a href="index.php?controller=Medicine&action=UpdatePage&id=' . $medicine->id . '" class="btn btn-warning btn-sm">Edit</a> ';
        echo '<a href="index.php?controller=Medicine&action=DeletePage&id=' . $medicine->id . '" class="btn btn-danger btn-sm">Delete</a>';
        echo '</td>';
        echo '</tr>';
    }
}
