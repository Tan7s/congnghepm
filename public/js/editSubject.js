// CHỈNH SỬA VÀ UPDATE SUBJECT
document.addEventListener('DOMContentLoaded', (event) => {
    //Mở modal => Lấy dữ liệu phù hợp truyền lên modal
    document.querySelectorAll('.edit-button').forEach(button => {
        button.addEventListener('click', function () {
            const subjectId = this.getAttribute('data-id');
            const subjectName = this.getAttribute('data-name');
            const subjectCode = this.getAttribute('data-code');
            const subjectCredits = this.getAttribute('data-credits');
            const majorId = this.getAttribute('data-major-id');
            // Populate modal fields
            document.querySelector('#exampleModal input[name="subjectID"]').value = subjectId;
            document.querySelector('#exampleModal input[name="name"]').value = subjectName;
            document.querySelector('#exampleModal input[name="code"]').value = subjectCode;
            document.querySelector('#exampleModal input[name="credits"]').value = subjectCredits;

            // Filter and populate the select options
            const majorSelect = document.querySelector('#majorSelect');
            majorSelect.innerHTML = ''; // Clear previous options
            let tam = null;
            subjects.forEach(subject => {
                if (subject.major_id !== tam) {
                    const option = document.createElement('option');
                    option.value = subject.major_id;
                    option.text = subject.major_name;
                    if (subject.major_id === majorId) {
                        option.selected = true;
                    }
                    majorSelect.appendChild(option);
                    tam = subject.major_id;
                }
            });

            // Show modal
            $('#exampleModal').modal('show');
        });
    });

    //Lưu dữ liệu từ modal POST tới update
    const saveChangesButton = document.getElementById('saveChangesButton');
    saveChangesButton.addEventListener('click', function () {
        const form = document.getElementById('editSubjectForm');
        const formData = new FormData(form);
        const xhr = new XMLHttpRequest();

        //Validate sửa thông tin
        const name = formData.get('name');
        const code = formData.get('code');
        const credits = formData.get('credits');
        let isValid = true;
        let errorMessage = '';

        if (name.length < 10 || name.length > 30) {
            isValid = false;
            errorMessage += 'Tên môn học phải có chiều dài từ 10 đến 30 ký tự.\n';
        }

        if (code.length < 5 || code.length > 10) {
            isValid = false;
            errorMessage += 'Mã môn học phải có chiều dài từ 5 đến 10 ký tự.\n';
        }

        if (!/^\d+$/.test(credits) || credits < 1 || credits > 20) {
            isValid = false;
            errorMessage += 'Tín chỉ phải là số và phải từ 1 đến 20.\n';
        }

        if (!isValid) {
            alert(errorMessage);
            return;
        }

        // In dữ liệu trước khi gửi
        console.log('FormData entries:');
        for (let pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }

        xhr.open("POST", updateUrl, true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                console.log(response);
                // Update was successful, handle the response
                alert('Update successful');
                location.reload(); // Optionally reload the page to reflect changes
            } else {
                const response = JSON.parse(xhr.responseText);
                console.log(response);
                // console.error('Error response from server:', xhr.responseText);
                alert('Update failed');
            }
        };
        xhr.send(formData);
    });
});

//CLICK DELETE SUBJECT
$('.delete-subject-btn').click(function () {
    let url = $(this).data('url');
    console.log(url);
    if (!confirm('Dữ liệu sẽ bị xóa vĩnh viễn. Bạn có chắc muốn xóa không?')) {
        return;
    }
    window.location.href = url;
});

//CLICK DELETE SUBJECT
$('.delete-major-btn').click(function () {
    let url = $(this).data('url');
    console.log(url);
    if (!confirm('Dữ liệu sẽ bị xóa vĩnh viễn. Bạn có chắc muốn xóa không?')) {
        return;
    }
    window.location.href = url;
});

//CHỈNH SỬA VÀ UPDATE MAJOR
document.addEventListener('DOMContentLoaded', (event) => {
    //Mở modal => Lấy dữ liệu phù hợp truyền lên modal
    document.querySelectorAll('.edit-button-major').forEach(button => {
        button.addEventListener('click', function () {
            const majorName = this.getAttribute('data-name');
            const majorDescription = this.getAttribute('data-description');
            const majorId = this.getAttribute('data-major-id');
            console.log(majorId);
            // Populate modal fields
            document.querySelector('#exampleModal_major input[name="majorID"]').value = majorId;
            document.querySelector('#exampleModal_major input[name="major_name"]').value = majorName;
            document.querySelector('#exampleModal_major textarea[name="description"]').value = majorDescription;

            // Show modal
            $('#exampleModal_major').modal('show');
        });
    });

    //Lưu dữ liệu từ modal POST tới update
    const saveChangesButton = document.getElementById('saveChangesButton_major');
    saveChangesButton.addEventListener('click', function () {
        const form = document.getElementById('editMajorForm');
        const formData = new FormData(form);
        const xhr = new XMLHttpRequest();
        
        //Validate sửa thông tin
        const name = formData.get('major_name');
        const description = formData.get('description');
        let isValid = true;
        let errorMessage = '';

        if (name.length < 5 || name.length > 30) {
            isValid = false;
            errorMessage += 'Tên học phần phải có chiều dài từ 10 đến 30 ký tự.\n';
        }
        // console.log(description.length);
        if (description.length < 5 || description.length > 100) {
            isValid = false;
            errorMessage += 'Mô tả phải có chiều dài từ 5 đến 50 ký tự.\n';
        }

        if (!isValid) {
            alert(errorMessage);
            return;
        }

        // In dữ liệu trước khi gửi
        // console.log('FormData entries:');
        // for (let pair of formData.entries()) {
        //     console.log(pair[0] + ': ' + pair[1]);
        // }

        xhr.open("POST", updateUrl_major, true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                console.log(response);
                // Update was successful, handle the response
                alert('Update successful');
                location.reload(); // Optionally reload the page to reflect changes
            } else {
                const response = JSON.parse(xhr.responseText);
                console.log(response);
                // console.error('Error response from server:', xhr.responseText);
                alert('Update failed');
            }
        };
        xhr.send(formData);
    });
});

//ADD SUBJECT
document.addEventListener('DOMContentLoaded', (event) => {
    //Mở modal => Lấy dữ liệu phù hợp truyền lên modal
    document.querySelectorAll('.add-subject-button').forEach(button => {
        button.addEventListener('click', function () {
            // Filter and populate the select options
            const add_MajorSelect = document.querySelector('#add_MajorSelect');
            add_MajorSelect.innerHTML = ''; // Clear previous options
            let tam = null;
            subjects.forEach(subject => {
                if (subject.major_id !== tam) {
                    const option = document.createElement('option');
                    option.value = subject.major_id;
                    option.text = subject.major_name;
                    add_MajorSelect.appendChild(option);
                    tam = subject.major_id;
                }
            });

            // Show modal
            $('#addSubject').modal('show');
        });
    });

    //Lưu dữ liệu từ modal POST tới update
    const saveAddSubject = document.getElementById('saveAddSubject');
    saveAddSubject.addEventListener('click', function () {
        const form = document.getElementById('addSubjectForm');
        const formData = new FormData(form);
        const xhr = new XMLHttpRequest();

        //Validate sửa thông tin
        const name = formData.get('subject_name');
        const code = formData.get('code');
        const credits = formData.get('credits');
        let isValid = true;
        let errorMessage = '';

        subjects.forEach(subject => {
            if (name === subject.name) {
                isValid = false;
                errorMessage += 'Tên môn học đã tồn tại.\n';
            }
            if (code === subject.code) {
                isValid = false;
                errorMessage += 'Mã môn học đã tồn tại.\n';
            }
        });

        if (name.length < 10 || name.length > 30) {
            isValid = false;
            errorMessage += 'Tên môn học phải có chiều dài từ 10 đến 30 ký tự.\n';
        }

        if (code.length < 5 || code.length > 10) {
            isValid = false;
            errorMessage += 'Mã môn học phải có chiều dài từ 5 đến 10 ký tự.\n';
        }

        if (!/^\d+$/.test(credits) || credits < 1 || credits > 20) {
            isValid = false;
            errorMessage += 'Tín chỉ phải là số và phải từ 1 đến 20.\n';
        }

        if (!isValid) {
            alert(errorMessage);
            return;
        }

        // In dữ liệu trước khi gửi
        // console.log('FormData entries:');
        // for (let pair of formData.entries()) {
        //     console.log(pair[0] + ': ' + pair[1]);
        // }

        xhr.open("POST", addSubjectUrl, true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                console.log(response);
                // Update was successful, handle the response
                alert('Cập nhật thành công!');
                location.reload(); // Optionally reload the page to reflect changes
            } else {
                const response = JSON.parse(xhr.responseText);
                console.log(response);
                // console.error('Error response from server:', xhr.responseText);
                alert('Cập nhật thất bại');
            }
        };
        xhr.send(formData);
    });
});

//ADD MAJOR
document.addEventListener('DOMContentLoaded', (event) => {
    //Mở modal => Lấy dữ liệu phù hợp truyền lên modal
    document.querySelectorAll('.add-major-button').forEach(button => {
        button.addEventListener('click', function () {
            // Show modal
            $('#addMajorModal').modal('show');
        });
    });

    //Lưu dữ liệu từ modal POST tới update
    const saveAddMajor = document.getElementById('saveAddMajor');
    saveAddMajor.addEventListener('click', function () {
        const form = document.getElementById('addMajorForm');
        const formData = new FormData(form);
        const xhr = new XMLHttpRequest();

        //Validate sửa thông tin
        const name = formData.get('major_name');
        const description = formData.get('description');
        let isValid = true;
        let errorMessage = '';

        //Vòng lặp some dừng lại ngay khi thỏa mãn điều kiện
        if (subjects.some(subject => name === subject.major_name)) {
            isValid = false;
            errorMessage += 'Tên học phần đã tồn tại.\n';
        }
        

        if (name.length < 10 || name.length > 30) {
            isValid = false;
            errorMessage += 'Tên học phần phải có chiều dài từ 10 đến 30 ký tự.\n';
        }


        if (description.length < 5 || description.length > 100) {
            isValid = false;
            errorMessage += 'Mô tả phải có chiều dài từ 5 đến 50 ký tự.\n';
        }

        if (!isValid) {
            alert(errorMessage);
            return;
        }

        // In dữ liệu trước khi gửi
        // console.log('FormData entries:');
        // for (let pair of formData.entries()) {
        //     console.log(pair[0] + ': ' + pair[1]);
        // }

        xhr.open("POST", addMajorUrl, true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                console.log(response);
                // Update was successful, handle the response
                alert('Cập nhật thành công!');
                location.reload(); // Optionally reload the page to reflect changes
            } else {
                const response = JSON.parse(xhr.responseText);
                console.log(response);
                // console.error('Error response from server:', xhr.responseText);
                alert('Cập nhật thất bại');
            }
        };
        xhr.send(formData);
    });
});
