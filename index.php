<?php
//on upload
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name = htmlspecialchars($_POST['folderName']);
    //for correct path with no spaces 
    $folderName = str_replace(" ","_",$name);
    mkdir('reports/'.$folderName);
    mkdir('reports/'.$folderName.'/xl');
    mkdir('reports/'.$folderName.'/img');
    //sort the files in folders
    foreach ($_FILES['files']['name'] as $i => $name) {
        if (strlen($_FILES['files']['name'][$i]) > 1) {
            $extention = explode(".", strtolower($_FILES['files']['name'][$i]));
            if( $extention[0] == 'graph'){
                mkdir('reports/'.$folderName.'/graph');
                move_uploaded_file($_FILES['files']['tmp_name'][$i], 'reports/'.$folderName.'/graph'.'/'.$name);        
            }
            else if($extention[1] == 'xlsx'){
                move_uploaded_file($_FILES['files']['tmp_name'][$i], 'reports/'.$folderName.'/xl'.'/'.$name);
            }
            else if($extention[1] == 'jpg' || $extention[1] == 'png'){
                move_uploaded_file($_FILES['files']['tmp_name'][$i], 'reports/'.$folderName.'/img'.'/'.$name);  
            }
            else{
                move_uploaded_file($_FILES['files']['tmp_name'][$i], 'reports/'.$folderName.'/'.$name);
            }
            

        }
    }
}
?>

<html lang="he">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="css/style.css" rel="stylesheet">
    <title>In House</title>
</head>
<body dir="rtl">
   
    <div id="main">
        <h1>In House</h1>
        <img src="logo.png" alt="logo" id="logo">
        <h2>דו"חות</h2>
        <ol>
        <?php 
        $dir = "reports/";
        // Open a directory, and read its contents
        if (is_dir($dir)){
            if ($dh = opendir($dir)){
                while (($file = readdir($dh)) !== false){
                    if ($file == '.' || $file == '..') continue;
                ?>
                <li> <a href="reports/<?=$file?>/report.php"> <?=str_replace('_', ' ',$file)?></a></li>
                <?php
                }
                closedir($dh);
            }
        }
        ?>
        </ol>
    
        <div id="form">
            <h2>דו"ח חדש</h2>
            <form method="post" action="index.php" enctype="multipart/form-data">
            <p>
                שם הדוח: <input type="text" name="folderName" placeholdae="folder name" required>
            </p>
            <p>
                <input type="file" name="files[]" id="files" multiple="" directory="" webkitdirectory="" mozdirectory="" required>
                <input class="button" type="submit" value='ייצר דו"ח' />
            </p>
            </form>
        <div>
    </div>
    <div id="instructions">
        <h3>הוראות להעלת דו"ח חדש</h3>
        <ol>
            <li>
                בתיקייה צריכים להיות הקבצים הבאים:
                <ul>
                    <li>קובץ שנקרה report.php  חובה</li>
                    <li>קובץ XL שנקרה report.xlsx חובה</li>
                    <li>תמונות במידת הצורך</li>
                </ul>
            </li>
            <li>במידה ורוצים להעולות גרף, שם התמונה חייב להיות graph. מה שבא אחרי הנקודה יכול להיות png ,jpeg או jpg לא באמת משנה.</li>  
        </ol>
    </div>

    <div id="footer">
        <p>In-House</p>
      </div>
</body>
</html>


<?php

?>