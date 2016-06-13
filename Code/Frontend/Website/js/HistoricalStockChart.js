google.load('visualization', '1', {'packages':['annotationchart']});
google.load("visualization", "1", {packages:["corechart"]});
google.setOnLoadCallback(loadWindow());

function loadWindow() {
	getdata0(0);
	getdata1(0);
}

function getdata0(symbolId) {
  //alert("getdata");
  $.getJSON(
    "backend/jsonsender.php", // The s/erver URL
    {id: symbolId},
    showdata0 // The function to call on completion.
  );
}

function getdata1(symbolId) {
  //alert("getdata");
  $.getJSON(
    "backend/jsonsender.php", // The s/erver URL
    {id: symbolId},
    showdata1 // The function to call on completion.
  );
}

function showdata0(json){

  //alert("showdata");
  var data = new google.visualization.DataTable();
  data.addColumn('number', 'Index of Half Month');
  data.addColumn('number', 'Bayesian');
  data.addColumn('number', 'STS');
  
  var dataLength = 200;
  var dataLength1 = 20;
  var m = -17;
  for (var i = dataLength1 - 1; i >= 0; i--){
    data.addRows([
      [m, parseFloat(json[i + dataLength * 5].ClosePrice), parseFloat(json[i + dataLength * 5 + dataLength1].ClosePriceTarget)],
    ]);
	m++;
  }


  var options = {
			  //title: 'Weighted Average Exercise Calorie in Time Span (Original Keyword)',
			  curveType: 'function',
			  vAxis: {title: 'Stock Price'},
			  hAxis: {title: 'Index of Half Month'}
			  };
			  
  var chart = new google.visualization.LineChart(document.getElementById('chart_div0'));		 

  chart.draw(data, options);
  
  
  
	
  var date2;
  var dateParts2;
  var jsDate2;
  var data2 = new google.visualization.DataTable();
  data2.addColumn('date', 'Date');
  data2.addColumn('number', 'Actual');
  data2.addColumn('number', 'EMA12');
  data2.addColumn('number', 'EMA26');
  
  for (var i = dataLength - 1; i >= 0; i--){
    date2 = json[i].Date;
    dateParts2 = date2.split("-");
    jsDate2 = new Date(dateParts2[0], dateParts2[1] - 1, dateParts2[2]);
    data2.addRows([
      [jsDate2, parseFloat(json[i].ClosePrice), parseFloat(json[i + dataLength * 5 + dataLength1 * 2].EMAS), parseFloat(json[i + dataLength * 5 + dataLength1 * 2].EMAL)],
    ]);
  }

  var chart2 = new google.visualization.AnnotationChart(document.getElementById('chart_div3'));

  var options = {
    displayAnnotations: false,
    displayExactValues : true,
    displayRangeSelector : true,
    thickness : 1.5,
    displayLegendDots : true,
    colors : ['#1a3c75','#E26D26', '#FF66FF'],
  };

  chart2.draw(data2, options);
  
  var date3;
  var dateParts3;
  var jsDate3;
  var data3 = new google.visualization.DataTable();
  data3.addColumn('date', 'Date');
  data3.addColumn('number', 'DEA');
  data3.addColumn('number', 'DIF');
  
  for (var i = dataLength - 1; i >= 0; i--){
    date3 = json[i].Date;
    dateParts3 = date3.split("-");
    jsDate3 = new Date(dateParts3[0], dateParts3[1] - 1, dateParts3[2]);
    data3.addRows([
      [jsDate3, parseFloat(json[i + dataLength * 5 + dataLength1 * 2].DEA), parseFloat(json[i + dataLength * 5 + dataLength1 * 2].DIF)],
    ]);
  }

  var chart3 = new google.visualization.AnnotationChart(document.getElementById('chart_div4'));

  var options = {
    displayAnnotations: false,
    displayExactValues : true,
    displayRangeSelector : true,
    thickness : 1.5,
    displayLegendDots : true,
    colors : ['#E26D26', '#FF66FF'],
  };

  chart3.draw(data3, options);
  
  var table = document.getElementById("recommend");
  var rowCount = table.rows.length;
  
  for (var i = 1; i < rowCount; i++) {
    table.deleteRow(1);
  }
  
  var m = 1;
  for (var i = 0; i < dataLength; i++) {  	
	
    if(parseInt(json[i + dataLength * 5 + dataLength1 * 2].Action) == 1) {
	  var row = table.insertRow(m);
      var cell0 = row.insertCell(0);
      var cell1 = row.insertCell(1);
      var cell2 = row.insertCell(2);
	  cell0.innerHTML = json[i + dataLength * 5 + dataLength1 * 2].Symbol;
	  cell1.innerHTML = json[i + dataLength * 5 + dataLength1 * 2].Date;
	  cell2.innerHTML = "BUY";
	  m++;
	}
	if(parseInt(json[i + dataLength * 5 + dataLength1 * 2].Action) == 2) {
	  var row = table.insertRow(m);
      var cell0 = row.insertCell(0);
      var cell1 = row.insertCell(1);
      var cell2 = row.insertCell(2);
	  cell0.innerHTML = json[i + dataLength * 5 + dataLength1 * 2].Symbol;
	  cell1.innerHTML = json[i + dataLength * 5 + dataLength1 * 2].Date;
	  cell2.innerHTML = "Strongly BUY";
	  m++;
	}
	if(parseInt(json[i + dataLength * 5 + dataLength1 * 2].Action) == 3) {
	  var row = table.insertRow(m);
      var cell0 = row.insertCell(0);
      var cell1 = row.insertCell(1);
      var cell2 = row.insertCell(2);
	  cell0.innerHTML = json[i + dataLength * 5 + dataLength1 * 2].Symbol;
	  cell1.innerHTML = json[i + dataLength * 5 + dataLength1 * 2].Date;
	  cell2.innerHTML = "SELL";
	  m++;
	}
	if(parseInt(json[i + dataLength * 5 + dataLength1 * 2].Action) == 4) {
	  var row = table.insertRow(m);
      var cell0 = row.insertCell(0);
      var cell1 = row.insertCell(1);
      var cell2 = row.insertCell(2);
	  cell0.innerHTML = json[i + dataLength * 5 + dataLength1 * 2].Symbol;
	  cell1.innerHTML = json[i + dataLength * 5 + dataLength1 * 2].Date;
	  cell2.innerHTML = "Strongly SELL";
	  m++;
	}
	
	
  }
  
  
}

function showdata1(json){
	
  var dataLength = 200;
  var dataLength1 = 20;
	
  var predictTable = document.getElementById('predict');
  var errorTable = document.getElementById('error');
  
  for(var i = 1; i <= 4; i++) {
  	predictTable.rows[i].cells[0].innerHTML = json[0].Symbol;
  	errorTable.rows[i].cells[0].innerHTML = json[0].Symbol;
  }
  
  predictTable.rows[1].cells[2].innerHTML = json[dataLength * 6 + dataLength1 * 2].ClosePriceTarget1;
  predictTable.rows[1].cells[3].innerHTML = json[dataLength * 6 + dataLength1 * 2].ClosePriceTarget2;
  
  predictTable.rows[2].cells[2].innerHTML = json[dataLength * 6 + dataLength1 * 2 + 1].ClosePriceTarget1;
  predictTable.rows[2].cells[3].innerHTML = json[dataLength * 6 + dataLength1 * 2 + 1].ClosePriceTarget2;
  
  predictTable.rows[3].cells[2].innerHTML = json[dataLength * 6 + dataLength1 * 2 + 2].ClosePriceTarget;
  predictTable.rows[3].cells[3].innerHTML = json[dataLength * 6 + dataLength1 * 2 + 3].ClosePriceTarget;
  
  predictTable.rows[4].cells[2].innerHTML = json[dataLength * 6 + dataLength1 * 2 + 4].ClosePriceTarget;
  predictTable.rows[4].cells[3].innerHTML = json[dataLength * 6 + dataLength1 * 2 + 5].ClosePriceTarget;
  
  errorTable.rows[1].cells[2].innerHTML = Math.round(json[dataLength * 6 + dataLength1 * 2 + 6].avg * 100.0) / 100.0;
  errorTable.rows[2].cells[2].innerHTML = Math.round(json[dataLength * 6 + dataLength1 * 2 + 7].avg * 100.0) / 100.0;
  errorTable.rows[3].cells[2].innerHTML = Math.round(json[dataLength * 6 + dataLength1 * 2 + 8].avg * 100.0) / 100.0;
  errorTable.rows[4].cells[2].innerHTML = Math.round(json[dataLength * 6 + dataLength1 * 2 + 9].avg * 100.0) / 100.0;
  
  
  //alert("showdata");
  var date;
  var dateParts;
  var jsDate;
  var data = new google.visualization.DataTable();
  data.addColumn('date', 'Date');
  data.addColumn('number', 'Actual');
  data.addColumn('number', 'Bayesian');
  data.addColumn('number', 'STS');
  data.addColumn('number', 'SVM');
  data.addColumn('number', 'ANN');
  
  
  
  for (var i = dataLength - 1; i >= 0; i--){
    date = json[i].Date;
    dateParts = date.split("-");
    jsDate = new Date(dateParts[0], dateParts[1] - 1, dateParts[2]);
    data.addRows([
      [jsDate, parseFloat(json[i].ClosePrice), parseFloat(json[i + dataLength].ClosePriceTarget0), parseFloat(json[i + dataLength * 2].ClosePriceTarget0), parseFloat(json[i + dataLength * 3].ClosePriceTarget), parseFloat(json[i + dataLength * 4].ClosePriceTarget)],
    ]);
  }


  var chart = new google.visualization.AnnotationChart(document.getElementById('chart_div1'));

  var options = {
    displayAnnotations: false,
    displayExactValues : true,
    displayRangeSelector : true,
    thickness : 1.5,
    displayLegendDots : true,
    colors : ['#1a3c75','#E26D26', '#FF66FF', '#0000FF', '#9900FF'],
  };

  chart.draw(data, options);
  
  var date2;
  var dateParts2;
  var jsDate2;
  var data2 = new google.visualization.DataTable();
  data2.addColumn('date', 'Date');
  data2.addColumn('number', 'Bayesian');
  data2.addColumn('number', 'STS');
  data2.addColumn('number', 'SVM');
  data2.addColumn('number', 'ANN');
  
  var dataLength2 = 200;
  for (var i = dataLength2 - 1; i >= 0; i--){
    date2 = json[i].Date;
    dateParts2 = date2.split("-");
    jsDate2 = new Date(dateParts2[0], dateParts2[1] - 1, dateParts2[2]);
    data2.addRows([
      [jsDate2, parseFloat(json[i + dataLength2].RelativeDifference), parseFloat(json[i + dataLength2 * 2].RelativeDifference), parseFloat(json[i + dataLength2 * 3].RelativeDifference), parseFloat(json[i + dataLength2 * 4].RelativeDifference)],
    ]);
  }


  var chart2 = new google.visualization.AnnotationChart(document.getElementById('chart_div2'));

  var options = {
    displayAnnotations: false,
    displayExactValues : true,
    displayRangeSelector : true,
    thickness : 1.5,
    displayLegendDots : true,
    colors : ['#E26D26', '#FF66FF', '#0000FF', '#9900FF'],
  };

  chart2.draw(data2, options);
}

function select_symbol0(sel){
	getdata0(sel.value);
}

function select_symbol1(sel){
	getdata1(sel.value);
}

   