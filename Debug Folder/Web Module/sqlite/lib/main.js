//
// ON LOAD ...
//
$(document).ready(function () {
    // HIDE THE UPLOAD AREA ON LOAD
    $('#upload-wrapper').hide();
    $('#upload-meter').hide();
    $('#btn-upload').attr("value", "Upload");
});


// THE FILE TRANSFER CODE
$(function () {

    $('#backupname').on('change', function(){
        if ($('#browse_button').val().length > 0)
        {
            $('#browse_button').show();
        }
        else
        {
            $('#browse_button').hide();
        }
    });


    // THANKS TO Bitwise Creative -> https://stackoverflow.com/a/28360617
    $('#browse_button').on('change',
        function () 
        {
            if ($('#browse_button').HasExtension(["sqlite", "sqlite3", "csv", "db", "db3", "sql", "zip", "rar", "7z"])) 
            {
                // HIDE THE PROGRESS BAR ON FIRST LOAD
                $('#upload-meter').hide();
                $('#upload-meter').hide();
                $('#btn-upload').attr("value", "Upload");

                // CHECK UPLOAD BUTTON IS NOT EMPTY (HAS FILE IN IT)
                if ($('#browse_button').get(0).files.length > 0) {
                    // CHECK FILE SIZE BEFORE UPLOAD
                    if (this.files[0].size > 1000000000) {
                        // CLEAR OUT UPLOAD BUTTON CONTENTS
                        $('#browse_button').val("");
                        //alert("File is too big!");

                        // SHOW SNACK MESSAGES
                        $('.snackbar-footer').css('background-color', '#F1A52B');
                        $('.snackbar-footer').css('color', '#16171D');
                        $('.snackbar-footer').text("Upload Failed. File is bigger than the maximum allowed. (1.0 GB)");
                        $('.vsnackbar').css('display', 'block');

                        // CLOSE SNACKBAR ON TIMEOUT
                        setTimeout(function () { $('.vsnackbar').css('display', 'none'); }, 4000);
                    }
                    else {
                        // HIDE SNACKBAR
                        $('#upload-wrapper').show();
                        $('.snackbar-footer').css('background-color', '#34A853;');
                        $('.snackbar-footer').css('color', 'white');
                        $('.snackbar-footer').text("");
                        $('.vsnackbar').css('display', 'none');
                    }
                }
                else {
                    // HIDE THE UPLOAD BUTTON AND PROGRESS BAR
                    $('#upload-wrapper').hide();
                    $('#browse_button').val("");
                    $('#btn-upload').attr("value", "Upload");
                }
            }
            else
            {
                alert("File is not supported!");
                $('#browse_button').val("");
            }
        });

    //
    // UPLOAD BUTTON CLICK
    //
    $('#btn-upload').click(function () {
        //$('.msg').text('');
        var filename = $('#backupname').val();
        var myfile = $('#browse_button').val();
        if (filename == '' || myfile == '') {
            alert('Please set a valid backup name and select the file to upload');
            return;
        }
        var formData = new FormData();
        formData.append('browse_button', $('#browse_button')[0].files[0]);
        formData.append('backupname', filename);
        $('#btn-upload').attr('disabled', 'disabled');
        //$('.msg').text('Uploading in progress...');
        $.ajax({
            url: 'uploadscript.php',
            data: formData,
            processData: false,
            contentType: false,
            type: 'POST',
            xhr: function () {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function (evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        percentComplete = parseInt(percentComplete * 100);
                        $('#upload-meter').show();
                        $('#upload-meter').val(percentComplete); //text(percentComplete + '%');
                        //$('#myprogress').css('width', percentComplete + '%');
                        $('#btn-upload').attr("value", "Uploading.. " + percentComplete + "%");
                    }
                }, false);
                return xhr;
            },
            success: function (data) {

                var msg = data;

                if (data === "File Uploaded Successfully")
                {
                    $('.snackbar-footer').css('background', '#34A853;');
                    $('.snackbar-footer').css('color', 'white');
                    $('#browse_button').val("");
                    $('#btn-upload').attr("value", "Upload");
                }
                else
                {
                    $('.snackbar-footer').css('background', '#F1A52B');
                    $('.snackbar-footer').css('color', '#16171D');
                    $('#browse_button').val("");
                    $('#btn-upload').attr("value", "Upload");
                }
               
                $('#message-wrapper').text(data);
                $('#btn-upload').removeAttr('disabled');
                $('#btn-upload').text('Upload');
                $('#upload-wrapper').hide();
                $('#upload-meter').val(0);
                //alert(data);
                $('.vsnackbar').css('display', 'block');
                $('.snackbar-footer').text(data);
                // ACTION TO DO AFTER UPLOAD; WHETHER SUCCESSFUL OR NOT 
                setTimeout(
                    function () {
                        // RELOAD PAGE IF SUCCESS
                        if (data == "File Uploaded Successfully") {
                            $(location).attr('href', "http://test-grounds.rf.gd/backup/");
                        }
                        // CLOSE THE SNACKBAR
                        else {
                            $('#snackbar').css('display', 'none');
                            location.reload();
                        }
                    },
                    1800);
            }
        });
    });
});    

//
// CHECK FOR UPLOAD FILE EXTENSION
//
$.fn.HasExtension = function (exts) {
    return (new RegExp('(' + exts.join('|').replace(/\./g, '\\.') + ')$')).test($(this).val());
}