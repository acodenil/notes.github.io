<?php
$succ_alert = false;
$update_alert = false;
$fail_alert = false;
$del_alert = false;
$server = "localhost";
$username = "root";
$password = "";
$database = "notes";

$con = mysqli_connect($server, $username, $password, $database);
if (!$con)
    die("Nhi hua coonect");

//for insertion
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['snoEdit'])) {
        $snoEdit = $_POST['snoEdit'];
        $title = $_POST['titleEdit'];
        $description = $_POST['descriptionEdit'];
        $sql = "UPDATE `notes` SET `title` = '$title', `description` = '$description' WHERE `notes`.`sno` = $snoEdit";
        if (mysqli_query($con, $sql)) {
            $update_alert = true;
            echo '<script>window.location=  "index.php"</script>';
        } else
        $fail_alert = true;
    } else if (isset($_POST['snoDel'])) {
        $snoDel = $_POST['snoDel'];
        $sql = "DELETE FROM `notes` WHERE `notes`.`sno` = '$snoDel'";
        if (mysqli_query($con, $sql)) {
            $del_alert = true;
            echo '<script>window.location=  "index.php"</script>';
        } else
            $fail_alert = true;
    } else if($_POST['title']){
        $title = $_POST['title'];
        $description = $_POST['description'];
        $sql = "INSERT INTO `notes` (`title`, `description`) VALUES ('$title', '$description')";
        if (mysqli_query($con, $sql)) {
            $succ_alert = true;
            echo '<script>window.location="index.php"</script>';
        } else
            $fail_alert = true;
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Notes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.1.js"
        integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <style>
        #delform {
            display: none;
        }
    </style>
</head>

<body>
    <!-- Button trigger modal -->


    <!-- Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="index.php" method="post">
                        <input type="hidden" id="snoEdit" name="snodit">
                        <div class="mb-3">
                            <label for="title" class="form-label" style="font-size:25px;">Title</label>
                            <input type="text" class="form-control" id="titleEdit" name="titleEdit">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label" style="font-size:25px;">Description</label>
                            <textarea class="form-control" id="descriptionEdit" name="descriptionEdit"
                                rows="3"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <?php
    if ($succ_alert) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success! </strong>Your note has been saved successfully
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
    }
    if ($fail_alert) {
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>Sorry! </strong>Your note has NOT been saved successfully
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
    }
    if ($update_alert) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success! </strong>Your note has been updated successfully
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
    }
    if ($del_alert) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success! </strong>Your note has been deleted successfully
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
    }
    ?>
    <div class="container" style="width:50%;">

        <h1 style="text-align: center;">You can make Notes Here!</h1>
        <form action="index.php" method="post" id='form'>
            <div class="mb-3">
                <label for="title" class="form-label" style="font-size:25px;">Title</label>
                <input type="text" class="form-control" id="title" name="title">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label" style="font-size:25px;">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary" id='submitbtn'>Submit</button>
            </div>


        </form>
        <form action='index.php' method='post' id='delform'>
            <input type='hidden' id='snoDel' name='snoDel'>
            <button type="submit" id='delbtn'></button>
        </form>
        <div class="tblcont my-4">
            <table class='table my-4' id="myTable">
                <thead>
                    <tr>
                        <th scope='col'>SNO</th>
                        <th scope='col'>TITLE</th>
                        <th scope='col'>DESCRIPTION</th>
                        <th scope='col'>ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    $sql = "SELECT * FROM `notes`";
                    $result = mysqli_query($con, $sql);
                    $sno = 0;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $sno += 1;
                        echo "<tr>
                        <th scope='row'>" . $sno . "</th>
                        <td>" . $row['title'] . "</td>
                        <td>" . $row['description'] . "</td>
                        <td><button class='edit btn btn-primary' id=" . $row['sno'] . ">Edit</button>
                        <button class='delete btn btn-primary' id=" . $row['sno'] . ">Delete</button>
                        </td>
                        </tr>";
                        //     <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#editModal'>
                        //     Edit type='submit' 
                        //   </button>
                        //  
                    }
                    echo "</tbody>
                    </table>";
                    ?>
        </div>
    </div>
    <?php

    ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V"
        crossorigin="anonymous"></script>
    <script>
        $(document).ready(function () {
            $('#myTable').DataTable();
        });
    </script>
    <script>
        edits = document.getElementsByClassName('edit');
        Array.from(edits).forEach((element) => {
            element.addEventListener("click", (e) => {
                row = e.target.parentNode.parentNode;
                console.log('edit ', e.target.parentNode.parentNode);
                title = row.getElementsByTagName('td')[0].innerText;
                description = row.getElementsByTagName('td')[1].innerText;
                console.log(title, description);
                titleEdit.value = title;
                descriptionEdit.value = description;
                snoEdit.value = e.target.id;
                console.log(snoEdit.value);
                $('#editModal').modal('toggle');
            })
        })
        deletes = document.getElementsByClassName('delete');
        Array.from(deletes).forEach((element) => {
            element.addEventListener("click", (e) => {
                row = e.target.parentNode.parentNode;
                console.log('delete ', e.target.parentNode.parentNode);
                snoDel.value = e.target.id;
                console.log('target id',snoDel.value);
                yesno=confirm("You really want to delete ?");
                if(yesno){
                    document.getElementById('delbtn').click();
                }
            })
        })
    </script>
</body>

</html>