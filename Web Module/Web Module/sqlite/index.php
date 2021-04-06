<?php 

$searchfname = "";

if (isset($_POST['submitfname']))
{
    $searchfname = $_POST['searchfname'];
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/png" href="assets/cloud.png">
        <link rel="stylesheet" href="styles/style.css" >
        <link rel="stylesheet" href="styles/file-list.css">
        <link rel="stylesheet" href="styles/meter-bar.css">
        <link rel="stylesheet" href="styles/snackbar.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="lib/jquery.min.js"></script>
        <script src="lib/main.js"></script>
        <title>Backup Server</title>
    </head>
<body>
    
    <!--BANNER-->
    <div id="wrapper" class="wrapper">
        <div id="banner" class="banner">
            <div id="title-text" class="">SQLite Backup</div>
                <div id="search-wrapper" class="">
                    <form action="index.php" id="searchform" class="" name="mainForm" method="GET">
                    <input class="" width="500" type="text" id="searchfname" name="searchfname" value="<?php echo htmlspecialchars($searchfname); ?>"  placeholder="Find Backup Name" >
                        <!-- <button id="submit"></button> -->
                        <div class="" id="submitForm">
                            <input type="submit" value="" id="submitfname" name="submitfname">
                        </div>
                    </form>
                </div>
        </div>
    </div>

        <!--CONTENT-->
        <div id="content">
             <div id="control-card-wrapper">
                 <div id="control-card-header">Upload Sqlite Backup</div>
                 <div id="control-card">
                    <div id="control-card-icon">
                        <img src="assets/cloud.png">
                    </div>
                    <div id="control-card-main">
                        <div>
                            Allowed file extensions :
                            <span id="hilight" style="font-size: 1.4vw;">.sqlite, .sqlite3, .csv, .db, .db3, .sql, .zip, .rar, .7z</span><br>
                            Maximum upload size allowed :  <span id="hilight">1000 MB (1.0 GB)</span>
                        </div>
                            <div id="control-card-form-controls">
                                <div id="control-card-section">
                                <!--FOR BROWSE BUTTON-->
                                <div id="browse-button-wrapper">
                                    <div id="browse-button-text">Select file for upload :</div>
                                    <input type="file" id="browse_button" class="truncated-fname" name="browse_button"/>
                                </div>
                                <div id="set-backname-wrapper">
                                    <div id="browse-button-text">Set backup name :</div>
                                    <input class="form-control" type="text" maxlength="100" id="backupname" name="backupname" /> 
                                </div>
                                </div>
                                <div id="upload-wrapper">
                                    <div id="upload-progress">
                                        <meter value=0 min=0 low=30 high=60 max=100 optimum=80 id="upload-meter"></meter>
                                    </div>
                                    <div id="upload-button-parent">
                                        <input type="submit" id="btn-upload" name="btn-upload" class="btn-success" value="Upload">
                                    </div>
                                </div>
                            </div>
                     </div>
                </div>
            </div>
            <!-- SHOW THE LIST OF UPLOADED FILES -->
            <div id="file-list-wrapper">
                Total Backup Files (<span id="file-count"></span>)
                <?php 
                    include "scanfiles.php"; 
                    echo "<script>$('#file-count').text(" . $search_found . "); </script>"; //count($files)
                ?>
                <script>
                function Delete(file)
                {
                    var conf = confirm("Delete file '" + file +"'?");
                    if (conf == true)
                    {
                        window.location.href="filedelete.php?name=" + file;
                    }
                }
                </script>
            </div>
        </div>
    
</body>
</html>