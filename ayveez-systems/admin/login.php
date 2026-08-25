<?php

session_start();

include "../includes/db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    if (empty($email) || empty($password)) {

        $error = "Please enter email and password.";

    } else {

        $sql = "SELECT id, name, email, password
                FROM admins
                WHERE email = ?
                LIMIT 1";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param("s", $email);

        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows == 1) {

            $admin = $result->fetch_assoc();

            if (password_verify($password, $admin["password"])) {

                session_regenerate_id(true);

                $_SESSION["admin_id"] = $admin["id"];
                $_SESSION["admin_name"] = $admin["name"];
                $_SESSION["admin_email"] = $admin["email"];

                header("Location: dashboard.php");
                exit;

            } else {

                $error = "Invalid email or password.";

            }

        } else {

            $error = "Invalid email or password.";

        }

        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Admin Login | Ayveez Systems</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
rel="stylesheet">

<link rel="stylesheet" href="admin.css">

</head>

<body>

<div class="login-container">

    <div class="login-card">

        <div class="text-center mb-4">

            <h2>Ayveez Systems</h2>

            <p>Admin Portal</p>

        </div>

        <?php if (!empty($error)): ?>

            <div class="alert alert-danger">

                <?php echo htmlspecialchars($error); ?>

            </div>

        <?php endif; ?>

        <form method="POST">

            <div class="mb-3">

                <label class="form-label">
                    Email Address
                </label>

                <input
                    type="email"
                    name="email"
                    class="form-control"
                    placeholder="Enter your email"
                    required
                >

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Password
                </label>

                <input
                    type="password"
                    name="password"
                    class="form-control"
                    placeholder="Enter your password"
                    required
                >

            </div>

            <button type="submit" class="btn btn-primary w-100">

                Login

            </button>

        </form>

        <div class="text-center mt-4">

            <a href="../index.php">
                ← Back to Website
            </a>

        </div>

    </div>

</div>

</body>

</html>