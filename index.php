<!DOCTYPE html>
<html>

<head>
    <title>AJAX CRUD Operation</title>

    <style>

        body {
            font-family: Arial;
            margin: 40px;
        }

        input {
            padding: 8px;
            margin: 5px;
            width: 250px;
        }

        button {
            padding: 8px 15px;
            margin: 5px;
            cursor: pointer;
        }

        table {
            border-collapse: collapse;
            margin-top: 25px;
            width: 700px;
        }

        th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }

        #message {
            margin-top: 15px;
            font-weight: bold;
        }

    </style>
</head>

<body>

    <h2>Student Management System</h2>

    <!-- Student Form -->
    <form id="studentForm">

        <input type="hidden" id="id">

        <input type="text"
               id="name"
               placeholder="Enter Name"
               required>

        <br>

        <input type="email"
               id="email"
               placeholder="Enter Email"
               required>

        <br>

        <input type="text"
               id="phone"
               placeholder="Enter Phone"
               required>

        <br>

        <button type="submit" id="submitButton">
            Add Student
        </button>

        <button type="button" onclick="clearForm()">
            Clear
        </button>

    </form>


    <p id="message"></p>


    <!-- Student Records -->
    <h3>Student Records</h3>

    <table>

        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody id="studentTable">
        </tbody>

    </table>


    <script>

        // ==================== READ ====================

        // Load students from database using AJAX
        function loadStudents() {

            let formData = new FormData();

            formData.append("action", "read");

            fetch("api.php", {
                method: "POST",
                body: formData
            })

            .then(response => response.json())

            .then(data => {

                let table = document.getElementById("studentTable");

                table.innerHTML = "";

                data.forEach(student => {

                    table.innerHTML += `
                        <tr>
                            <td>${student.id}</td>
                            <td>${student.name}</td>
                            <td>${student.email}</td>
                            <td>${student.phone}</td>

                            <td>
                                <button onclick="editStudent(
                                    ${student.id},
                                    '${student.name}',
                                    '${student.email}',
                                    '${student.phone}'
                                )">
                                    Edit
                                </button>

                                <button onclick="deleteStudent(${student.id})">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    `;
                });
            });
        }


        // ==================== CREATE / UPDATE ====================

        document.getElementById("studentForm")
        .addEventListener("submit", function(event) {

            // Prevent page reload
            event.preventDefault();

            let id = document.getElementById("id").value;
            let name = document.getElementById("name").value;
            let email = document.getElementById("email").value;
            let phone = document.getElementById("phone").value;

            let formData = new FormData();

            // Decide whether this is Create or Update
            if (id == "") {
                formData.append("action", "create");
            } else {
                formData.append("action", "update");
                formData.append("id", id);
            }

            formData.append("name", name);
            formData.append("email", email);
            formData.append("phone", phone);


            // Send data using AJAX
            fetch("api.php", {
                method: "POST",
                body: formData
            })

            .then(response => response.text())

            .then(data => {

                document.getElementById("message").innerHTML = data;

                // Clear form
                clearForm();

                // Refresh table without reloading page
                loadStudents();
            });

        });


        // ==================== EDIT ====================

        function editStudent(id, name, email, phone) {

            // Put existing values into form
            document.getElementById("id").value = id;
            document.getElementById("name").value = name;
            document.getElementById("email").value = email;
            document.getElementById("phone").value = phone;

            // Change button text
            document.getElementById("submitButton")
                .innerHTML = "Update Student";
        }


        // ==================== DELETE ====================

        function deleteStudent(id) {

            if (!confirm("Are you sure you want to delete this student?")) {
                return;
            }

            let formData = new FormData();

            formData.append("action", "delete");
            formData.append("id", id);


            // Send delete request using AJAX
            fetch("api.php", {
                method: "POST",
                body: formData
            })

            .then(response => response.text())

            .then(data => {

                document.getElementById("message").innerHTML = data;

                // Reload records without refreshing page
                loadStudents();
            });
        }


        // ==================== CLEAR FORM ====================

        function clearForm() {

            document.getElementById("id").value = "";
            document.getElementById("name").value = "";
            document.getElementById("email").value = "";
            document.getElementById("phone").value = "";

            document.getElementById("submitButton")
                .innerHTML = "Add Student";
        }


        // Load records when page opens
        loadStudents();

    </script>

</body>
</html>