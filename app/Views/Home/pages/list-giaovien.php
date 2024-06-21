<!DOCTYPE html>
<html lang="en">
<style>
        .editable {
            padding: 8px;
            border: 1px solid #ddd;
        }
        .modall {
            display: none; 
            position: fixed; 
            z-index: 1; 
            left: 0;
            top: 0;
            width: 100%;
            height: 100%; 
            overflow: auto; 
            background-color: rgb(0,0,0); 
            background-color: rgba(0,0,0,0.4); 
            padding-top: 60px; 
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto; 
            padding: 20px;
            border: 1px solid #888;
            width: 80%; 
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Tables</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>



<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Danh Sách Giáo Viên</h1> 
    <!-- DataTales Example -->
    <button id="addRowBtn">Thêm hàng</button>
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Thêm Giáo Viên</h2>
            <form id="teacherForm">
                <label for="id">ID:</label><br>
                <input type="text" id="id" name="id"><br>
                <label for="name">Name:</label><br>
                <input type="text" id="name" name="name"><br>
                <label for="magiaovien">Ma Giao Vien:</label><br>
                <input type="text" id="magiaovien" name="magiaovien"><br>
                <label for="phone">Phone:</label><br>
                <input type="text" id="phone" name="phone"><br>
                <label for="trinhdo">Trinh Do:</label><br>
                <input type="text" id="trinhdo" name="trinhdo"><br>
                <label for="hinhanh">Hinh Anh:</label><br>
                <input type="text" id="hinhanh" name="hinhanh"><br><br>
                <label for="cn">Chuyên Ngành</label><br>
                <select id="cars">
                    <option value="volvo">Volvo</option>
                    <option value="saab">Saab</option>
                    <option value="opel">Opel</option>
                    <option value="audi">Audi</option>
                </select>
                <button type="button" id="saveBtn">Lưu</button>

            </form>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên Sinh Viên </th>
                            <th>Mã Giáo Viên </th>
                            <th>Số Điện Thoại</th>
                            <th>Trình Độ</th>
                            <th>Xóa</th>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>STT</th>
                            <th>Tên Sinh Viên </th>
                            <th>Mã Giáo Viên </th>
                            <th>Số Điện Thoại</th>
                            <th>Trình Độ</th>
                            <th>Xóa</th>

                        </tr>
                    </tfoot>
                    <tbody>
                            <?php foreach ($teachers as $teacher): ?>
                                <tr>
                                    <td class="editable" data-id="<?= $teacher['id'] ?>" data-field="id">
                                        <?= $teacher['id'] ?>
                                    </td>
                                    <td class="editable" data-id="<?= $teacher['id'] ?>" data-field="name">
                                        <?= $teacher['name'] ?>
                                    </td>
                                    <td class="editable" data-id="<?= $teacher['id'] ?>" data-field="magiaovien">
                                        <?= $teacher['magiaovien'] ?>
                                    </td>
                                    <td class="editable" data-id="<?= $teacher['id'] ?>" data-field="phone">
                                        <?= $teacher['phone'] ?>
                                    </td>
                                    <td class="editable" data-id="<?= $teacher['id'] ?>" data-field="trinhdo">
                                        <?= $teacher['trinhdo'] ?>
                                    </td>
                                    <td>
                                        <button class="delete-btn" data-id="<?= $teacher['id'] ?>">Xóa</button>
                                     </td>
                                </tr>
                            <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="vendor/datatables/jquery.dataTables.min.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<script src="js/demo/datatables-demo.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', (event) => {
    document.querySelectorAll('.editable').forEach(cell => {
        cell.addEventListener('click', function() {
            if (!this.querySelector('input')) {
                let currentText = this.textContent.trim();
                this.innerHTML = `<input type="text" value="${currentText}" style="width: ${this.offsetWidth}px;" />`;
                let input = this.querySelector('input');
                input.focus();

                input.addEventListener('blur', function() {
                    let newText = this.value.trim();
                    let cell = this.parentElement;
                    let id = cell.getAttribute('data-id');
                    let field = cell.getAttribute('data-field');

                    cell.textContent = newText;

                    // Gửi yêu cầu AJAX để cập nhật cơ sở dữ liệu
                    let xhr = new XMLHttpRequest();
                    xhr.open('POST', 'admin/teachers/update', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.send(`id=${id}&field=${field}&value=${newText}`);
                });
                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        this.blur();
                    }
                });
            }
        });
    });
});
var modal = document.getElementById("myModal");
var btn = document.getElementById("addRowBtn");
var span = document.getElementsByClassName("close")[0];
var saveBtn = document.getElementById("saveBtn");

// Khi người dùng bấm nút, mở modal
btn.onclick = function() {
    modal.style.display = "block";
}

// Khi người dùng bấm vào <span> (x), đóng modal
span.onclick = function() {
    modal.style.display = "none";
}

// Khi người dùng bấm vào bất cứ đâu bên ngoài modal, đóng modal
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

// Khi người dùng bấm nút lưu trong form
saveBtn.onclick = function() {
    // Lấy giá trị từ form
    var id = document.getElementById('id').value;
    var name = document.getElementById('name').value;
    var magiaovien = document.getElementById('magiaovien').value;
    var phone = document.getElementById('phone').value;
    var trinhdo = document.getElementById('trinhdo').value;
    var hinhanh = document.getElementById('hinhanh').value;

    // Tạo object chứa dữ liệu từ form
    var xhr = new XMLHttpRequest();
var url = "admin/teachers/addTeacher";
xhr.open("POST", url, true);
xhr.setRequestHeader("Content-Type", "application/json");

xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
        if (xhr.status === 200) {
            var data = JSON.parse(xhr.responseText);
            if (data.status === 200) {
                // Nếu thành công, thêm hàng mới vào bảng
                var tableBody = document.querySelector('#dataTable tbody');
                var newRow = document.createElement('tr');
                
                var fields = ['id', 'name', 'magiaovien', 'phone', 'trinhdo', 'hinhanh'];
                fields.forEach(function(field) {
                    var newCell = document.createElement('td');
                    newCell.classList.add('editable');
                    newCell.setAttribute('data-id', data.id); // Sử dụng id từ phản hồi
                    newCell.setAttribute('data-field', field);
                    newCell.textContent = formData[field]; // Đặt nội dung ô bằng giá trị từ form
                    newRow.appendChild(newCell);
                });
                
                tableBody.appendChild(newRow);
                // Đóng modal
                modal.style.display = "none";
                alert('Thêm thành công');
                // Reset form
                document.getElementById('teacherForm').reset();
            } else {
                alert('Có lỗi xảy ra khi thêm giáo viên: ' + data.message);
            }
        } else {
            alert('Đã có lỗi xảy ra khi gửi yêu cầu đến máy chủ.');
        }
    }
};

var formData = {
    id: id,
    name: name,
    magiaovien: magiaovien,
    phone: phone,
    trinhdo: trinhdo,
    hinhanh: hinhanh
};

xhr.send(JSON.stringify(formData));
}

</script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const deleteButtons = document.querySelectorAll(".delete-btn");

    deleteButtons.forEach(button => {
        button.addEventListener("click", function() {
            const teacherId = this.getAttribute("data-id");
            console.log(teacherId);
            // Thực hiện yêu cầu AJAX để xóa giáo viên
            fetch(`admin/deleteTeacher`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: `id=${teacherId}`
            })
            .then(response => response.json())
            .then(data => {
                console.log(data.success);
                if (data.success) {
                    
                    alert("xóa thành công");
                    // Xóa hàng trong bảng nếu xóa thành công
                    const row = this.closest("tr");
                    row.remove();
                } else {
                    alert("Xóa giáo viên không thành công.");
                }
            })
            .catch(error => {
                console.error("Lỗi:", error);
            });
        });
    });
});
</script>

</html>