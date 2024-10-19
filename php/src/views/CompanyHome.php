<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Job.php';

use config\Database;
use models\Job;


$database = new Database();
$conn = $database->getConnection();

$job = new Job($conn);

$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$jobs = $job->getJobs($limit, $offset);
$totalJobs = $job->getTotalJobs();
$totalPages = ceil($totalJobs / $limit);

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../public/CSS/global.css">
    <link rel="stylesheet" href="../public/CSS/CompanyHome.css">
    <title>Company Home</title>
</head>
<body>
<div class="flex flex-column justify-center items-center mt-4">
    <div class="flex">
        <h1>Job Listings</h1>
    </div>
    <div>
        <label for="comboBox">Choose an option:</label>
        <input list="options" id="comboBox" name="comboBox">
        <datalist id="options">
            <option value="Option 1">
            <option value="Option 2">
            <option value="Option 3">
        </datalist>
    </div>
    <div>
        <button class="btn">Search</button>
    </div>
    <div id="jobListings">
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Company</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($jobs as $job): ?>
                <tr>
                    <td><?php echo $job['id']; ?></td>
                    <td><?php echo $job['title']; ?></td>
                    <td><?php echo $job['company']; ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?page=<?php echo $page - 1; ?>">Previous</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?php echo $i; ?>" <?php if ($i == $page) echo 'class="active"'; ?>>
                <?php echo $i; ?>
            </a>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
            <a href="?page=<?php echo $page + 1; ?>">Next</a>
        <?php endif; ?>
    </div>
</div>

<script src="../public/JS/JobLazyLoad.js"></script>
</body>
</html>
