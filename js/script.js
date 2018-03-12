
$(function(){
    let latelyTableHead = $('#latelyTableHead');
    let latelyTableBody = $('#latelyTableBody');
    let todaysMarketTableHead = $('#todaysMarketTableHead');
    let todaysMarketTableBody = $('#todaysMarketTableBody');
    let costTableHead = $('#costTableHead');
    let costTableBody = $('#costTableBody');
    let summaryTableHead = $('#summaryTableHead');
    let summaryTableBody = $('#summaryTableBody');
    let houseData = $('#houseData');
    let specification = $('#specification');
    let situation = $('#situation');
    let graph = $('#graph');
    var reportName;

    let pathToXLFile = 'xl/report.xlsx';
    //get data from Xl (all sheets)
    getXlsxData(pathToXLFile).then((mydata)=>{
        //send the data to print
        printTable(mydata[1],latelyTableHead,latelyTableBody);
        printTable(mydata[2],todaysMarketTableHead,todaysMarketTableBody);
        printTable(mydata[3],costTableHead,costTableBody);
        printTable(mydata[4],summaryTableHead,summaryTableBody);
    
        //prints the general data
        $.each(Object.keys(mydata[0][0]), (i,key) =>{
            if(i < 9 ){
                houseData.append(`<li><b>${key}:</b>  ${mydata[0][0][key]}</li>`);
                if(key == 'כתובת מלאה'){
                    reportName = mydata[0][0][key];
                }
            }
            if(i > 8 && i < Object.keys(mydata[0][0]).length -2){
                specification.append(`<li><b>${key}:</b>  ${mydata[0][0][key]}</li>`);
            }
            if(key == 'מצב הנכס'){
                situation.append(mydata[0][0][key]);
            }
            if(key == 'ניתוח גרף'){
                graph.append(mydata[0][0][key]);
            }
         });
    });

    //download pdf
    $('#dowmloadPDF').click(()=>{
        bildpdf(reportName);
     });


});

//function that prints all tables
function printTable(myTable,tableHead,tableBody){
    let keys = Object.keys(myTable[0]);
    $.each(keys,function(i , key){
        if(key == undefined){
            tableHead.append(`<th></th>`);
        }else{
            tableHead.append(`<th>${key}</th>`);
        }     
    });
    $.each(myTable,function(i , row){
        tableBody.append(`<tr>`);
        for (let k = 0; k < keys.length; k++) {
            if(row[keys[k]] == undefined){
                tableBody.append(`<td></td>`);
            }else{
                tableBody.append(`<td>${row[keys[k]]}</td>`);
            }  
        } 
        tableBody.append(`</tr>`);
    });
}

var getXlsxData = (path) =>{
    return new Promise(function(resolve, reject) {
        /* set up XMLHttpRequest */
        var numOfSheets = 5
        var url =  path;
        var oReq = new XMLHttpRequest();
        oReq.open("GET", url, true);
        oReq.responseType = "arraybuffer";
        oReq.onload = function(e) {
        var arraybuffer = oReq.response;
        
        /* convert data to binary string */
        var data = new Uint8Array(arraybuffer);
        var arr = new Array();
        for(var i = 0; i != data.length; ++i) arr[i] = String.fromCharCode(data[i]);
        var bstr = arr.join("");
        
        /* Call XLSX */
        var workbook = XLSX.read(bstr, {type:"binary"});
        
        /* DO SOMETHING WITH workbook HERE */
        var mydata = [];
        // push all sheets into mydata
        for (let i = 0; i < numOfSheets; i++) {
            var sheet_name = workbook.SheetNames[i];
            /* Get worksheet */
            var worksheet = workbook.Sheets[sheet_name];
            mydata.push((XLSX.utils.sheet_to_json(worksheet,{raw:true})));
        }
        if ( mydata ) {
            resolve(mydata);
            } else {
            reject(Error("It broke"));
            }
        }

        oReq.send();
    });
}

//pdf
function first() {
    return new Promise(resolve => {
        html2canvas(document.querySelector("#main")).then(canvas => {
        resolve(canvas);
      });
    });
  }
  function second() {
    return new Promise(resolve => {
        html2canvas(document.querySelector("#main2")).then(canvas2 => {
        resolve(canvas2);
      });
    });
  }
  
  async function bildpdf(reportName) {

    var pdf = new jsPDF('p', "mm", "a4");

    var imgData1 = await first();
    var imgData2 = await second();
    var canvasArr = [imgData1,imgData2];

    var width = pdf.internal.pageSize.width;    
    var height = pdf.internal.pageSize.height;
    var imgWidth = 210; 
    var pageHeight = 295;  

    canvasArr.forEach((canvasData,i)=>{
        var imgHeight = canvasData.height * imgWidth / canvasData.width;
        pdf.addImage(canvasData.toDataURL('image/png'), 'PNG',0, 10, imgWidth, imgHeight);
        if(i < canvasArr.length -1){
            pdf.addPage();
        }
        
    });
    pdf.save(reportName +'.pdf');
  }
   