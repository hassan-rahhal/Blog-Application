<?php
move_uploaded_file($_FILES['test']['tmp_name'], "files/" . $_FILES['test']['name']);
?>