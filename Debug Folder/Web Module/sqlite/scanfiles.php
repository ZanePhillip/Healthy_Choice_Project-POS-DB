<?php

// SET TIME ZONE TO ASIA / PHILIPPINES
date_default_timezone_set('Asia/Manila');

// THE FOLDER WHERE ALL FILES ARE STORED
$path = "uploads";

// GET ALL FILES INSIDE THAT FOLDER
$files = array_diff(scandir($path), array(".", ".."));

// SEARCH
$searchName = $str_searx = "";

// SEARCH RESULT COUNT
$search_found = 0;

if (isset($_REQUEST['searchfname']))
{
    $searchName = $_REQUEST['searchfname'];
}

// IF THERE ARE FILES ...
if (!empty($files))
{
    // LOOP THRU THE FILES ..
    foreach ($files as $f)
    {
        // GET THE ACTUAL FILE NAME ..
        $temp_file = $path . "/" .$f;

        // GET FILE EXTENSION
        list($filename, $extension) = explode(".", $f);

        if (isset($_REQUEST['searchfname']) and  !empty($searchName))
        {
            $str_searx = strpos($f, $searchName);
        }

        // CHECK IF THE FILE EXISTS, THEN ADD TO LIST
        if (file_exists($temp_file))
        {
            $icon_to_use = "";
            $icon_label = "";
            $icon_accent = "";

            switch ($extension)
            {
                // sqlite", "sqlite3",  "db", "db3", "sql",
                case "zip":
                    $icon_to_use = "zip.png";
                    $icon_label = "ZIP";
                    $icon_accent = "zip-header";
                    break;
                case "rar":
                    $icon_to_use = "rar.png";
                    $icon_label = "RAR";
                    $icon_accent = "rar-header";
                    break;
                case "csv":
                    $icon_to_use = "csv.png";
                    $icon_label = "CSV";
                    $icon_accent = "csv-header";
                    break;
                case "7z":
                    $icon_to_use = "7z.png";
                    $icon_label = "7z";
                    $icon_accent = "z-header";
                    break;
                case "sqlite":
                case "sqlite3":
                case "db":
                case "db3":
                    $icon_to_use = "sqlite.png";
                    $icon_label = "SQLite";
                    $icon_accent = "sqlite-header";
                    break;
                case "sql":
                    $icon_to_use = "query.png";
                    $icon_label = "SQL";
                    $icon_accent = "sql-header";
                    break;
            }

            $createdAt = filectime($temp_file);

            //
            // FOR EMPTY / (DEFAULT) SEARCH RESULTS
            //
            if (empty($searchName))
            {
                $search_found += 1;
                echo "<div id=\"file-card\">\r\n";
                echo    "<div id=\"file-icon\">\r\n";
                echo           "<img src=\"assets/". $icon_to_use . "\" width=\"32\" height=\"32\">\r\n";
                echo           "<div id=\"" . $icon_accent . "\">" . $icon_label . "</div>\r\n";
                echo    "</div>\r\n";
                echo       "<div id=\"file-info\">\r\n";
                echo           "<div id=\"file_name\"><span id=\"" . $icon_accent . "\">" . $f . "</span></div>\r\n";
                echo           "<div id=\"file-desc\">Date Uploaded : " . date ("F d, Y H:i A.", $createdAt) . "</div>\r\n";
                echo           "<div id=\"file-action-buttons\">\r\n";
                echo           "<button class=\"file-actions\" onclick=\"window.location.href='" . $path . "/" . $f . "'\">Download</button>\r\n";
                echo           "<button type='submit' class=\"file-actions\" onclick=\"Delete('{$f}')\">Delete</button>\r\n";
                echo      "</div>\r\n";
                echo  "</div>\r\n";
                echo "</div>\r\n";
            }
            //
            // SEARCH IS NOT EMPTY
            //
            else 
            {
                if ($str_searx !== false)
                {
                    $search_found += 1;
                    echo "<div id=\"file-card\">\r\n";
                    echo    "<div id=\"file-icon\">\r\n";
                    echo           "<img src=\"assets/". $icon_to_use . "\" width=\"32\" height=\"32\">\r\n";
                    echo           "<div id=\"" . $icon_accent . "\">" . $icon_label . "</div>\r\n";
                    echo    "</div>\r\n";
                    echo       "<div id=\"file-info\">\r\n";
                    echo           "<div id=\"file_name\"><span id=\"" . $icon_accent . "\">" . $f . "</span></div>\r\n";
                    echo           "<div id=\"file-desc\">Date Uploaded : " . date ("F d, Y H:i A.", $createdAt) . "</div>\r\n";
                    echo           "<div id=\"file-action-buttons\">\r\n";
                    echo           "<button class=\"file-actions\" onclick=\"window.location.href='" . $path . "/" . $f . "'\">Download</button>\r\n";
                    echo           "<button type='submit' class=\"file-actions\" onclick=\"Delete('{$f}')\">Delete</button>\r\n";
                    echo      "</div>\r\n";
                    echo  "</div>\r\n";
                    echo "</div>\r\n";
                }
            }
            // https://stackoverflow.com/a/19323136 (delete)
            //echo $f . "Last Modified -> " . date ("F d, Y H:i A.", $createdAt) . "<br>";
        }
    }
}
?>