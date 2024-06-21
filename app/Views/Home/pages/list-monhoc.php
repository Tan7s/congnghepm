<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Danh Sách Môn học</h1>
    <button class="add-subject-button btn btn-success btn-sm rounded-0 edit-btn" 
        type="button" data-toggle="modal" 
        data-target="#addSubject">Thêm môn học
    </button>
    <button class="add-major-button btn btn-primary btn-sm rounded-0 edit-btn" 
        type="button" data-toggle="modal" 
        data-target="#addMajorModal">Thêm học phần
    </button>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
            <?= view('message/message') ?>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên Học Phần </th>
                            <th>Tên Môn Học </th>
                            <th>Mã Môn Học </th>
                            <th>Tín chỉ</th>
                            <th>Chức năng môn học</th>
                            <th>Chức năng học phần</th>
                    </thead>
                    <tbody>
                        <?php
                        $stt = 1;
                        $currentMajorId = null;
                        $rowspan = 0;
                        foreach ($subjects as $subject) :
                            if ($subject['major_id'] !== $currentMajorId) {
                                $currentMajorId = $subject['major_id'];
                                $rowspan = count(array_filter($subjects, function ($sj) use ($currentMajorId) {
                                    return $sj['major_id'] === $currentMajorId;
                                }));
                        ?>
                                <tr>
                                    <td style="align-content: center; text-align:center" rowspan="<?= $rowspan ?>"><?= $stt++ ?></td>
                                    <td class="editable" style="align-content: center; text-align:center" rowspan="<?= $rowspan ?>"><?= $subject['major_name'] ?></td>
                                    <td class="editable"><?= $subject['name'] ?></td>
                                    <td class="editable"><?= $subject['code'] ?></td>
                                    <td class="editable"><?= $subject['credits'] ?></td>
                                    <?php if($subject['id'] != null): ?> 
                                    <td>
                                        <ul class="list-inline m-0">
                                            <li class="list-inline-item">
                                                <button class="edit-button btn btn-info btn-sm rounded-0 edit-btn" type="button" 
                                                    data-id="<?= $subject['id'] ?>" 
                                                    data-name="<?= $subject['name'] ?>" 
                                                    data-code="<?= $subject['code'] ?>" 
                                                    data-credits="<?= $subject['credits'] ?>" 
                                                    data-major-id="<?= $subject['major_id'] ?>"
                                                    data-toggle="modal" 
                                                    data-target="#exampleModal"><i class="fa fa-edit"></i>
                                                </button>
                                            </li>
                                            <li class="list-inline-item">
                                                <button class="delete-subject-btn btn btn-secondary btn-sm rounded-0" type="button" 
                                                data-toggle="tooltip" data-placement="top" 
                                                data-url="<?= base_url() ?>admin/subject/delete/<?= $subject['id'] ?>"
                                                title="Delete"><i class="fa fa-trash"></i>
                                            </button>
                                            </li>
                                        </ul>
                                    </td>
                                    <?php else: ?>
                                    <td></td>
                                    <?php endif ?>
                                    <td rowspan="<?= $rowspan ?>" style="align-content: center; text-align:center">
                                        <ul class="list-inline m-0">
                                            <li class="list-inline-item">
                                                <button class="edit-button-major btn btn-success btn-sm rounded-0 edit-btn" type="button"
                                                    data-name="<?= $subject['major_name'] ?>"
                                                    data-description="<?= $subject['description'] ?>" 
                                                    data-major-id="<?= $subject['major_id'] ?>"
                                                    data-toggle="modal" 
                                                    data-target="#exampleModal_major"><i class="fa fa-edit"></i>
                                                </button>
                                            </li>
                                            <li class="list-inline-item">
                                                <button class="delete-major-btn btn btn-danger btn-sm rounded-0" type="button" 
                                                data-toggle="tooltip" data-placement="top" 
                                                data-url="<?= base_url() ?>admin/major/delete/<?= $subject['major_id'] ?>"
                                                title="Delete"><i class="fa fa-trash"></i>
                                            </button>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            <?php } else { ?>
                                <tr>
                                    <td class="editable"><?= $subject['name'] ?></td>
                                    <td class="editable"><?= $subject['code'] ?></td>
                                    <td class="editable"><?= $subject['credits'] ?></td>
                                    <td>
                                        <ul class="list-inline m-0">
                                            <li class="list-inline-item">
                                                <button class="edit-button btn btn-info btn-sm rounded-0 edit-btn" type="button" 
                                                    data-id="<?= $subject['id'] ?>" 
                                                    data-name="<?= $subject['name'] ?>" 
                                                    data-code="<?= $subject['code'] ?>" 
                                                    data-credits="<?= $subject['credits'] ?>" 
                                                    data-major-id="<?= $subject['major_id'] ?>"
                                                    data-toggle="modal" 
                                                    data-target="#exampleModal"><i class="fa fa-edit"></i>
                                                </button>
                                            </li>
                                            </li>
                                            <li class="list-inline-item">
                                                <button class="delete-subject-btn btn btn-secondary btn-sm rounded-0" type="button" 
                                                data-url="<?= base_url() ?>admin/subject/delete/<?= $subject['id'] ?>"
                                                title="Delete"><i class="fa fa-trash"></i>
                                            </button>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- MODAL SUBJECT -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Chỉnh sửa môn học</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editSubjectForm" method="Post">
                    <input type="hidden" name="subjectID">
                    <div class="form-group">
                        <label for="name">Tên môn học</label>
                        <input id="name" name="name" value="">
                    </div>
                    <div class="form-group">
                        <label for="code">Code</label>
                        <input id="code" name="code" value="">
                    </div>
                    <div class="form-group">
                        <label for="credits">Tín chỉ</label>
                        <input id="credits" name="credits" value="">
                    </div>
                    <div class="form-group">
                        <label for="major">Thuộc học phần:</label>
                        <select id="majorSelect" name="major_id">
                            <!-- Options will be populated dynamically -->
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="button" id="saveChangesButton" class="btn btn-primary save-changes">Lưu thay đổi</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL THÊM MÔN HỌC -->
<div class="modal fade" id="addSubject" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Thêm môn học</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addSubjectForm" method="Post">
                    <div class="form-group">
                        <label for="subject_name">Tên môn học</label>
                        <input id="subject_name" name="subject_name" value="">
                    </div>
                    <div class="form-group">
                        <label for="code">Code</label>
                        <input id="code" name="code" value="">
                    </div>
                    <div class="form-group">
                        <label for="credits">Tín chỉ</label>
                        <input id="credits" name="credits" value="">
                    </div>
                    <div class="form-group">
                        <label for="add_MajorSelect">Thuộc học phần:</label>
                        <select id="add_MajorSelect" name="add_MajorSelect">
                            <!-- Options will be populated dynamically -->
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="button" id="saveAddSubject" class="btn btn-primary save-changes">Lưu thay đổi</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL MAJOR -->
<div class="modal fade" id="exampleModal_major" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Chỉnh sửa học phần</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editMajorForm" method="Post">
                    <input type="hidden" name="majorID">
                    <div class="form-group">
                        <label for="major_name">Tên học phần</label>
                        <input id="major_name" name="major_name" value="">
                    </div>
                    <div class="form-group">
                        <label for="description">Mô tả</label>
                        <textarea rows="5" cols="30" id="description" name="description" value=""></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="button" id="saveChangesButton_major" class="btn btn-primary save-changes">Lưu thay đổi</button>
            </div>
        </div>
    </div>
</div>

<!-- ADD MAJOR MODAL -->
<div class="modal fade" id="addMajorModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Chỉnh sửa học phần</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addMajorForm" method="Post">
                    <div class="form-group">
                        <label for="major_name">Tên học phần</label>
                        <input id="major_name" name="major_name" value="">
                    </div>
                    <div class="form-group">
                        <label for="description">Mô tả</label>
                        <textarea rows="5" cols="30" id="description" name="description" value=""></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="button" id="saveAddMajor" class="btn btn-primary save-changes">Lưu thay đổi</button>
            </div>
        </div>
    </div>
</div>


<script>
    const subjects = <?php echo json_encode($subjects); ?>;
</script>
<script>
    const updateUrl = "<?= base_url('admin/subject/update') ?>";
    const addSubjectUrl = "<?= base_url('admin/subject/add_subject') ?>";
    const updateUrl_major = "<?= base_url('admin/major/update') ?>";
    const addMajorUrl = "<?= base_url('admin/subject/add_major') ?>";
</script>