// JavaScript Document
$(document).ready(function() {
    window.setInterval(function(){ // Set interval for checking
        var date = new Date(); // Create a Date object to find out what time it is
        if((date.getHours() == officeEndTimeHour && date.getMinutes() >= officeEndTimeMin) || (date.getHours() >= officeEndTimeHour)){ // Check the time
            $('.footer_logout').show()

            
        }
    }, 1000);
    $('.date_range').daterangepicker({
      "showDropdowns": true,
      ranges: {
          'Today': [moment(), moment()],
          'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days': [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month': [moment().startOf('month'), moment().endOf('month')],
          'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
      },
      "alwaysShowCalendars": true,
      /*"startDate": moment().subtract(6, 'days'),
      "endDate": moment()*/
    }, function(start, end, label) {
    //console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
    });

    $('.datetime').datetimepicker();

    $('.time').datetimepicker({
        format: 'LT'
    });

    function ajax_post(url = '', data = [], success = function() {}, error = function() {}, beforesend = function() {}) {
        jQuery.ajax({
            url: url,
            type: 'post',
            data: data,
            beforeSend: beforesend,
            success: success,
            error: error
        });
    }
    $('select[name="userrole_id"]').on('change', function(e) {
        e.preventDefault();
        let userrole_id = $(this).val();
        if (userrole_id == 3) {
            $('input[name="password"]').val("password");
            $('#password_section').hide();
        } else {
            $('input[name="password"]').val("");
            $('#password_section').show();
        }
    })
    $('.phone').mask('0000000000');
    $('.check_action').on('click', function(e) {
        e.preventDefault();
        let action = $(this).data('action');
        if (action == 'check') {
            $('input[name="permission_id[]"]').each(function(index) {
                $(this).prop("checked", true);
            })
        } else {
            $('input[name="permission_id[]"]').each(function(index) {
                $(this).prop("checked", false);
            })
        }
    })
    $('#add_objective').on('click', function(e) {
        e.preventDefault();
        let html = `<tr>
  <td>
    <textarea name="objective[]"></textarea>
  </td>
  <td>
    <input type="text" name="weightage[]" value="">
  </td>
  <td></td>
  <td></td>
  <td></td>
  <td>
    <a href="javascript:void(0);" class="btn-link-td delete_objective"><i class="fa fa-trash"></i></a>
  </td>
</tr>`;
        $('#objective_table').append(html);
    });
    $('#objective_table').on('click', '.delete_objective', function(e) {
        e.preventDefault();
        $(this).parent().parent().remove();
    });
    $('input[type="password"]').hidePassword(true);
    var clipboard = new Clipboard('.btn');
    clipboard.on('success', function(e) {
        console.log(e);
    });
    clipboard.on('error', function(e) {
        console.log(e);
    });
    $('.sidebar-menu > ul > li:has(ul)').addClass("has-sub");
    $('.sidebar-menu > ul > li > a').click(function() {
        var checkElement = $(this).next();
        $('.sidebar-menu li').removeClass('active');
        $(this).closest('li').addClass('active');
        if ((checkElement.is('ul')) && (checkElement.is(':visible'))) {
            $(this).closest('li').removeClass('active');
            checkElement.slideUp('normal');
        }
        if ((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
            $('.sidebar-menu ul ul:visible').slideUp('normal');
            checkElement.slideDown('normal');
        }
        if (checkElement.is('ul')) {
            return false;
        } else {
            return true;
        }
    });
    $('#password-3').pwdMeter({
        minLength: 6,
        displayGeneratePassword: true,
        generatePassText: 'Password Generator',
        generatePassClass: 'GeneratePasswordLink',
        RandomPassLength: 13
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $(input).parent().parent().find('img').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
    }
    $("input[name='profile_image']").change(function() {
        readURL(this);
    });

    $("input[name='site_logo']").change(function() {
        readURL(this);
    });

    $("input[name='site_favicon']").change(function() {
        readURL(this);
    });

    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#sidebar-wrapper, #page-sidebar").toggleClass("active");
    });
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("body").toggleClass("noscroll");
    });
    $("#menu-toggle").click(function() {
        $("#menu-toggle").toggleClass("active");
    });

    // binds form submission and fields to the validation engine
    jQuery(".adminForm").validationEngine('attach', { promptPosition: "bottomLeft", autoPositionUpdate: true });

    $('#all_check_action').on('click', function(e) {
        if ($(this).is(":checked")) {
            $('.single_check_action').each(function() {
                $(this).prop("checked", true);
            });
        } else {
            $('.single_check_action').each(function() {
                $(this).prop("checked", false);
            });
        }
    })

    $('#dataTable')
        .addClass('nowrap')
        .dataTable({
            responsive: true,
            dom: 'Bfrtip',
            buttons: [{
                    text: 'Delete',
                    action: function(e, dt, node, config) {
                        let masterIds = [];
                        $('.single_check_action').each(function() {
                            if ($(this).is(":checked")) {
                                masterIds.push($(this).val());
                            }
                        });
                        if (masterIds.length > 0) {
                            Swal.fire({
                                title: 'Are you sure?',
                                text: "You won't be able to revert this!",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Yes, delete it!',
                                preConfirm: () => {
                                    let url = `${base_url}/master/master_bulk_delete`;
                                    let data = { "_token": $('meta[name="csrf-token"]').attr('content'), 'master_ids': masterIds };
                                    let success = function(resp) {
                                        $('body').waitMe('hide');
                                        Swal.fire(
                                            'Deleted!',
                                            'Data has been deleted.',
                                            'success'
                                        )

                                        setTimeout(function() {
                                            location.reload();
                                        }, 2000);
                                    };
                                    let error = function() {
                                        $('body').waitMe('hide');
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oops...',
                                            text: 'Something went wrong!'
                                        })
                                    };
                                    let beforesend = function() {
                                        $('body').waitMe({
                                            effect: 'bounce',
                                            text: 'Deleting the data...',
                                            bg: 'rgba(255,255,255,0.8)',
                                            color: '#24747e',
                                            maxSize: '',
                                            textPos: 'vertical',
                                            source: ''
                                        });
                                    };
                                    return ajax_post(url, data, success, error, beforesend);
                                }
                            })
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Please select atleast one data!'
                            })
                        }
                    }
                },
                'csv', 'excel', 'pdf', 'print'

            ],
            columnDefs: [
                { "orderable": false, "targets": 0 }
            ]
        });

    $('#casedataTable')
        .addClass('nowrap')
        .dataTable({
            responsive: true,
            dom: 'Bfrtip',
            buttons: [{
                    text: 'Delete',
                    action: function(e, dt, node, config) {
                        let masterIds = [];
                        $('.single_check_action').each(function() {
                            if ($(this).is(":checked")) {
                                masterIds.push($(this).val());
                            }
                        });
                        if (masterIds.length > 0) {
                            Swal.fire({
                                title: 'Are you sure?',
                                text: "You won't be able to revert this!",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Yes, delete it!',
                                preConfirm: () => {
                                    let url = `${base_url}/master/master_bulk_delete`;
                                    let data = { "_token": $('meta[name="csrf-token"]').attr('content'), 'master_ids': masterIds };
                                    let success = function(resp) {
                                        $('body').waitMe('hide');
                                        Swal.fire(
                                            'Deleted!',
                                            'Data has been deleted.',
                                            'success'
                                        )

                                        setTimeout(function() {
                                            location.reload();
                                        }, 2000);
                                    };
                                    let error = function() {
                                        $('body').waitMe('hide');
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oops...',
                                            text: 'Something went wrong!'
                                        })
                                    };
                                    let beforesend = function() {
                                        $('body').waitMe({
                                            effect: 'bounce',
                                            text: 'Deleting the data...',
                                            bg: 'rgba(255,255,255,0.8)',
                                            color: '#24747e',
                                            maxSize: '',
                                            textPos: 'vertical',
                                            source: ''
                                        });
                                    };
                                    return ajax_post(url, data, success, error, beforesend);
                                }
                            })
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Please select atleast one data!'
                            })
                        }
                    }
                },
                'csv', 'excel', 'pdf', 'print'

            ],
            columnDefs: [
                { "orderable": false, "targets": 0 },
                /*{
                "targets": [ 2 ],
                "visible": false
                },*/
            ]
        });

    $('#holidaydataTable')
        .addClass('nowrap')
        .dataTable({
            responsive: true,
            dom: 'Bfrtip',
            buttons: [{
                    text: 'Delete',
                    action: function(e, dt, node, config) {
                        let masterIds = [];
                        $('.single_check_action').each(function() {
                            if ($(this).is(":checked")) {
                                masterIds.push($(this).val());
                            }
                        });
                        if (masterIds.length > 0) {
                            Swal.fire({
                                title: 'Are you sure?',
                                text: "You won't be able to revert this!",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Yes, delete it!',
                                preConfirm: () => {
                                    let url = `${base_url}/master/master_bulk_delete`;
                                    let data = { "_token": $('meta[name="csrf-token"]').attr('content'), 'master_ids': masterIds };
                                    let success = function(resp) {
                                        $('body').waitMe('hide');
                                        Swal.fire(
                                            'Deleted!',
                                            'Data has been deleted.',
                                            'success'
                                        )

                                        setTimeout(function() {
                                            location.reload();
                                        }, 2000);
                                    };
                                    let error = function() {
                                        $('body').waitMe('hide');
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oops...',
                                            text: 'Something went wrong!'
                                        })
                                    };
                                    let beforesend = function() {
                                        $('body').waitMe({
                                            effect: 'bounce',
                                            text: 'Deleting the data...',
                                            bg: 'rgba(255,255,255,0.8)',
                                            color: '#24747e',
                                            maxSize: '',
                                            textPos: 'vertical',
                                            source: ''
                                        });
                                    };
                                    return ajax_post(url, data, success, error, beforesend);
                                }
                            })
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Please select atleast one data!'
                            })
                        }
                    }
                },
                'csv', 'excel', 'pdf', 'print'

            ],
            columnDefs: [
                { "orderable": false, "targets": 0 }
            ],
            order: [[ 2, "asc" ]]
        });

    $('#file_managerdataTable')
        .addClass('nowrap')
        .dataTable({
            responsive: true,
            dom: 'Bfrtip',
            buttons: [
                  {
                    text: 'Delete',
                    action: function(e, dt, node, config) {
                        let masterIds = [];
                        $('.single_check_action').each(function() {
                            if ($(this).is(":checked")) {
                                masterIds.push($(this).val());
                            }
                        });
                        if (masterIds.length > 0) {
                            Swal.fire({
                                title: 'Are you sure?',
                                text: "You won't be able to revert this!",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Yes, delete it!',
                                preConfirm: () => {
                                    let url = `${base_url}/master/master_bulk_delete`;
                                    let data = { "_token": $('meta[name="csrf-token"]').attr('content'), 'master_ids': masterIds };
                                    let success = function(resp) {
                                        $('body').waitMe('hide');
                                        Swal.fire(
                                            'Deleted!',
                                            'Data has been deleted.',
                                            'success'
                                        )

                                        setTimeout(function() {
                                            location.reload();
                                        }, 2000);
                                    };
                                    let error = function() {
                                        $('body').waitMe('hide');
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oops...',
                                            text: 'Something went wrong!'
                                        })
                                    };
                                    let beforesend = function() {
                                        $('body').waitMe({
                                            effect: 'bounce',
                                            text: 'Deleting the data...',
                                            bg: 'rgba(255,255,255,0.8)',
                                            color: '#24747e',
                                            maxSize: '',
                                            textPos: 'vertical',
                                            source: ''
                                        });
                                    };
                                    return ajax_post(url, data, success, error, beforesend);
                                }
                            })
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Please select atleast one data!'
                            })
                        }
                    }
                },
                {
                    text: 'Upload Excel',
                    action: function ( e, dt, node, config ) {
                        window.location.href =  `${base_url}/upload_excel?master_type=file_manager`;
                    }
                },
                'csv', 'excel', 'pdf', 'print'

            ],
            columnDefs: [
                { "orderable": false, "targets": 0 }
            ]
        });

    $('#revisiondataTable')
        .addClass('nowrap')
        .dataTable({
            responsive: true,
            dom: 'Bfrtip',
            buttons: [
                'csv', 'excel', 'pdf', 'print'
            ]
        });
    $('#user_attendencedataTable')
        .addClass('nowrap')
        .dataTable({
            responsive: true,
            dom: 'Bfrtip',
            buttons: [
                {
                    text: 'Add Attendence',
                    action: function ( e, dt, node, config ) {
                        window.location.href =  `${base_url}/user_attendence/create`;
                    }
                },
                'csv', 'excel', 'pdf', 'print'
            ],
            order: [[ 6, "desc" ]]
        });
    $('#userRoledataTable')
        .addClass('nowrap')
        .dataTable({
            responsive: true,
            dom: 'Bfrtip',
            buttons: [
                'csv', 'excel', 'pdf', 'print'
            ]
        });
    $('#userdataTable')
        .addClass('nowrap')
        .dataTable({
            responsive: true,
            dom: 'Bfrtip',
            buttons: [
                'csv', 'excel', 'pdf', 'print'
            ]
        });
    $('#dashCaseTable')
        .addClass('nowrap')
        .dataTable({
            responsive: true,
            lengthChange: false,
            pageLength: 10,
            dom: 'Bfrtip',
            buttons: [
                'csv', 'excel', 'pdf', 'print'
            ],
            order: [[ 2, "asc" ]]
        });
    $('#dashHolidayTable')
        .addClass('nowrap')
        .dataTable({
            responsive: true,
            lengthChange: false,
            pageLength: 10,
            dom: 'Bfrtip',
            buttons: [
                'csv', 'excel', 'pdf', 'print'
            ],
            order: [[ 1, "asc" ]]
        });
    $('#dashTodoTable')
        .addClass('nowrap')
        .dataTable({
            responsive: true,
            lengthChange: false,
            pageLength: 10,
            dom: 'Bfrtip',
            buttons: [
                'csv', 'excel', 'pdf', 'print'
            ],
            order: [[ 2, "asc" ]]

        });
    $('#dashAttendenceTable')
        .addClass('nowrap')
        .dataTable({
            responsive: true,
            columnDefs: [
                { "width": "68%%", "targets": 0 }
            ],
            lengthChange: false,
            pageLength: 10,
            dom: 'Bfrtip',
            buttons: [
                'csv', 'excel', 'pdf', 'print'
            ]

        });

    var fixHelperModified = function(e, tr) {
        var $originals = tr.children();
        var $helper = tr.clone();
        $helper.children().each(function(index) {
            $(this).width($originals.eq(index).width())
        });
        return $helper;
    };
    $("#dataTable tbody").sortable({
        helper: fixHelperModified,
        stop: function(event, ui) { renumber_table('#dataTable') }
    }).disableSelection();
    $('table').on('click', '.btn-delete', function() {
        tableID = '#' + $(this).closest('table').attr('id');
        r = confirm('Delete this item?');
        if (r) {
            $(this).closest('tr').remove();
            renumber_table(tableID);
        }
    });

    function renumber_table(tableID) {
        $(tableID + " tr").each(function() {
            count = $(this).parent().children().index($(this)) + 1;
            $(this).find('.priority').html(count);
        });
    }

    $('select[name="court_id"]').on('change', function(e) {
        e.preventDefault();
        let id = $(this).val();
        let type = $(this).attr('data-type');
        if (id > 0 && id != '') {
            fetch(`${base_url}/child_master/${id}?master_type=${type}`)
                .then(res => res.json())
                .then((res2) => {
                    let html = `<option value="0">Select Subcourt</option>`;
                    if (res2.length) {
                        $.each(res2, function(index, item) {
                            html += `<option value="${item.id}">${item.name}</option>`;
                        });
                    } else {
                        html += `<option value="0">No subcourts are found</option>`;
                    }
                    $('select[name="subcourt_id"]').html(html);
                });
        }
    })
    $('select[name="case_category_id"]').on('change', function(e) {
        e.preventDefault();
        let id = $(this).val();
        let type = $(this).attr('data-type');
        if (id > 0 && id != '') {
            fetch(`${base_url}/child_master/${id}?master_type=${type}`)
                .then(res => res.json())
                .then((res2) => {
                    let html = `<option value="0">Select Case Subcategory</option>`;
                    if (res2.length) {
                        $.each(res2, function(index, item) {
                            html += `<option value="${item.id}">${item.name}</option>`;
                        });
                    } else {
                        html += `<option value="0">No subcase categories are found</option>`;
                    }
                    $('select[name="case_subcategory_id"]').html(html);
                });
        }
    })
    $('#attendence_today').on('click', '.view_logs', function(e) {
        e.preventDefault();
        let id = $(this).attr("data-id");
        let logDate = $(this).attr("data-log-date");
        table = $('#single_attendence_tbl').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": `${base_url}/attendence_logs/${id}?log_date=${logDate}`,
            "ordering": false,
            "dom": 'Bfrtip',
            "buttons": [
                'csv', 'excel', 'pdf', 'print'
            ],
            "columns": [
                { data: "logged_at" },
                { data: "logged_out_at" }
            ],
            "responsive": true
        });

        $('#attendenceLogModal').modal({
            backdrop: 'static',
            keyboard: false
        });
    })
    $('#attendenceLogModal').find('.close').on('click', function(e) {
        e.preventDefault();
        table.destroy();
        $('#attendenceLogModal').modal('hide');
    });
    //Example 1
    $('.filer_input').filer({
        showThumbs: true
    });
    //Example 2
    $("#filer_input2").filer({
        limit: null,
        maxSize: null,
        extensions: null,
        changeInput: '<div class="jFiler-input-dragDrop"><div class="jFiler-input-inner"><div class="jFiler-input-icon"><i class="icon-jfi-cloud-up-o"></i></div><div class="jFiler-input-text"><h3>Drag&Drop files here</h3> <span style="display:inline-block; margin: 15px 0">or</span></div><a class="jFiler-input-choose-btn blue">Browse Files</a></div></div>',
        showThumbs: true,
        theme: "dragdropbox",
        templates: {
            box: '<ul class="jFiler-items-list jFiler-items-grid"></ul>',
            item: '<li class="jFiler-item">\
<div class="jFiler-item-container">\
  <div class="jFiler-item-inner">\
    <div class="jFiler-item-thumb">\
      <div class="jFiler-item-status"></div>\
      <div class="jFiler-item-info">\
        <span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name | limitTo: 25}}</b></span>\
        <span class="jFiler-item-others">{{fi-size2}}</span>\
      </div>\
      {{fi-image}}\
    </div>\
    <div class="jFiler-item-assets jFiler-row">\
      <ul class="list-inline pull-left">\
        <li>{{fi-progressBar}}</li>\
      </ul>\
      <ul class="list-inline pull-right">\
        <li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
      </ul>\
    </div>\
  </div>\
</div>\
</li>',
            itemAppend: '<li class="jFiler-item">\
<div class="jFiler-item-container">\
  <div class="jFiler-item-inner">\
    <div class="jFiler-item-thumb">\
      <div class="jFiler-item-status"></div>\
      <div class="jFiler-item-info">\
        <span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name | limitTo: 25}}</b></span>\
        <span class="jFiler-item-others">{{fi-size2}}</span>\
      </div>\
      {{fi-image}}\
    </div>\
    <div class="jFiler-item-assets jFiler-row">\
      <ul class="list-inline pull-left">\
        <li><span class="jFiler-item-others">{{fi-icon}}</span></li>\
      </ul>\
      <ul class="list-inline pull-right">\
        <li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
      </ul>\
    </div>\
  </div>\
</div>\
</li>',
            progressBar: '<div class="bar"></div>',
            itemAppendToEnd: false,
            removeConfirmation: true,
            _selectors: {
                list: '.jFiler-items-list',
                item: '.jFiler-item',
                progressBar: '.bar',
                remove: '.jFiler-item-trash-action'
            }
        },
        dragDrop: {
            dragEnter: null,
            dragLeave: null,
            drop: null,
        },
        uploadFile: {
            url: base_url + "/master/upload_files",
            data: { "_token": $('meta[name="csrf-token"]').attr('content') },
            type: 'POST',
            enctype: 'multipart/form-data',
            beforeSend: function() {},
            success: function(resp, el) {
                var data = JSON.parse(resp);
                var parent = el.find(".jFiler-jProgressBar").parent();
                if (data.success) {
                    var id = parent.closest('.jFiler-item').attr('data-jfiler-index');
                    $('#MasterForm').append(`<input type="hidden" id="attachment_${id}" name="attachment_id[]" value="${data.attachment_id}">`);
                    el.find(".jFiler-jProgressBar").fadeOut("slow", function() {
                        $("<div class=\"jFiler-item-others text-success\"><i class=\"icon-jfi-check-circle\"></i> Success</div>").hide().appendTo(parent).fadeIn("slow");
                    });
                } else {
                    el.find(".jFiler-jProgressBar").fadeOut("slow", function() {
                        $("<div class=\"jFiler-item-others text-error\"><i class=\"icon-jfi-minus-circle\"></i> Error</div>").hide().appendTo(parent).fadeIn("slow");
                    });
                }
            },
            error: function(el) {
                var parent = el.find(".jFiler-jProgressBar").parent();
                el.find(".jFiler-jProgressBar").fadeOut("slow", function() {
                    $("<div class=\"jFiler-item-others text-error\"><i class=\"icon-jfi-minus-circle\"></i> Error</div>").hide().appendTo(parent).fadeIn("slow");
                });
            },
            statusCode: null,
            onProgress: null,
            onComplete: null
        },
        files: null,
        addMore: false,
        clipBoardPaste: true,
        excludeName: null,
        beforeRender: null,
        afterRender: null,
        beforeShow: null,
        beforeSelect: null,
        onSelect: null,
        afterShow: null,
        onRemove: function(itemEl, file, id, listEl, boxEl, newInputEl, inputEl) {
            var file = file.name;
            //$.post('./php/remove_file.php', {file: file});
            $(`#attachment_${id}`).remove();
        },
        onEmpty: null,
        options: null,
        captions: {
            button: "Choose Files",
            feedback: "Choose files To Upload",
            feedback2: "files were chosen",
            drop: "Drop file here to Upload",
            removeConfirmation: "Are you sure you want to remove this file?",
            errors: {
                filesLimit: "Only {{fi-limit}} files are allowed to be uploaded.",
                filesType: "Only Images are allowed to be uploaded.",
                filesSize: "{{fi-name}} is too large! Please upload file up to {{fi-maxSize}} MB.",
                filesSizeAll: "Files you've choosed are too large! Please upload files up to {{fi-maxSize}} MB."
            }
        }
    });

    if (masterType == 'case' || currentRoute == 'user.edit' || currentRoute == 'profile' || masterType == 'judgement') {
        getDriveFiles($("input[name='master_id']").val());
    }

    function getDriveFiles(id) {
        let data = { "_token": $('meta[name="csrf-token"]').attr('content'), 'folder_name': $('input[name="folder_name"]').val() };
        let url = base_url + '/master/get_drive_files/' + id;
        let success = function(resp) {
            console.log(resp);
            let data = JSON.parse(resp);
            $('body').waitMe('hide');
            let html = ``;
            $.each(data.files, function(key, value) {
                html += `<li>
                            <a href="${value}" target="_blank">
                                <img src="${fileThumbUrl}">
                            </a>
                            <p class="file-name">${key}</p>
                            <p class="file-name"><button type="button" class="file-delete btn-link-td" data-filename="${key}" data-id="${id}"><i class="fa fa-trash"></i>&nbsp;Delete</button></p>
                        </li>`;
            });
            if(data.main_dir != '') {
                $('.upload_google_drive_sec').html(`<a class="btn btn-primary" target="_blank" href="${data.main_dir}"><i class="fab fa-google-drive"></i>&nbsp;Upload on Google Drive</a>`)
            }
            $('.file-list').html(html);
        };
        let error = function() {
            $('body').waitMe('hide');
            toastr.error('', 'Check your network connection', {
                timeOut: '60000',
                positionClass: 'toast-bottom-right'
            });
        };
        let beforesend = function() {
            $('body').waitMe({
                effect: 'bounce',
                text: 'Fetching the files...',
                bg: 'rgba(255,255,255,0.8)',
                color: '#24747e',
                maxSize: '',
                textPos: 'vertical',
                source: ''
            });
        };
        if (id > 0) {
            ajax_post(url, data, success, error, beforesend);
        }
    }
    $("#filer_input_case_doc").filer({
        limit: null,
        maxSize: null,
        extensions: null,
        changeInput: '<div class="jFiler-input-dragDrop"><div class="jFiler-input-inner"><div class="jFiler-input-icon"><i class="icon-jfi-cloud-up-o"></i></div><div class="jFiler-input-text"><h3>Drag&Drop files here </h3> <span style="display:inline-block; margin: 15px 0">or</span></div><a class="jFiler-input-choose-btn blue">Browse Files</a></div></div>',
        showThumbs: false,
        theme: "dragdropbox",
        templates: {
            box: '<ul class="jFiler-items-list jFiler-items-grid"></ul>',
            item: '<li class="jFiler-item">\
<div class="jFiler-item-container">\
<div class="jFiler-item-inner">\
  <div class="jFiler-item-thumb">\
    <div class="jFiler-item-status"></div>\
    <div class="jFiler-item-info">\
      <span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name | limitTo: 25}}</b></span>\
      <span class="jFiler-item-others">{{fi-size2}}</span>\
    </div>\
    {{fi-image}}\
  </div>\
  <div class="jFiler-item-assets jFiler-row">\
    <ul class="list-inline pull-left">\
      <li>{{fi-progressBar}}</li>\
    </ul>\
    <ul class="list-inline pull-right">\
      <li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
    </ul>\
  </div>\
</div>\
</div>\
</li>',
            itemAppend: '<li class="jFiler-item">\
<div class="jFiler-item-container">\
<div class="jFiler-item-inner">\
  <div class="jFiler-item-thumb">\
    <div class="jFiler-item-status"></div>\
    <div class="jFiler-item-info">\
      <span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name | limitTo: 25}}</b></span>\
      <span class="jFiler-item-others">{{fi-size2}}</span>\
    </div>\
    {{fi-image}}\
  </div>\
  <div class="jFiler-item-assets jFiler-row">\
    <ul class="list-inline pull-left">\
      <li><span class="jFiler-item-others">{{fi-icon}}</span></li>\
    </ul>\
    <ul class="list-inline pull-right">\
      <li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
    </ul>\
  </div>\
</div>\
</div>\
</li>',
            progressBar: '<div class="bar"></div>',
            itemAppendToEnd: false,
            removeConfirmation: true,
            _selectors: {
                list: '.jFiler-items-list',
                item: '.jFiler-item',
                progressBar: '.bar',
                remove: '.jFiler-item-trash-action'
            }
        },
        dragDrop: {
            dragEnter: null,
            dragLeave: null,
            drop: null,
        },
        uploadFile: {
            url: base_url + "/master/upload_drive_files",
            data: { "_token": $('meta[name="csrf-token"]').attr('content'), 'name': $("input[name='name']").val(), 'master_id': $("input[name='master_id']").val(), 'folder_name': $("input[name='folder_name']").val() },
            type: 'POST',
            enctype: 'multipart/form-data',
            beforeSend: function() {
                $('body').waitMe({
                    effect: 'bounce',
                    text: 'File is uploading...',
                    bg: 'rgba(255,255,255,0.8)',
                    color: '#24747e',
                    maxSize: '',
                    textPos: 'vertical',
                    source: ''
                });
            },
            success: function(resp, el) {
                var data = JSON.parse(resp);
                $('body').waitMe('hide');
                if (data.success) {
                    toastr.success('', 'File has been uploaded successfully', {
                        timeOut: '60000',
                        positionClass: 'toast-bottom-right'
                    });
                    $('#subdir_name').text(data.dir_name);
                    $('#subdir_files').attr('data-folder', data.dir_name);
                    getDriveFiles($("input[name='master_id']").val());
                } else {
                    toastr.error('', data.message, {
                        timeOut: '60000',
                        positionClass: 'toast-bottom-right'
                    });
                }
            },
            error: function(el) {
                $('body').waitMe('hide');
                toastr.error('', 'Check your network connection', {
                    timeOut: '60000',
                    positionClass: 'toast-bottom-right'
                });
            },
            statusCode: null,
            onProgress: null,
            onComplete: null
        },
        files: null,
        addMore: false,
        clipBoardPaste: true,
        excludeName: null,
        beforeRender: null,
        afterRender: null,
        beforeShow: null,
        beforeSelect: null,
        onSelect: null,
        afterShow: null,
        onRemove: function(itemEl, file, id, listEl, boxEl, newInputEl, inputEl) {
            var file = file.name;
            //$.post('./php/remove_file.php', {file: file});
            $(`#attachment_${id}`).remove();
        },
        onEmpty: null,
        options: null,
        captions: {
            button: "Choose Files",
            feedback: "Choose files To Upload",
            feedback2: "files were chosen",
            drop: "Drop file here to Upload",
            removeConfirmation: "Are you sure you want to remove this file?",
            errors: {
                filesLimit: "Only {{fi-limit}} files are allowed to be uploaded.",
                filesType: "Only Images are allowed to be uploaded.",
                filesSize: "{{fi-name}} is too large! Please upload file up to {{fi-maxSize}} MB.",
                filesSizeAll: "Files you've choosed are too large! Please upload files up to {{fi-maxSize}} MB."
            }
        }
    });

    $(".filer_input_doc").filer({
        limit: null,
        maxSize: null,
        extensions: null,
        changeInput: '<div class="jFiler-input-dragDrop"><div class="jFiler-input-inner"><div class="jFiler-input-icon"><i class="icon-jfi-cloud-up-o"></i></div><div class="jFiler-input-text"><h3>Drag&Drop files here </h3> <span style="display:inline-block; margin: 15px 0">or</span></div><a class="jFiler-input-choose-btn blue">Browse Files</a></div></div>',
        showThumbs: false,
        theme: "dragdropbox",
        templates: {
            box: '<ul class="jFiler-items-list jFiler-items-grid"></ul>',
            item: '<li class="jFiler-item">\
<div class="jFiler-item-container">\
<div class="jFiler-item-inner">\
  <div class="jFiler-item-thumb">\
    <div class="jFiler-item-status"></div>\
    <div class="jFiler-item-info">\
      <span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name | limitTo: 25}}</b></span>\
      <span class="jFiler-item-others">{{fi-size2}}</span>\
    </div>\
    {{fi-image}}\
  </div>\
  <div class="jFiler-item-assets jFiler-row">\
    <ul class="list-inline pull-left">\
      <li>{{fi-progressBar}}</li>\
    </ul>\
    <ul class="list-inline pull-right">\
      <li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
    </ul>\
  </div>\
</div>\
</div>\
</li>',
            itemAppend: '<li class="jFiler-item">\
<div class="jFiler-item-container">\
<div class="jFiler-item-inner">\
  <div class="jFiler-item-thumb">\
    <div class="jFiler-item-status"></div>\
    <div class="jFiler-item-info">\
      <span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name | limitTo: 25}}</b></span>\
      <span class="jFiler-item-others">{{fi-size2}}</span>\
    </div>\
    {{fi-image}}\
  </div>\
  <div class="jFiler-item-assets jFiler-row">\
    <ul class="list-inline pull-left">\
      <li><span class="jFiler-item-others">{{fi-icon}}</span></li>\
    </ul>\
    <ul class="list-inline pull-right">\
      <li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
    </ul>\
  </div>\
</div>\
</div>\
</li>',
            progressBar: '<div class="bar"></div>',
            itemAppendToEnd: false,
            removeConfirmation: true,
            _selectors: {
                list: '.jFiler-items-list',
                item: '.jFiler-item',
                progressBar: '.bar',
                remove: '.jFiler-item-trash-action'
            }
        },
        dragDrop: {
            dragEnter: null,
            dragLeave: null,
            drop: null,
        },
        uploadFile: {
            url: base_url + "/master/upload_drive_files",
            data: { "_token": $('meta[name="csrf-token"]').attr('content'), 'name': $("input[name='name']").val(), 'master_id': $("input[name='master_id']").val(), 'folder_name': $("input[name='folder_name']").val() },
            type: 'POST', 
            enctype: 'multipart/form-data',
            beforeSend: function() {
                $('body').waitMe({
                    effect: 'bounce',
                    text: 'File is uploading...',
                    bg: 'rgba(255,255,255,0.8)',
                    color: '#24747e',
                    maxSize: '',
                    textPos: 'vertical',
                    source: ''
                });
            },
            success: function(resp, el) {
                var data = JSON.parse(resp);
                $('body').waitMe('hide');
                if (data.success) {
                    toastr.success('', 'File has been uploaded successfully', {
                        timeOut: '60000',
                        positionClass: 'toast-bottom-right'
                    });
                    $('#subdir_name').text(data.dir_name);
                    $('#subdir_files').attr('data-folder', data.dir_name);
                    getDriveFiles($("input[name='master_id']").val());
                } else {
                    toastr.error('', data.message, {
                        timeOut: '60000',
                        positionClass: 'toast-bottom-right'
                    });
                }
            },
            error: function(el) {
                $('body').waitMe('hide');
                toastr.error('', 'Check your network connection', {
                    timeOut: '60000',
                    positionClass: 'toast-bottom-right'
                });
            },
            statusCode: null,
            onProgress: null,
            onComplete: null
        },
        files: null,
        addMore: false,
        clipBoardPaste: true,
        excludeName: null,
        beforeRender: null,
        afterRender: null,
        beforeShow: null,
        beforeSelect: null,
        onSelect: null,
        afterShow: null,
        onRemove: function(itemEl, file, id, listEl, boxEl, newInputEl, inputEl) {
            var file = file.name;
            //$.post('./php/remove_file.php', {file: file});
            $(`#attachment_${id}`).remove();
        },
        onEmpty: null,
        options: null,
        captions: {
            button: "Choose Files",
            feedback: "Choose files To Upload",
            feedback2: "files were chosen",
            drop: "Drop file here to Upload",
            removeConfirmation: "Are you sure you want to remove this file?",
            errors: {
                filesLimit: "Only {{fi-limit}} files are allowed to be uploaded.",
                filesType: "Only Images are allowed to be uploaded.",
                filesSize: "{{fi-name}} is too large! Please upload file up to {{fi-maxSize}} MB.",
                filesSizeAll: "Files you've choosed are too large! Please upload files up to {{fi-maxSize}} MB."
            }
        }
    });
    $('.file-list').on('click', '.file-delete', function(e) {
        e.preventDefault();
        let fileName = $(this).attr('data-filename');
        let folder = $(this).parent().parent().parent().attr('data-folder');
        let masterId = $(this).attr('data-id');
        let data = { "_token": $('meta[name="csrf-token"]').attr('content'), "folder": folder, "filename": fileName, "master_id": masterId, "folder_name": $('input[name="folder_name"]').val() };
        let url = base_url + '/master/delete_drive_file';
        let el = $(this);
        let success = function(resp) {
            $('body').waitMe('hide');
            toastr.success('', 'File has been deleted successfully', {
                timeOut: '60000',
                positionClass: 'toast-bottom-right'
            });
            el.parent().parent().remove();
        };
        let error = function() {
            $('body').waitMe('hide');
            toastr.error('', 'Check your network connection', {
                timeOut: '60000',
                positionClass: 'toast-bottom-right'
            });
        };
        let beforesend = function() {
            $('body').waitMe({
                effect: 'bounce',
                text: 'File is deleting...',
                bg: 'rgba(255,255,255,0.8)',
                color: '#24747e',
                maxSize: '',
                textPos: 'vertical',
                source: ''
            });
        };
        ajax_post(url, data, success, error, beforesend);
    })


    $("#employee_id").select2({
        templateResult: formatState,
        templateSelection: formatState
    });
    $("#file_id").select2({
        templateResult: formatState,
        templateSelection: formatState
    });
    $("#assignee_id").select2({
        templateResult: formatState,
        templateSelection: formatState
    });
    $('.lawselect').select2();

    function formatState(opt) {
        if (!opt.id) {
            return opt.text.toUpperCase();
        }
        var optimage = $(opt.element).attr('data-image');
        console.log(optimage)
        if (!optimage) {
            return opt.text.toUpperCase();
        } else {
            var $opt = $(
                '<span><img src="' + optimage + '" width="40px" /> ' + opt.text.toUpperCase() + '</span>'
            );
            return $opt;
        }
    };
    $('.date').datepicker({
        format: "dd-mm-yyyy",
        calendarWeeks: true,
        todayHighlight: true,
        autoclose: true
    });
    $(window).on("load", function() {
        $("#content-scroll").mCustomScrollbar({
            scrollButtons: { enable: true },
            theme: "3d-thick"
        });
    });


    $(".images-container").sortable({ animation: 150, handle: ".control-btn.move", draggable: ".image-container", onMove: function(t) { var n = $(t.related); return n.hasClass("add-image") ? !1 : void 0 } }), $controlsButtons = $(".controls"), $controlsButtonsStar = $controlsButtons.find(".star"), $controlsButtonsRemove = $controlsButtons.find(".remove"), $controlsButtonsStar.on("click", function(t) { t.preventDefault(), $controlsButtonsStar.removeClass("active"), $controlsButtonsStar.parents(".image-container").removeClass("main"), $(this).addClass("active"), $(this).parents(".image-container").addClass("main") })


    $({ someValue: 0 }).animate({ someValue: Math.floor(Math.random() * 3000) }, {
        duration: 3000,
        easing: 'swing', // can be anything
        step: function() { // called on every step
            // Update the element's text with rounded-up value:
            $('.count').text(commaSeparateNumber(Math.round(this.someValue)));
        }
    });

    function commaSeparateNumber(val) {
        while (/(\d+)(\d{3})/.test(val.toString())) {
            val = val.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        }
        return val;
    }

})
