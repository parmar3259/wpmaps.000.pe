<?php include('./header.php');  ?>

<body>
    <?php include('./sidebar.php');  ?>

    <div class="main-content">
        <?php include('./navbar.php');  ?>

        <main>
            <div class="main">
                <div class="page-header">
                    <div class="content">
                        <h1>PAGENAME</h1>
                    </div>
                </div>

            </div>
            <section class="body">

                <?php


                include("../database/connection.php");

                $sql = "select * from login";

                if (mysqli_query($conn, $sql)) {
                }

                ?>


                <!-- code for use to make pages -->
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">name</th>
                            <th scope="col">email</th>
                            <th scope="col">Handle</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            // output data of each row
                            while ($row = $result->fetch_assoc()) {
                        ?>
                                <tr>
                                    <th scope="row"><?php echo $row["id"];   ?></th>
                                    <td><?php echo $row["fullname"];   ?></td>
                                    <td><?php echo $row["email"];   ?></td>
                                </tr>
                        <?php
                            }
                        }
                        ?>


                    </tbody>
                </table>



            </section>
        </main>
    </div>
    <label for="sidebar" class="body-label" id="body-label"></label>
</body>

</html>
<!-- partial -->
<script src="./assets/js/script.js"></script>

</body>

</html>