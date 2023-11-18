<?php
require_once '../app.php';
include_once "$dir/partial/header.php";

?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h1>Dashboard</h1>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $mediaCounts = getMediaCounts();
                        $userCount = getUserCount();

                        foreach ($mediaCounts as $count) {
                            echo '<tr>';
                            echo '<td>' . $count->media_type . '</td>';
                            echo '<td>' . $count->count . '</td>';
                            echo '</tr>';
                        }
                        echo '<tr>';
                        echo '<td>Users</td>';
                        echo '<td>' . $userCount . '</td>';
                        echo '</tr>';
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<div style="width: 500px;">
    <canvas id="myChart"></canvas>
</div>



<?php

include_once "$dir/partial/footer.php";
