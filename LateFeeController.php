<?php
require_once 'database.php';

class LateFeeController
{
    private $pdo;

    public function __construct()
    {
        $db = new Database();
        $this->pdo = $db->connect();
    }

    /**
     * Calculate late fees for overdue books.
     *
     * @return array
     */
    public function calculateLateFees()
    {
        $lateFees = [];

        // Query to find overdue reservations
        $query = "
            SELECT 
                r.id AS reservation_id, 
                m.name AS member_name, 
                b.title AS book_title, 
                r.due_date, 
                r.return_date, 
                TIMESTAMPDIFF(DAY, r.due_date, r.return_date) AS late_days
            FROM reservations r
            JOIN books b ON r.book_id = b.id
            JOIN members m ON r.member_id = m.id
            WHERE r.return_date > r.due_date";

        $stmt = $this->pdo->query($query);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Calculate late fees (assume $5 per late day)
        foreach ($results as $row) {
            $lateDays = $row['late_days'];
            $fee = $lateDays * 5.0; // $5 per day

            $lateFees[] = [
                'reservation_id' => $row['reservation_id'],
                'member_name' => $row['member_name'],
                'book_title' => $row['book_title'],
                'due_date' => $row['due_date'],
                'return_date' => $row['return_date'],
                'late_days' => $lateDays,
                'fee' => $fee,
            ];
        }

        return $lateFees;
    }
}

// Instantiate the controller and calculate late fees
$lateFeeController = new LateFeeController();
$lateFees = $lateFeeController->calculateLateFees();
?>
