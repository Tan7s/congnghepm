<style>
    form {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
        border-radius: 10px;
        background-color: #f9f9f9;
        display: none;
    }

    .form-group {
        margin-bottom: 15px;
    }

    label {
        display: block;
        margin-bottom: 5px;
    }

    select,
    input[type="date"],
    input[type="time"] {
        width: 100%;
        padding: 8px;
        box-sizing: border-box;
    }

    button {
        padding: 10px 15px;
        background-color: #007BFF;
        border: none;
        color: white;
        cursor: pointer;
    }

    button:hover {
        background-color: #0056b3;
    }

    .early-morning {
        background-color: blue;
        /* Màu khi trước 7 giờ sáng hoặc sau 13:30 */
        color: white;
    }

    .default {
        background-color: green;
        /* Màu mặc định */
        color: white;
    }

    .disabled {
        pointer-events: none;
        cursor: not-allowed;
        opacity: 0.6;
        /* Giảm độ sáng để chỉ ra rằng thẻ bị vô hiệu hóa */
    }
</style>
<div class="container-fluid">
    <?php
    if (session()->get('user_login')['type'] == 'admin'): // Sử dụng dấu ':' để mở câu lệnh điều kiện
        ?>
        <button id="addLichhoc">Thêm lịch học</button>
        <form id="formAdd" action="admin/home/submit-form" method="post">
            <span class="close">&times;</span>
            <div class="form-group">
                <label for="class">Lớp:</label>
                <select id="class" name="class">
                    <?php foreach ($class as $cl): ?>
                        <option value="<?= $cl['id'] ?>"><?= $cl['nameClass'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="form-group">
                <label for="teacher">Giáo viên:</label>
                <select id="teacher" name="teacher">
                    <?php foreach ($teacher as $tc): ?>
                        <option value="<?= $tc['id'] ?>"><?= $tc['name'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="form-group">
                <label for="subject">Môn học:</label>
                <select id="subject" name="subject">
                    <?php foreach ($subject as $sj): ?>
                        <option value="<?= $sj['id'] ?>"><?= $sj['name'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="form-group">
                <label for="date">Ngày tháng:</label>
                <input type="date" id="date" name="date">
            </div>

            <div class="form-group">
                <label for="start_time">Thời gian bắt đầu:</label>
                <input type="time" id="start_time" name="start_time">
            </div>

            <div class="form-group">
                <label for="end_time">Thời gian kết thúc:</label>
                <input type="time" id="end_time" name="end_time">
            </div>
            <div class="form-group">
                <label for="buoi">Buổi Học:</label>
                <select id="buoi" name="buoi">
                    <option value="Sáng">Sáng</option>
                    <option value="Chiều">Chiều</option>
                </select>
            </div>
            <button type="submit">Submit</button>
        </form>
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Môn</th>
                                <th>Lớp</th>
                                <th>Ngày</th>
                                <th>Thời Gian</th>
                                <th>Buổi Học</th>
                                <th>Giảng Viên</th>
                                <th>Xóa</th>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Môn</th>
                                <th>Lớp</th>
                                <th>Ngày</th>
                                <th>Thời Gian</th>
                                <th>Buổi Học</th>
                                <th>Giảng Viên</th>
                                <th>Xóa</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php foreach ($schedule as $sc): ?>
                                <tr>
                                    <td class="editable" data-id=" data-field=" id">
                                        <?= $sc['subject_name'] ?>
                                    </td>
                                    <td class="editable" data-id="" data-field="name">
                                        <?= $sc['nameClass'] ?>
                                    </td>
                                    <td class="editable" data-id="" data-field="magiaovien">
                                        <?= $sc['date'] ?>
                                    </td>
                                    <td class="editable" data-id="" data-field="phone">
                                        <?= $sc['timeStar'] ?> - <?= $sc['timeEnd'] ?>
                                    </td>
                                    <td class="editable" data-id="" data-field="trinhdo">
                                        <?= $sc['buoi'] ?>
                                    </td>
                                    <td class="editable" data-id="" data-field="trinhdo">
                                        <?= $sc['teacher_name'] ?>
                                    </td>
                                    <td>
                                        <button class="delete-btn" data-id="<?= $sc['id_lichhoc'] ?>">Xóa</button>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; // Sử dụng 'endif' để đóng câu lệnh điều kiện ?>
    <div class="container mt-5 ">
        <h2 class="text-center mb-4">Lịch Học</h2>
        <div class="row row-schedule-list">
            <?php
            $currentDate = date('Y-m-d'); // Lấy ngày hiện tại
            
            foreach ($schedule as $sc):
                if (isset($code[0])) {
                    if (
                        session()->get('user_login')['type'] != 'admin' &&
                        (
                            (array_key_exists('class_id', $code[0]) && $code[0]['class_id'] == $sc['idClass']) ||
                            (array_key_exists('id_teacher', $code[0]) && $code[0]['id_teacher'] == $sc['id_teacher'])
                        )
                    ) {
                        // Kiểm tra nếu ngày trong $sc['date'] đã quá ngày hiện tại
                        if (strtotime($sc['date']) < strtotime($currentDate)) {
                            continue; // Bỏ qua phần tử này
                        }
                        ?>
                        <div class="col-md-4 mb-4">
                            <div class="card bg-lightblue">

                                <div class="card-header col-md-12">
                                    <div class="col-md-4 img_header">
                                        <img class="card-img-top"
                                            src="https://daotao.tnpc.edu.vn/public/template/default/black/images/BKTN111.png"
                                            alt="Card image">
                                    </div>
                                    <div class="col-md-8 title_header">
                                        <p class="card-text badge text-wrap text_header">Môn: <?= $sc['subject_name'] ?></p>
                                        <p class="card-text"><?= $sc['nameClass'] ?></p>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="card-info">
                                        <div class="card bg-lightblue col-md-12 row_card">
                                            <div class="card bg-lightblue col-md-6 row_card_chill">
                                                <p class="card-text">Ngày:</p>
                                            </div>
                                            <div class="card bg-lightblue col-md-6 row_card_chill">
                                                <p class="card-text"><?= $sc['date'] ?></p>
                                            </div>
                                        </div>
                                        <div class="card bg-lightblue col-md-12 row_card">
                                            <div class="card bg-lightblue col-md-6 row_card_chill">
                                                <p class="card-text">Thời Gian: </p>
                                            </div>
                                            <div class="card bg-lightblue col-md-6 row_card_chill">
                                                <p class="card-text"><?= $sc['timeStar'] ?> - <?= $sc['timeEnd'] ?></p>
                                            </div>
                                        </div>
                                        <div class="card bg-lightblue col-md-12 row_card">
                                            <div class="card bg-lightblue col-md-6 row_card_chill">
                                                <p class="card-text">Buổi Học</p>
                                            </div>
                                            <div class="card bg-lightblue col-md-6 row_card_chill">
                                                <p class="card-texts"><?= $sc['buoi'] ?></p>
                                            </div>
                                        </div>
                                        <div class="card bg-lightblue col-md-12 row_card">
                                            <div class="card bg-lightblue col-md-6 row_card_chill">
                                                <p class="card-text">Giảng Viên:</p>
                                            </div>
                                            <div class="card bg-lightblue col-md-6 row_card_chill">
                                                <p class="card-text"><?= $sc['teacher_name'] ?></p>
                                            </div>
                                        </div>
                                        <a href="admin/diemdanh/<?= $sc['id_lichhoc'] ?>"
                                            class="btn btn-success col-md-12 btn_custom default" id="btn_join">Tham Gia</a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    <?php }
                }
                ;
            endforeach ?>
            <!-- Add more boxes as needed -->
        </div>
    </div>
    <style>
        .row_card {
            display: flex;
            flex-direction: row;
        }

        .row_card_chill {
            border: none;
            padding: 10px;
        }

        .card-header {
            display: flex;
            background-color: #a0d2eb;
            color: #003366;
        }

        .card-img-top {
            width: 100%;
        }

        .title_header {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-size: 20px;
        }

        .img_header {
            padding: 0px !important;
        }

        .text_header {
            font-size: 113%;
            color: #003366;
        }

        .card {
            background-color: #e6f7ff;
            color: #003366;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            margin-top: 15px;
        }

        .btn-success:hover {
            background-color: #218838;
            color: white;
        }
    </style>


</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    var modal = document.getElementById("formAdd");
    var btn = document.getElementById("addLichhoc");
    var span = document.getElementsByClassName("close")[0];
    btn.onclick = function () {
        modal.style.display = "block";
    }

    // Khi người dùng bấm vào <span> (x), đóng modal
    span.onclick = function () {
        modal.style.display = "none";
    }

    // Khi người dùng bấm vào bất cứ đâu bên ngoài modal, đóng modal
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    $(document).ready(function () {
        $('#formAdd').on('submit', function (event) {
            event.preventDefault(); // Ngăn chặn việc gửi form thông thường

            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: $(this).serialize(),
                success: function (response) {
                    alert(response.message);
                    loadScheduleList();
                },
                error: function (xhr, status, error) {
                    // Xử lý lỗi
                    alert('An error occurred');
                    console.log(xhr.responseText);
                }
            });
        });
    });
    function loadScheduleList() {
        $.ajax({
            url: '<?= base_url('home/t') ?>', // Thay đổi đường dẫn và phương thức tương ứng
            method: 'GET',
            success: function (response) {
                // Thêm nội dung mới vào cuối danh sách
                $('.schedule-list').append(response);
            },
            error: function (xhr, status, error) {
                // Xử lý khi load danh sách lịch học bị lỗi
                console.error('Đã xảy ra lỗi: ' + error);
            }
        });
    }
    $(document).ready(function () {
        // Function to change the link color and disable based on time
        function updateLinkColorAndState() {
            var currentDate = new Date();
            var currentHour = currentDate.getHours();
            var currentMinutes = currentDate.getMinutes();

            $('.card').each(function () {
                var buoi = $(this).find('.card-texts').text().trim().toLowerCase();
                var joinButton = $(this).find('.btn_custom');
                console.log()
                if (buoi === 'sáng') {
                    if (currentHour < 7) {
                        joinButton.addClass('disabled');
                        joinButton.text('chưa tới giờ');
                    } else if (currentHour >= 11) {
                        joinButton.addClass('disabled');
                        joinButton.text('Đã hết thời gian');
                    }
                    else {
                        joinButton.removeClass('disabled');
                    }
                } else if (buoi === 'chiều') {
                    if (currentHour < 13 || (currentHour === 13 && currentMinutes < 30)) {
                        joinButton.addClass('disabled');
                        joinButton.text('chưa tới giờ');
                    } else if (currentHour >= 17) {
                        joinButton.addClass('disabled');
                        joinButton.text('Đã hết thời gian');
                    }
                    else {
                        joinButton.removeClass('disabled');
                    }
                }

                // Set color classes based on buổi
                if (currentHour < 7 || currentHour >= 13.5 && buoi === 'sáng') {
                    joinButton.addClass('early-morning');
                    joinButton.removeClass('default');
                } else {
                    joinButton.addClass('default');
                    joinButton.removeClass('early-morning');
                }
            });
        }

        // Initial call to update link colors and state
        updateLinkColorAndState();

    });

</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const deleteButtons = document.querySelectorAll(".delete-btn");

        deleteButtons.forEach(button => {
            button.addEventListener("click", function () {
                const scheduleId = this.getAttribute("data-id");
                console.log(scheduleId);
                // Thực hiện yêu cầu AJAX để xóa giáo viên
                fetch(`admin/deleteSchedule`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: `id=${scheduleId}`
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
                            alert("Xóa lịch thành công");
                        }
                    })
                    .catch(error => {
                        console.error("Lỗi:", error);
                    });
            });
        });
    });
</script>

<!-- /.container-fluid -->