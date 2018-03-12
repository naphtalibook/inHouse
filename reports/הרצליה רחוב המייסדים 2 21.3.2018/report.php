<!DOCTYPE html>
<html lang="he">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="../../css/report.css" rel="stylesheet">
    <title>In Iouse</title>
</head>
<body dir="rtl">
  <button id="dowmloadPDF">הורד קובץ <span dir="ltr">pdf</span></button>

  <div id="main">

      <img src="../../logo.png" alt="logo" id="logo">
      <h1>דו"ח לקוח - <span dir="ltr">In House</span></h1>

      <div id="details" class="clearfix">

        <div class="ul">
          <h3>נתונים כללים</h3>
          <ul id="houseData">
          </ul>
        </div>

        <div class="ul">
          <h3>תיאור סביבת הנכס</h3>
          <h4>מפרט:</h4>
          <ul id="specification">
          </ul>
        </div>

        <div class="ul">
          <h3>מצב הנכס</h3>
          <h4 id="situation"></h4>
          <p>חדש מקבלן ,חדש ,משופץ ,שמור ,סביר ,לשיפוץ </p>
        </div>
      </div>

      <div id="images">
      <?php 
        $dir = "img/";

        // Open a directory, and read its contents
        if (is_dir($dir)){
          if ($dh = opendir($dir)){
            while (($file = readdir($dh)) !== false){
                if ($file == '.' || $file == '..' ||  $file == 'graph.jpg') continue;
            ?>
            <img src="img/<?=$file?>">
            <?php
            }
            closedir($dh);
          }
        }
        ?>   
      </div>

      <div class="table">
        <h5>סקירת עסקאות שנסגרו בתקופה האחרונה</h5>
        <table>
          <thead>
            <tr id="latelyTableHead"></tr>
          </thead>
          <tbody id="latelyTableBody">
          </tbody>
        </table>
      </div>

      <div class="table">
        <h5>סקירת עסקאות שקיימות היום בשוק</h5>
        <table>
          <thead>
            <tr id="todaysMarketTableHead"></tr>
          </thead>
          <tbody id="todaysMarketTableBody">
          </tbody>
        </table>
      </div>
    
  </div>
 <!-- #main and #main2 are for cuting the pdf in to 2 canvases -->
  <div id="main2">
    
      <?php 
        $graph = "graph/";
        // Open a directory, and read its contents
        if (is_dir($graph)){
          if ($dh = opendir($graph)){
            while (($file = readdir($dh)) !== false){
                if ($file == '.' || $file == '..') continue;
            ?>
            <div id="graphImg">
              <img src="graph/<?=$file?>" width="500px">
            </div> 
            <?php
            }
            ?>
            <p><b>ניתוח גרף:</b> <span id="graph"></span></p>
            <?php
            closedir($dh);
          }
        }

      ?>
        
        <div class="table">
          <h5>הערכות שווי</h5>
          <table>
            <thead>
              <tr id="costTableHead"></tr>
            </thead>
            <tbody id="costTableBody">
            </tbody>
          </table>
        </div>

          <h2>תוצאות הדו"ח</h2>
          <div class="table">
            <table>
              <thead>
                <tr id="summaryTableHead"></tr>
              </thead>
              <tbody id="summaryTableBody">
              </tbody>
            </table>
            <p>** יצוין כי דו"ח הערכת השווי אינו מהווה שומה על פי תקנות שמאי מקרקעין            
                התשכ"ו (1966).</p>
          </div>
        
        <div id="footer">
          <p>In-House</p>
        </div>
    </div>
  </div>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.debug.js"></script>
<script src="../../js/jquery-3.2.1.min.js"></script>
<script src="../../js/xlsx.full.min.js"></script>
<script src="../../js/script.js"></script>
</body>
</html>